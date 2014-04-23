  <?= form_open('/main/submit', array('class' => 'cart-form')) ?>
    <div class="w1 inner gradient">
        <div id="wrapper">
            <!-- header -->
            <header id="header">
                <div class="wrapper">
                    <!-- logo -->
                    <strong class="logo"><a href="#">ECOVAS | Live Smart. Enjoy Life.</a></strong>
                    <!-- logotype -->
                    <strong class="logotype">WINBOT &trade;</strong>
                    <!-- phone -->
                    <span class="phone">For more information or to order by phone, call: <strong>(888) 966-0895</strong></span>
                </div>
                <!-- slogan -->
                <strong class="slogan">30-Day Risk-Free Trial!</strong>
            </header>
            <!-- main -->
            <div id="main">

                <!-- section -->
                <section class="section">
                    <h1>Preview Your Cart:</h1>
                    <div class="preview-area same">
                        <!-- preview-table -->
                        <div class="preview-table">
                            <table class="order-lines">
                                <thead>
                                  <tr>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Item Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($products as $product) { ?>
                              <tr class="product-<?= $product['id'] ?> hidden" data-price="<?= $product['price'] ?>">
                                  <td>
                                    <?= form_hidden('order_line[' . $product['id'] . '][id]', $product['id']) ?>
                                    <?= form_input('order_line[' . $product['id'] . '][qty]', 0, 'class="qty"') ?>
                                </td>
                                <td><?= $product['title'] ?></td>
                                <td>
                                    <?php if($product['price'] == 0) { ?>
                                    <span style="color:Red;font-weight:bold;">FREE</span>
                                    <?php } else{ ?>
                                        <?= $product['price'] ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($product['id'] != 1 && $product['id'] != 2 && $product['id'] != 7) { ?>
                                    <a href="#" class="remove" data-id="<?= $product['id'] ?>">X</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- product -->
                <div class="product same-height">
                    <h2>30-Day Risk-Free Trial Package:</h2>
                    <div class="image">
                        <img src="/assets/images/image02.png" width="387" height="284" alt="image description"></div>
                        <div class="holder">
                            <ul class="list">
                                <li>WINBOT Window Cleaning Robot</li>
                                <li>2 Sets of Microfiber Cleaning Pads</li>
                                <li>Professional Cleaning Solution</li>
                                <li>Remote Control and Batteries</li>
                                <li>Safety Pod and Safety Rope</li>
                                <li>Power Adapter</li>
                            </ul>
                            <ul class="list">
                                <li>3 FREE Bonus Sets of Microfiber Cleaning Pads</li>
                                <li>FREE Cleaning Solution 70.5 oz</li>
                                <li>FREE Extension Cord 4'9"</li>
                                <li>FREE Finishing Cloth</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section -->
            <section class="section">
                <div id="pnlUpsells">
                    <h1>Clean Even More:</h1>
                    <div class="columns">
                        <?php foreach($upsells as $upsell) { ?>
                        <article class="col">
                            <img src="/assets/<?=$upsell['image'];?>" width="104" height="83" alt="image description">
                            <div class="holder">
                                <h2><?=$upsell['title'];?></h2>
                                <span class="price"><?=$upsell['price'];?></span>
                                <?php echo form_hidden('id', $upsell['id']) ?>
                                <a href="#" class="add button" data-id="<?= $upsell['id'] ?>">Add to Cart</a>
                            </div>
                        </article>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <section class="section">
                <h1>Risk-Free Checkout:</h1>
                <!-- form -->

                <div id="form" class="form same">
                    <fieldset>
                        <div class="column-holder">
                            <!-- column -->
                            <div class="column same-height">
                                <div class="text-block">
                                    <h2>Your Information:</h2>
                                    <p>You’re almost done! Just fill in the  information below.</p>
                                </div>
                                <div class="block">
                                    <div class="row">
                                        <?= form_error('email');?>
                                        <label for="emailField">Email Address:</label>
                                        <div class="int-holder">
                                            <input id="email" type="email" name="email" class="required email" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?= form_error('con_email');?>
                                        <label for="confirmEmailField">Confirm Email:</label>
                                        <div class="int-holder">
                                            <input id="confirmEmailField" name="confirmEmail" type="email" class="required email" equalTo="#email"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?= form_error('b_first_name');?>
                                        <label for="b_first_name">First Name:</label>
                                        <div class="int-holder">
                                           <input id="b_first_name" name="b_first_name" type="text" class="required"/>
                                       </div>
                                   </div>
                                   <div class="row">
                                    <?= form_error('b_last_name');?>
                                    <label for="b_last_name">Last Name:</label>
                                    <div class="int-holder">
                                        <input id="b_last_name" name="b_last_name" type="text" class="required"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="Country">Country:</label>
                                    <div class="int-holder">
                                        <select id="Country" name="Country" class="text" style="width:137px;">
                                            <option value="United States" selected>United States</option>
                                            <option value="Canada" >Canada</option>
                                            <option value="Puerto Rico" >Puerto Rico</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <?= form_error('b_address');?>
                                    <label for="b_address">Address:</label>
                                    <div class="int-holder">
                                        <input id="b_address" name="b_address" type="text" class="required check-PObox"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <?= form_error('b_apt');?>
                                    <label for="b_apt">Suite or Apt:</label>
                                    <div class="int-holder">
                                        <input id="b_apt" name="b_apt" placeholder="optional" type="text"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <?= form_error('b_city');?>
                                    <label for="b_city">City:</label>
                                    <div class="int-holder">
                                        <input ID="b_city" name="b_city" type="text" class="required"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="state_province">State/Province:</label>
                                    <div class="int-holder" id="state_province">
                                        <?= form_dropdown('b_state', states(), null, 'class="b_states required"') ?>
                                        <?= form_dropdown('b_province', provinces(), null, 'class="b_province hidden"') ?>

                                        <select id="b_region" name="b_region" class="text hidden">
                                            <option value="PR">Puerto Rico</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="b_zip">Zip/Postal Code:</label>
                                    <div class="int-holder">
                                        <input type="text" id ="b_zip" name="b_zip" class="zip"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="phone">Phone Number:</label>
                                    <div class="int-holder">
                                        <input name="phone" placeholder="Enter 10 digits only" type="text" class="required phone" />
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="tbxExt">Extension:</label>
                                    <div class="int-holder">
                                        <input id="tbxExt" name="phone-extension" placeholder="optional" type="text" />
                                    </div>
                                </div>
                                <!-- check-box -->
                                <div class="check-box">
                                    <input id="ckbxAddressDiffer" name="ckbxAddressDiffer" type="checkbox"/>
                                    <label for="ckbxAddressDiffer">Shipping Address is different</label>
                                </div>
                            </div>
                            <br />
                            <!-- Shipping Address Block -->
                            <div id="pnlShipAddress" class="hidden shipping-address">

                                <div class="block">
                                    <div class="row">
                                        <?= form_error('s_first_name');?>
                                        <label for="s_first_name">Ship First Name:</label>
                                        <div class="int-holder">
                                            <input id="s_first_name" type="text" name="s_first_name" class="required"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="s_last_name">Ship Last Name:</label>
                                        <div class="int-holder">
                                            <input id="s_last_name" type="text" name="s_last_name" class="required"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="s_country">Country:</label>
                                        <div class="int-holder">
                                         <select id="s_country" name="s_country" class="text">
                                            <option value="United States" selected="selected">United States</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="s_address">Address:</label>
                                    <div class="int-holder">
                                        <input id="s_address" type="text" name="s_address" class="required">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="s_apt">Suite or Apt:</label>
                                    <div class="int-holder">
                                        <input id="s_apt" type="text" name="s_apt" placeholder="optional" />
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="s_city">City:</label>
                                    <div class="int-holder">
                                       <input id="s_city" type="text" name="s_city" class="required">
                                   </div>
                               </div>
                               <div class="row">
                                <label for="shipState">State/Province:</label>
                                <div class="int-holder" id="Ship_state_province">
                                    <?= form_dropdown('s_state', states(), null, 'class="s_states"') ?>
                                    <?= form_dropdown('s_province', provinces(), null, 'class="s_province hidden"') ?>
                                    <select id="s_region" name="s_region" class="text hidden">
                                        <option value="PR">Puerto Rico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="s_zip">Zip/Postal Code:</label>
                                <div class="int-holder">
                                   <input id="s_zip" type="text" name="s_zip" class="zip">
                                   <span class="hidden zip-error error">Please enter a valid zip code</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- end column 1-->
               <!-- column -->
               <div class="column same-height">
                <!-- radio-box Payment Options-->
                <div class="radio-box">
                    <h2>Payment Options:</h2>
                    <a href="#popup8" class="link lightbox" style="margin: -23px 140px 10px"><small>See Details</small></a>
                    <div class="row">
                        <input id="multipay" name="payment-option" type="radio" value="multipay" checked="checked"/>
                        <label id="lblMultiPayRadio" for="multiPay">Multi-Pay: 5 Payments of $79.99</label>
                    </div>
                    <div class="row">
                        <input id="singlepay" name="payment-option" type="radio" value="singlepay"/>
                        <label id="lblSinglePayRadio" for="singlePay">Single Pay $399.95"</label>
                    </div>
                    <div id="Note">
                        <strong>Wait! Choose Single Pay and Receive FREE Shipping!</strong>
                    </div>
                </div>
                <!-- radio-box Shipping Methods -->
                <div class="radio-box">
                    <h2>Shipping Methods:</h2>
                    <a href="#popup9" class="link lightbox" style="margin: -23px 145px 10px"><small>See Details</small></a>
                    <div class="row">
                        <input id="standardShip" value="Standard" type="radio" checked="checked" name="shipping" />
                        <label for="standardShip">Standard Shipping 2-4 weeks <span class="standard shipping-total"></span></label>
                    </div>
                    <div id="expedite" class="row">
                        <input id="rushShip" type="radio" name="shipping" value="Rush" />
                        <label for="rushShip">Expedited Shipping 7-10 Days <span class="rush shipping-total hidden"></label>
                    </div>
                </div>
                <div class="block">
                    <h2>Credit Card Information:</h2>
                    <div class="row">
                        <label for="cardType">Credit Card Type:</label>
                        <div class="int-holder">
                            <select id="cardType" class="card" name="cardType" style="width:125px;">
                                <option value="Visa" selected="selected">Visa</option>
                                <option value="Master Card" >Master Card</option>
                                <option value="American Express" >American Express</option>
                                <option value="Discover" >Discover</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="ccNumber">Card Number:</label>
                        <div class="int-holder">
                            <input id="ccNumber" name="ccNumber" type="text" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row">
                        <label>Expiration Date:</label>
                        <div class="int-holder">
                            <select id="expireMonth" name="expireMonth" class="expiration">
                                <option selected="selected" value="">Month</option>
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">Aug</option>
                                <option value="9">Sept</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                            <select name="expireYear" id="expireYear" class="expiration">
                             <option selected="selected" value="">Year</option>
                             <option value="2014">2014</option>
                             <option value="2015">2015</option>
                             <option value="2016">2016</option>
                             <option value="2017">2017</option>
                             <option value="2018">2018</option>
                             <option value="2019">2019</option>
                             <option value="2020">2020</option>
                             <option value="2021">2021</option>

                         </select>
                     </div>
                 </div>
                 <div class="row">
                    <label for="tbxCVC">CVC Code:</label>
                    <div class="wrapper">
                        <div class="int-holder width01">
                            <input name="tbxCVC" type="text" id="tbxCVC" autocomplete="off" />
                        </div>
                        <a class="thumbnail link" href="#thumb">What’s This?<span><img src="/assets/images/cvv2.jpg" /></span></a>
                    </div>
                </div>
                <!-- check-box -->
                <div class="check-box">
                    <input id="receiveEmail" type="checkbox" name="receiveEmail"/>
                    <label for="receiveEmail">Receive News &amp; Promotions by Email</label>
                    <input id="opt-out" type="hidden" value="1" name="opt-in" />
                </div>

            </div>
            <div style="margin: 15px 0 0 -27px; ">
                <label for="discount-code">Coupon Code</label>
                <input class="discount-code" name="discount-code" type="text" style="width:75px;" />&nbsp;&nbsp;
                <button class="submit-discount" style="color:#8B6B3F;">Apply</button>
            </div>
        </div>
    </div>
    <!-- column -->
    <div class="column alt same-height">
        <strong class="title">
            <b>30-DAY RISK-FREE TRIAL</b>
            <span>100% MONEY-BACK GUARANTEE!</span>
        </strong>
        <div class="order-area">
            <h2>Confirm Your Order:</h2>
            <!-- order-table -->
            <div class="order-table">
                <div>
                    <table class="order-lines" cellspacing="0" cellpadding="2" rules="all" border="1" id="confirm" style="border-collapse: collapse;">
                        <thead>
                        <tr>
                            <th scope="col">Item Description</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                      <tbody>
                        <?php foreach($products as $product) { ?>
                            <tr class="product-<?= $product['id'] ?> hidden" data-price="<?= $product['price'] ?>">
                            <td><span><?= $product['title'] ?></span></td>
                            <td>
                                <?= form_input(array('name' => '[' . $product['id'] . '][qty]', 'value' => '0', 'class' => 'qty', 'maxlength' => '3', 'disabled' => 'disabled')) ?>
                            </td>
                            <td>
                                <?php if($product['price'] == 0) { ?>
                                <span style="color:Red;font-weight:bold;">FREE</span>
                                <?php } else if($product['price'] == 79.99) { ?>
                                <span>5 payments of $79.99</span>
                                <?php } else { ?>
                                <span><?= $product['price'] ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <span class="rowtotal-<?= $product['id'] ?>">
                                    <?php if($product['id'] == 2) { ?>
                                    $79.99
                                    <?php } ?>
                                    <?php if($product['id'] == 1) { ?>
                                    $399.95
                                    <?php } ?>
                                </span>
                            </td>
                        </tr>
                         <?php } ?>
                        </tbody>
                    </table>
                </div>

                <table id="Totals">
                    <tfoot>
                        <tr>
                            <td colspan="3">Subtotal:</td>
                            <td>$<span class="sub-total"></span></td>
                            <input id="sub-total" name="sub-total" type="hidden" value="0.00" />
                            <input id="taxable-subtotal" name="taxable-subtotal" type="hidden" value="0.00" />
                        </tr>
                        <tr class="discount-row hidden">
                            <td colspan="3">Discount Amount:</td>
                            <td>$<span class="discount-total"></span></td>
                            <input id="discount-total" name="discount-total" type="hidden" value="0.00" />
                        </tr>
                        <tr>
                            <td colspan="3">Shipping and Handling:</td>
                            <td><span class="shipping-total"></span></td>
                            <input id="shipping-total" name="shipping-total" type="hidden" value="0.00" />
                        </tr>
                        <tr>
                            <td colspan="3">*Estimated Taxes:</td>
                            <td>$<span class="tax"></span><input type="hidden" name="tax-total" value="0.00" /></td>
                            <input id="tax-total" name="tax-total" type="hidden" value="0.00" />
                            <input id="tax-rate" name="tax-rate" type="hidden" value="0.00" />
                        </tr>
                        <tr>
                            <td colspan="3" >Cart Total:</td>
                            <td>$<span class="total"></span></td>
                             <input id="total" name="total" type="hidden" value="0.00" />
                             <input id="grandtotal" name="grandtotal" type="hidden" value="0.00" />
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <img src="/assets/images/spinner.gif" class="spinner" style="display: none;" />
<!--         <a href="#popup7" class="lightbox" id="firstbutton" onclick="_gaq.push(['_trackEvent', 'Cart', 'Click', 'Add to Cart Get Yours Now']);">
            <img src="/assets/images/button-large.png" width="329" height="55" alt="GET YOURS NOW!" />
        </a> -->

        <input type="image" name="btnContinue" id="btnContinue" class="button"  style="height:46px;width:272px;" src="/assets/images/btn-continue.png"  />
        <br />
        <span id="result" style="color:Red;"></span>
        <span style="font-size:7pt;">*Final taxes are calculated upon shipment and will be reflected in your Shipping Confirmation email.</span>
    </div>
</fieldset>
<div style="clear: both;"></div>
</div>

<!-- ad-box -->
<article class="ad-box">
    <span class="logo-moneyback">
        <img src="/assets/images/logo-moneyback.png" width="85" height="100" alt="image description"></span>

        <div class="holder">
            <h1>100% MONEY-BACK GUARANTEE!</h1>
            <p>If you are not completely satisfied with your WINBOT 30-Day Risk-Free Trial Package, simply send it back for a full refund – <b>no questions asked!</b></p>
        </div>
    </article>
    <!-- logo-godaddy -->
    <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=RfTANfCbS0jSo5gwhMSDa6hQtOSRmsJqyBGKBlFwCuoVNvDKy0b"></script></span>
</section>
</div>
<!--end Main div-->
<!-- footer -->
<footer id="footer">
    <div class="footer">
        <!-- footer-nav -->
        <nav class="footer-nav">
            <ul>
                <li><a href="#popup1" class="lightbox" onclick="_gaq.push(['_trackEvent', 'Information', 'Click', 'Why WINBOT']);">Why WINBOT?</a></li>
                <li><a href="#popup2" class="lightbox" onclick="_gaq.push(['_trackEvent', 'Information', 'Click', 'How It Works']);">How It Works</a></li>
                <li><a href="#popup3" class="lightbox" onclick="_gaq.push(['_trackEvent', 'Information', 'Play', 'Watch WINBOT in Action']);">Watch WINBOT In Action</a></li>
                <li><a href="#popup4" class="lightbox" onclick="_gaq.push(['_trackEvent', 'Information', 'Click', 'Safety Features']);">Safety Features</a></li>
                <li><a href="#popup5" class="lightbox" onclick="_gaq.push(['_trackEvent', 'Information', 'Click', 'Terms and Conditions']);">Terms &amp; Conditions</a></li>
                <li><a href="#popup6" class="lightbox" onclick="_gaq.push(['_trackEvent', 'Information', 'Click', 'Privacy Policy']);">Privacy Policy</a></li>
            </ul>
        </nav>
        <!-- footer phone -->
        <span class="phone">For more information or to order by phone, call: <strong>(888) 555-1212</strong></span>
        <!-- copy -->
        <p class="copy">&copy; 2013 <a href="#">ECOVACS Robotics</a>, Inc. All rights reserved.</p>
    </div>
</footer>
</div>
</div>
<div class="popup-holder">
    <div id="popup1" class="lightbox">
        <div class="popup">
            <div class="heading">
                <h1>WHY WINBOT?</h1>
            </div>
            <h2>Say Goodbye to Old Fashioned Window Washing!</h2>
            <div class="box">
                <img src="/assets/images/img-01.jpg" width="140" height="80" alt="image description" />
                <div class="holder">
                    <h3>Live Smart. Enjoy Life!</h3>
                    <p>WINBOT automatically does the hard work for you, saving you hours of precious time – allowing you to sit back and relax, or do other things instead. WINBOT simply lets you enjoy life more!</p>
                </div>
            </div>
            <div class="box">
                <img src="/assets/images/img-02.jpg" width="140" height="80" alt="image description" />
                <div class="holder">
                    <h3>Easy to Use</h3>
                    <p>WINBOT is so easy to use. Just switch it ON, place it on the window, and press start. It’s THAT easy. WINBOT even cleans your higher windows so you never have to worry about dangerous ladders. Plus, WINBOT comes with a remote control for your convenience.</p>
                </div>
            </div>
            <div class="box">
                <img src="/assets/images/img-03.jpg" width="140" height="80" alt="image description">
                <div class="holder">
                    <h3 style="margin-top: 15px">Easy Maintenance </h3>
                    <p>The reusable microfiber Cleaning Pads are easily removed for convenient machine or hand washing.</p>
                </div>
            </div>
            <div class="box">
                <img src="/assets/images/img-04.jpg" width="140" height="80" alt="image description" />
                <div class="holder">
                    <h3>Cleans Mirrors &amp; Glass of ANY Thickness </h3>
                    <p>WINBOT is the world’s first window cleaning robot that can clean glass of any thickness – even Thermopane windows. The WINBOT  is equipped with a frameless window detection system so you can clean mirrors, glass doors, railings and shower stalls with ease.</p>
                </div>
            </div>
        </div>
    </div>
    <div id="popup2" class="lightbox">
        <div class="popup">
            <div class="heading">
                <h1>HOW IT WORKS</h1>
            </div>
            <h2>The World’s Most Advanced Technology At Work For You!</h2>
            <div class="box">
                <img src="/assets/images/img-05.jpg" width="140" height="80" alt="image description" />
                <div class="holder">
                    <h3>Three-Stage Cleaning for Maximum Efficiency</h3>
                    <p>First, the front Cleaning Pad sprayed with cleaning solution moistens, loosens and absorbs dirt. Second, the Squeegee draws the remaining water-borne dirt off the window. Third, the rear Cleaning Pad wipes the window to a dry, spotless shine.</p>
                </div>
            </div>
            <div class="box">
                <img src="/assets/images/img-06.jpg" width="140" height="80" alt="image description" />
                <div class="holder">
                    <h3 style="margin-top: 12px">Automated Cleaning Path</h3>
                    <p>WINBOT’s Pathfinder Technology automatically scans and calculates the size of your windows and mirrors, then programs a custom cleaning path for maximum speed and efficiency.</p>
                </div>
            </div>
            <div class="box">
                <img src="/assets/images/img-07.jpg" width="140" height="80" alt="image description" />
                <div class="holder">
                    <h3 style="margin-top: 12px">High-Tech Microfiber Cleaning Pads</h3>
                    <p>Specially designed Microfiber Cleaning Pads provide powerful absorption of dust and dirt, ensuring a perfect clean every time.</p>
                </div>
            </div>
            <div class="box">
                <img src="/assets/images/img-08.jpg" width="140" height="80" alt="image description">
                <div class="holder">
                    <h3>The Brains Behind the Robot</h3>
                    <p>A sophisticated onboard computer and multiple sensors help WINBOT intelligently avoid edges &amp; obstacles, while leaving windows and mirrors clean, shining and spotless.</p>
                </div>
            </div>
        </div>
    </div>
    <div id="popup3" class="lightbox">
        <div class="popup">
            <div class="heading">
                <h1>WATCH WINBOT IN ACTION</h1>
            </div>
            <div class="video-block">
             <iframe width="640" height="360" src="//www.youtube.com/embed/YdiACf_AIdM?rel=0" frameborder="0" allowfullscreen></iframe>
         </div>
     </div>
 </div>
 <div id="popup4" class="lightbox">
    <div class="popup">
        <div class="heading">
            <h1>SAFETY FEATURES</h1>
        </div>
        <h2>Extraordinary Safety Protection</h2>
        <div class="box">
            <img src="/assets/images/img-09.jpg" width="140" height="80" alt="image description" />
            <div class="holder">
                <h3>Dual Suction Rings</h3>
                <p>WINBOT is equipped with dual suction rings. If the outer ring senses any loss of suction, a signal will be sent to WINBOT’s “brain” to reverse direction and select a new path.</p>
            </div>
        </div>
        <div class="box">
            <img src="/assets/images/img-10.jpg" width="140" height="80" alt="image description" />
            <div class="holder">
                <h3>Rechargable Backup Battery</h3>
                <p>n the event of a power failure or getting unplugged, an integrated rechargeable Lithium Ion backup battery will fully power the WINBOT’s suction motor.</p>
            </div>
        </div>
        <div class="box">
            <img src="/assets/images/img-11.jpg" width="140" height="80" alt="image description">
            <div class="holder">
                <h3>Safety Pod for Extra Protection</h3>
                <p>If WINBOT is used to clean a window above ground level, the Safety Pod provides an extra layer of protection and must be used.</p>
            </div>
        </div>
        <div class="box">
            <img src="/assets/images/img-12.jpg" width="140" height="80" alt="image description">
            <div class="holder">
                <h3>Real Time Malfunction Reporting</h3>
                <p>WINBOT is built on cutting edge robotics technology. Should a problem occur, WINBOT will stop, the Indicator Light will flash, and an alarm will sound. You will always know WINBOT’s working status as Indicator Lights are located on the top AND bottom of the unit.</p>
            </div>
        </div>
    </div>
</div>
<div id="popup5" class="lightbox">
    <div class="popup scroll">
        <div class="heading">
            <h1>TERMS &amp; CONDITIONS</h1>
        </div>
        <div class="text-area scrollable-area">
            <h3>Offer Details</h3>
            <p style="margin-bottom: -10px;">The Winbot 7  30-Day Risk-Free Trial Package includes: </p>
            <ul>
                <li>The Winbot 730</li>
                <li>WINBOT Remote Control</li>
                <li>WINBOT Remote Control Batteries</li>
                <li>WINBOT Power Adaptor</li>
                <li>WINBOT Safety Pod</li>
                <li>WINBOT Safety Rope</li>
                <li>WINBOT Microfiber Cleaning Pads (2 Pair) </li>
                <li>WINBOT Cleaning Solution</li>
                <li>And Bonus items: </li>
                <li>WINBOT Microfiber Cleaning Pads (3 Pair) </li>
                <li>WINBOT Finishing Cloth</li>
                <li>WINBOT Extension Cord  4'9"</li>
                <li>WINBOT Cleaning Solution 70.5 oz</li>
            </ul>
            <p>The offer can be paid by either a single credit card payment of $399.95 USD or five (5) monthly credit card payments of $79.99.  All applicable sales tax will be applied and collected with your order no matter which payment option you choose. </p>
            <h3>One Payment</h3>
            <p>When you choose to pay for your Winbot 7 Risk Free Trial Package offer in one single payment, your credit card will be charged for the offer, $399.95 USD, plus any additional items and their applicable shipping and handling, and sales tax. If you are within the 48 contiguous states, you will receive FREE standard shipping on the WINBOT trial offer and be upgraded to priority processing if you choose to pay in full. Orders to Alaska, Hawaii, Puerto Rico and Canada will receive a $24.95 shipping discount. Priority orders will be processed before any other orders.</p>
            <h3>Multi-Pay Monthly Payments</h3>
            <p>When you choose five (5) monthly payments, your credit card will be charged at the time of purchase for the WINBOT trial offer of $79.99, plus applicable shipping and handling, and sales tax for the full offer. If you order any additional items, your credit card will be charged at the time of purchase, one payment of $79.99 plus the full value of all additional items ordered as well as applicable shipping and handling charges, and sales tax. You credit card will then be charged $79.99 every thirty (30) days following the date of purchase until your order is paid in full. A total of four (4) additional payments will be made following your initial order payment. All payments require a valid credit card. No other form of payment is accepted at this time.</p>
            <h3>Additional Items</h3>
            <p>When you choose to order additional items with your Winbot 7 your credit card will be charged for these items plus applicable sales tax, and shipping and handling charges at the time of your order. If you choose to purchase more than one Winbot 7, additional units must be paid in full; Multi-pay option is not available on additional units.</p>
            <h3>Shipping</h3>
            <p>Shipment and delivery days are Monday through Friday, with the exception of national holidays. We do not make Saturday or Sunday deliveries. For the 48 contiguous states, please allow 2-4 weeks for standard delivery, and 7-10 days for expedited shipping. Shipments to Alaska, Hawaii, and Puerto Rico will be via US Priority Mail. Shipments to Canada will be via UPS Standard.</p>
            The shipping options are as follows:<br /><br />
            <p>The Winbot 7 30-Day Risk-Free Trial Package:<br />
                Standard Shipping: $24.95 (48 Contiguous States)<br />
                Standard Shipping: $54.95 (Alaska, Hawaii, Puerto Rico, and Canada)<br />
                Expedited Shipping - available for an additional charge of $20.00 (only available for the 48 Contiguous States)
            </p>

            <p>Extra WINBOT Extension Cord:<br />
                Standard Shipping: $8.50</p>
                <p>Additional WINBOT Microfiber Cleaning Pads (3 Pair):<br />
                    Standard Shipping: $8.50</p>
                    <p>Extra WINBOT One Year Supply of Cleaning Solution:<br />
                        Standard Shipping: $8.50
                    </p>
                    <p>Additional WINBOT 7 with Standard Accessories:<br />
                        Standard Shipping: $24.95 (48 Contiguous States)<br />
                        Standard Shipping: $54.95 (Alaska, Hawaii, Puerto Rico, and Canada)
                    </p>

                    <h3>30-Day Money Back Guarantee</h3>
                    If you are not completely satisfied with your WINBOT you may return  your Winbot trial package including:
                    <ul>
                        <li>The Winbot 730</li>
                        <li>WINBOT Remote Control</li>
                        <li>WINBOT Remote Control Batteries</li>
                        <li>WINBOT Power Adaptor</li>
                        <li>WINBOT Safety Pod</li>
                        <li>WINBOT Safety Rope</li>
                        <li>WINBOT Finishing Cloth</li>
                    </ul>
                    <p>to Ecovacs within 30 days of your order. The customer is responsible for return shipping expenses. Please return the Winbot 7 in the original packaging. Please contact our Customer Service at (800) 544-1202 prior to taking advantage of Ecovacs’ Money Back Guarantee. No returns will be accepted without a Return Authorization Number. Please do not ship open containers of liquid. You may keep the Cleaning Solution, Finishing Cloth and Microfiber Cleaning Pads as our gift.</p>
                </div>
            </div>
        </div>
        <div id="popup6" class="lightbox">
            <div class="popup scroll">
                <div class="heading">
                    <h1>PRIVACY POLICY</h1>
                </div>
                <div class="text-area scrollable-area">
                    <p>Ecovacs Robotics, Inc., a Delaware corporation ("Ecovacs") respects your privacy and is committed to protect the personal information that you share with us. Generally, you can browse through our website without giving us any information about yourself.  When we do need your personal information to provide services that you request or when you choose to provide us with your personal information, this policy describes how we collect and use your personal information.</p>
                    <p>Personal information means any information that may be used to identify an individual, including, but not limited to, a first and last name, email address, telephone number, a home, postal or other physical address, birth date, gender, occupation, a valid credit card number to process payment for products and/or services and such other information when needed to provide a service that you requested.</p>
                    <p>Also, as you navigate through our site, certain anonymous information can be passively collected (that is, gathered without you actively providing the information) using various technologies, such as cookies, Internet tags or web beacons, and navigational data collection (log files, server logs, clickstream). Your internet browser automatically transmits to this site some of this anonymous information, such as the URL of the web site you just came from and the Internet Protocol (IP) address and the browser version your computer is currently using. This site may also collect anonymous information from your computer through cookies and internet tags or web beacons. You may set your browser to notify you when a cookie is sent or to refuse cookies altogether, but certain features of this site might not work without cookies. </p>
                    <p>Otherwise, we will inform you at the point of collection when personal information is collected and we will give you the opportunity to "opt out" of receiving direct marketing or market research information. This means we assume you have given us your consent to collect and use your information in accordance with this Policy unless you take affirmative action to opt out at the point of collection. Opt-out is the means by which you give us, or decline to give us, your consent to use your personal information for the purposes covered by the opt-out choice. In some cases, when applicable, we will provide you with the opportunity to "opt in." This means we will require your affirmative action to indicate your consent before we use your information for purposes other than the purpose for which it was submitted.</p>
                    <p>Ecovacs uses personally identifiable information for several general purposes: to fulfill your requests for certain products and services, to keep you up to date on the latest product announcements, updates, special offers or other information we think you'd like to hear about either from us or from our business partners, and to better understand your needs and provide you with better services. We may also use your information to send you promotional materials about goods and services (including special offers and promotions). We may also share your personal information with our third party affiliates for the foregoing purposes. You may opt out of receiving these communications.</p>
                    <p>Unless you opt-in, Ecovacs will not transfer your personal information to third parties, except we may transfer your personal information if required to do so by law or in the good faith belief that such action is necessary to conform to the edicts of law or comply with legal process served on Ecovacs or the site; to protect and defend the rights or property of Ecovacs; or to act in urgent circumstances to protect the personal safety of Ecovacs' employees, users of Ecovacs' products or service, or members of the public. If you choose to provide us with your personal information, we may transfer that information within Ecovacs or to Ecovacs' third party service providers with your permission.</p>
                    <p>You can always ask to review any personal information that we have collected from you, have us update, correct or delete this information and/or instruct us not to use this information and/or instruct us not to use this information in the future. If you wish to exercise this right, simply contact us.</p>
                    <p>Your personal information is protected for your privacy and security. Ecovacs safeguards the security and confidentiality of the data you send us with physical, technical, and managerial procedures. Please be aware that, despite out best efforts, no security measures are perfect or impenetrable. While we strive to protect your personal information, we cannot ensure the security of the information you transmit to us, and so we urge you to take every precaution to protect your personal data when you are on the Internet. Change your passwords often, use a combination of letters and numbers, and make sure you use a secure browser.</p>
                    <p>Our website does not target and is not intended to attract children under the age of 13. Ecovacs does not knowingly solicit personal information from children under the age of 13 or send them requests for personal information.</p>
                    <p>Our website may contain links to websites operated by other companies. Some of these third-party sites may be co-branded with our logo, even though they are not operated or maintained by Ecovacs. Although we choose our business partners carefully, Ecovacs  is not responsible for the privacy practices of web sites operated by third parties that are linked to our site.  Once you have left our website, you should check the applicable privacy policy of the third party website to determine how they will handle any information they collect from you.</p>
                    <p>Ecovacs  will amend this policy from time to time. If we make any substantial changes in the way we use your personal information we will make that information available by posting a notice on this site.  You may contact us at marketing@ecovacs.com. </p>
                </div>
            </div>
        </div>

        <div id="popup7" class="lightbox">
            <div class="popup">
                <div class="heading">
                    <h1>ORDER ACKNOWLEDGEMENT</h1>
                </div>
                <div class="block">
                    <p>Please read and verify you meet the following WINBOT <strong>Minimum Requirements for Use</strong>:</p>
                    <ul>
                        <li>Windows are a minimum of 18”x24”</li>
                        <li>Glass is not frosted, textured, patterned, leaded or have a coating or film</li>
                        <li>Glass and mirrors are vertically mounted only</li>
                    </ul>
                    <strong class="agreement">I have read and understand these requirements.</strong>

                    <a href="#" class="submit_form_button" onclick="$('.cart-form').submit(); $.fancybox.close(true);">Continue & Place Order</a>
                </div>
            </div>
        </div>

        <div id="popup8" class="lightbox">
            <div class="popup">
                <div class="heading">
                    <h1>PAYMENT OPTIONS</h1>
                </div>
                <div class="block">
                    <h3>One Payment</h3>
                    <p>When you choose to pay for your Winbot 7 Risk Free Trial Package offer in one single payment, your credit card will be charged for the offer, $399.95 USD, plus any additional items and their applicable shipping and handling, and sales tax. If you are within the 48 contiguous states, you will receive FREE standard shipping on the WINBOT trial offer and be upgraded to priority processing if you choose to pay in full. Orders to Alaska, Hawaii, Puerto Rico and Canada will receive a $24.95 shipping discount. Priority orders will be processed before any other orders.</p>
                    <h3>Multi-Pay Monthly Payments</h3>
                    <p>When you choose five (5) monthly payments, your credit card will be charged at the time of purchase for the WINBOT trial offer of $79.99, plus applicable shipping and handling, and sales tax for the full offer. If you order any additional items, your credit card will be charged at the time of purchase, one payment of $79.99 plus the full value of all additional items ordered as well as applicable shipping and handling charges, and sales tax. You credit card will then be charged $79.99 every thirty (30) days following the date of purchase until your order is paid in full. A total of four (4) additional payments will be made following your initial order payment. All payments require a valid credit card. No other form of payment is accepted at this time.</p>
                </div>
            </div>
        </div>
        <div id="popup9" class="lightbox">
            <div class="popup">
                <div class="heading">
                    <h1>Shipping</h1>
                </div>
                <div class="block">
                    <p>Shipment and delivery days are Monday through Friday, with the exception of national holidays. We do not make Saturday or Sunday deliveries. For the 48 contiguous states, please allow 2-4 weeks for standard delivery, and 7-10 days for expedited shipping. Shipments to Alaska, Hawaii, and Puerto Rico will be via US Priority Mail. Shipments to Canada will be via UPS Standard.</p>
                    The shipping options are as follows:<br /><br />
                    <p>The Winbot 7 30-Day Risk-Free Trial Package:<br />
                        Standard Shipping: $24.95 (48 Contiguous States)<br />
                        Standard Shipping: $54.95 (Alaska, Hawaii, Puerto Rico, and Canada)<br />
                        Expedited Shipping - available for an additional charge of $20.00 (only available for the 48 Contiguous States)
                    </p>

                    <p>Extra WINBOT Extension Cord 4'9":<br />
                        Standard Shipping: $8.50<br />

                    </p>
                    <p>Additional WINBOT Microfiber Cleaning Pads (3 Pair):<br />
                        Standard Shipping: $8.50<br />

                    </p>
                    <p>Extra WINBOT Cleaning Solution 70.5 oz:<br />
                        Standard Shipping: $8.50<br />

                    </p>
                    <p>Additional WINBOT 7 with Standard Accessories:<br />
                        Standard Shipping: $24.95 (48 Contiguous States)<br />
                        Standard Shipping: $54.95 (Alaska, Hawaii, Puerto Rico, and Canada)
                    </p>
                </div>
            </div>
        </div>
    </div>

<?= form_close() ?>

<!--        <div id="fb-root"></div>
    <script>(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
-->

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-40695548-1']);
            _gaq.push(['_trackPageview', location.pathname + location.search + location.hash]);

            (function () {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-40695548-1']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
