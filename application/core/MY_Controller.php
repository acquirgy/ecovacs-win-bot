<?php
/**
 * A base controller for CodeIgniter with view autoloading, layout support,
 * model loading, helper loading, asides/partials and per-controller 404
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-controller
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

class MY_Controller extends CI_Controller
{

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * The current request's view. Automatically guessed
     * from the name of the controller and action
     */
    protected $view = '';

    /**
     * An array of variables to be passed through to the
     * view, layout and any asides
     */
    protected $data = array();

    /**
     * The name of the layout to wrap around the view.
     */
    protected $layout;

    /**
     * An arbitrary list of asides/partials to be loaded into
     * the layout. The key is the declared name, the value the file
     */
    protected $asides = array();

    /**
     * A list of models to be autoloaded
     */
    protected $models = array();

    /**
     * A formatting string for the model autoloading feature.
     * The percent symbol (%) will be replaced with the model name.
     */
    protected $model_string = '%_model';

    /**
     * A list of helpers to be autoloaded
     */
    protected $helpers = array();
    protected $stylesheets = array();
    protected $javascripts = array();

    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the controller, tie into the CodeIgniter superobject
     * and try to autoload the models and helpers
     */
    public function __construct()
    {
        parent::__construct();

        $this->_load_models();
        $this->_load_helpers();

        $this->authenticated_user = false;

        //Start session
        session_start();

        // Stop writing to session if is ajax request
        if(is_ajax()) session_write_close();

        // Store src if set in the query string
        if($this->input->get('src')) $this->session->set_userdata('src', $this->input->get('src'));
        if($this->input->get('SRC')) $this->session->set_userdata('src', $this->input->get('SRC'));

        if(!$this->input->is_cli_request()) {

            // Deal with admin side
            if ($this->uri->segment(1) == 'admin') {

                // User is not authenticated, but is trying to login
                if ($this->uri->segment(2) == 'authentication') {

                    $this->layout = 'layouts/admin';

                } else if ($this->session->userdata('user_id') || !isset($_SERVER['SERVER_NAME']) || !isset($_SERVER['REQUEST_METHOD'])) {

                    // User is authenticated
                    $this->authenticated_user = $this->user_model->get($this->session->userdata('user_id'));

                    // Make sure this user has the admin role
                    if($this->authenticated_user['role'] != 'admin') {
                        $this->session->set_flashdata('error','You are not authenticated to view this page.');
                        redirect('/admin/authentication/login');
                    }

                    $this->layout = 'layouts/admin';

                } else {

                    $this->session->unset_userdata();
                    $this->session->set_flashdata('error','You are not authenticated to view this page.');
                    redirect('/admin/authentication/login');

                }

            }

            // Deal with client portal
            if ($this->uri->segment(1) == 'client') {

                if ($this->session->userdata('user_id') || !isset($_SERVER['SERVER_NAME']) || !isset($_SERVER['REQUEST_METHOD'])) {

                    // User is authenticated
                    $this->authenticated_user = $this->user_model->get($this->session->userdata('user_id'));
                    $this->layout = 'layouts/client';

                } else if ($this->uri->segment(2) == 'authentication') {

                    // User is not authenticated, but is trying to login
                    $this->layout = 'layouts/client';

                } else {

                    $this->session->unset_userdata();
                    $this->session->set_flashdata('error','You are not authenticated to view this page.');
                    redirect('/client/authentication/login');

                }

            }

        }

    }

    /* --------------------------------------------------------------
     * VIEW RENDERING
     * ------------------------------------------------------------ */

    /**
     * Override CodeIgniter's despatch mechanism and route the request
     * through to the appropriate action. Support custom 404 methods and
     * autoload the view into the layout.
     */
    public function _remap($method)
    {
        if (method_exists($this, $method))
        {
            call_user_func_array(array($this, $method), array_slice($this->uri->rsegments, 2));
        }
        else
        {
            if (method_exists($this, '_404'))
            {
                call_user_func_array(array($this, '_404'), array($method));
            }
            else
            {
                show_404(strtolower(get_class($this)).'/'.$method);
            }
        }

        $this->_load_view();
    }

    /**
     * Automatically load the view, allowing the developer to override if
     * he or she wishes, otherwise being conventional.
     */
    protected function _load_view()
    {
        // If $this->view == FALSE, we don't want to load anything
        if ($this->view !== FALSE)
        {
            // If $this->view isn't empty, load it. If it isn't, try and guess based on the controller and action name
            $view = (!empty($this->view)) ? $this->view : $this->router->directory . $this->router->class . '/' . $this->router->method;

            if(!empty($this->view)) {
                $view = $this->view;
            } else if($this->uri->segment(1) == 'admin' || $this->uri->segment(1) == 'client') {
                $view = $this->router->directory . $this->router->class . '/' . $this->router->method;
            } else {
                $view = 'front/' . $this->router->directory . $this->router->class . '/' . $this->router->method;
            }

            // Load the view into $yield
            $data['yield'] = $this->load->view($view, $this->data, TRUE);

            // Do we have any asides? Load them.
            if (!empty($this->asides))
            {
                foreach ($this->asides as $name => $file)
                {
                    $data['yield_'.$name] = $this->load->view($file, $this->data, TRUE);
                }
            }

            // Load in our existing data with the asides and view
            $data = array_merge($this->data, $data);
            $layout = FALSE;

            // Set Javascripts && CSS
            $section = ($this->uri->segment(1) != 'admin' && $this->uri->segment(1) != 'client') ? 'front' : $this->uri->segment(1);

            $javascript = $section . '/' . $this->router->class . '/' . $this->router->method . '.js';
            if (file_exists('assets/javascripts/' . $javascript))
                $this->javascripts[] = $javascript;

            $stylesheet = $section . '/' . $this->router->class . '/' . $this->router->method . '.css';
            if (file_exists('assets/stylesheets/' . $stylesheet))
                $this->stylesheets[] = $stylesheet;

            $data['stylesheets'] = $data['javascripts'] = '';

            foreach($this->stylesheets as $stylesheet) {
                $data['stylesheets'] = '<link rel="stylesheet" href="/assets/stylesheets/' . $stylesheet . '">';
            }
            foreach($this->javascripts as $javascript) {
                $data['javascripts'] = '<script type="text/javascript" src="/assets/javascripts/' . $javascript . '"></script>';
            }
            // If we didn't specify the layout, try to guess it
            if (!isset($this->layout))
            {
                if (file_exists(APPPATH . 'views/layouts/' . $this->router->class . '.php'))
                {
                    $layout = 'layouts/' . $this->router->class;
                }
                else
                {
                    $layout = 'layouts/application';
                }
            }

            // If we did, use it
            else if ($this->layout !== FALSE)
            {
                $layout = $this->layout;
            }

            // If $layout is FALSE, we're not interested in loading a layout, so output the view directly
            if ($layout == FALSE)
            {
                $this->output->set_output($data['yield']);
            }

            // Otherwise? Load away :)
            else
            {
                $this->load->view($layout, $data);
            }
        }
    }

    /* --------------------------------------------------------------
     * MODEL LOADING
     * ------------------------------------------------------------ */

    /**
     * Load models based on the $this->models array
     */
    private function _load_models()
    {
        foreach ($this->models as $model)
        {
            $this->load->model($this->_model_name($model), $model);
        }
    }

    /**
     * Returns the loadable model name based on
     * the model formatting string
     */
    protected function _model_name($model)
    {
        return str_replace('%', $model, $this->model_string);
    }

    /* --------------------------------------------------------------
     * HELPER LOADING
     * ------------------------------------------------------------ */

    /**
     * Load helpers based on the $this->helpers array
     */
    private function _load_helpers()
    {
        foreach ($this->helpers as $helper)
        {
            $this->load->helper($helper);
        }
    }
}