<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content=" I just got my WINBOT™ Window Cleaning Robot – Check it out!"/>
    <meta property="og:title" content=" WINBOT™ The Revolutionary Window Washing Robot" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://www.Winbot7.com/" />
    <meta property="og:description" content="I just got my WINBOT™ Window Cleaning Robot – Check it out!"/>
    <meta property="og:image" content="https://www.Winbot7.com/images/winbot-Pin.jpg" />
    <meta property="og:site_name" content="Winbot™ Window Washing Robot" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>EcovacsWinBot</title>
    <link href="/assets/stylesheets/shared/normalize.css" rel="stylesheet" type="text/css" />
    <link media="all" rel="stylesheet" href="/assets/stylesheets/front/main.css">
    <link media="all" rel="stylesheet" href="/assets/stylesheets/shared/fancybox.css" />
    <script type="text/javascript" src="/assets/javascripts/shared/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/assets/javascripts/front/jquery.main.js"></script>
    <script type="text/javascript" src="/assets/javascripts/front/shopping_cart.js"></script>
    <!--[if IE]><script type="text/javascript" src="/assets/javascripts/shared/ie.js"></script><![endif]-->
     <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <style type="text/css">.gradient {filter: none;}</style>
    <![endif]-->

</head>
<body>
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
                            <table class="shopping-cart-table-1">
                              <tr>
                                <th scope="col">Qty</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Remove</th>
                            </tr>
                            <?php foreach($cart as $item) { ?>
                            <tr data-price="<?= $item['price'] ?>" data-id="<?= $item['id'] ?>" data-row="<?= $item['rowid'] ?>">
                                <td class="qty"><input value="<?=$item['qty'];?>" maxlength="1" name="qty" style="width:20px;" type="text"></input></td>
                                <td><?=$item['name'];?></td>
                                <td><?= $item['subtotal'] == '0.00' ? '<strong>FREE</strong>' : $item['price'] ?></td>
                                <td><?php echo anchor('main/remove/' . $item['rowid'], 'X' ); ?></td>
                            </tr>
                            <?php } ?>

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
                                <?= form_open('main/add', array('class' => 'holder')) ?>
                                <h2><?=$upsell['title'];?></h2>
                                <span class="price"><?=$upsell['price'];?></span>
                                <?php echo form_hidden('id', $upsell['id']) ?>
                                <?php echo form_submit('action', 'Add to Cart', "class='button'"); ?>
                                <?= form_close() ?>
                            </article>
                            <?php } ?>
                        </div>
                    </div>
                </section>
                <section class="section">
                    <h1>Risk-Free Checkout:</h1>
                    <!-- form -->

                    <?= form_open('main/checkout', array('id' => 'form1', 'class' => 'form same')) ?>
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
                                        <label for="emailField">Email Address:</label>
                                        <div class="int-holder">
                                            <input id="emailField" name="email" type="email" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="confirmEmailField">Confirm Email:</label>
                                        <div class="int-holder">
                                            <input id="confirmEmailField" name="confirmEmail" type="email" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="firstNameField">First Name:</label>
                                        <div class="int-holder">
                                           <input id="firstNameField" name="firstName" type="text" required/>
                                       </div>
                                   </div>
                                   <div class="row">
                                    <label for="tbxLName">Last Name:</label>
                                    <div class="int-holder">
                                        <input id="tbxLName" name="tbxLName" type="text" required/>

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
                                    <label for="tbxAddress">Address:</label>
                                    <div class="int-holder">
                                        <input id="tbxAddress" name="tbxAddress" type="text"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="tbxApt">Suite or Apt:</label>
                                    <div class="int-holder">
                                        <input id="tbxApt" name="tbxApt" placeholder="optional" type="text"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="tbxCity">City:</label>
                                    <div class="int-holder">
                                        <input ID="tbxCity" name="tbxCity" type="text"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="state_province">State/Province:</label>
                                    <div class="int-holder" id="state_province">
                                        <select id="State" name="State" style="width:137px;" class="text" >
                                            <option value="" selected="selected"></option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="CA" >California</option>
                                            <option value="CO" >Colorado</option>
                                            <option value="CT" >Connecticut</option>
                                            <option value="DC" >Dist Of Columbia</option>
                                            <option value="DE" >Delaware</option>
                                            <option value="FL" >Florida</option>
                                            <option value="GA" >Georgia</option>
                                            <option value="HI" >Hawaii</option>
                                            <option value="IA" >Iowa</option>
                                            <option value="ID" >Idaho</option>
                                            <option value="IL" >Illinois</option>
                                            <option value="IN" >Indiana</option>
                                            <option value="KS" >Kansas</option>
                                            <option value="KY" >Kentucky</option>
                                            <option value="LA" >Louisiana</option>
                                            <option value="MA" >Massachusetts</option>
                                            <option value="MD" >Maryland</option>
                                            <option value="ME" >Maine</option>
                                            <option value="MI" >Michigan</option>
                                            <option value="MN" >Minnesota</option>
                                            <option value="MO" >Missouri</option>
                                            <option value="MS" >Mississippi</option>
                                            <option value="MT" >Montana</option>
                                            <option value="NC" >North Carolina</option>
                                            <option value="ND" >North Dakota</option>
                                            <option value="NE" >Nebraska</option>
                                            <option value="NH" >New Hampshire</option>
                                            <option value="NJ" >New Jersey</option>
                                            <option value="NM" >New Mexico</option>
                                            <option value="NV" >Nevada</option>
                                            <option value="NY" >New York</option>
                                            <option value="OH" >Ohio</option>
                                            <option value="OK" >Oklahoma</option>
                                            <option value="OR" >Oregon</option>
                                            <option value="PA" >Pennsylvania</option>
                                            <option value="RI" >Rhode Island</option>
                                            <option value="SC" >South Carolina</option>
                                            <option value="SD" >South Dakota</option>
                                            <option value="TN" >Tennessee</option>
                                            <option value="TX" >Texas</option>
                                            <option value="UT" >Utah</option>
                                            <option value="VA" >Virginia</option>
                                            <option value="VI" >Vermont</option>
                                            <option value="WA" >Washington</option>
                                            <option value="WI" >Wisconsin</option>
                                            <option value="WV" >West Virginia</option>
                                            <option value="WY" >Wyoming</option>
                                        </select>
                                        <select id="Province" name="Province" style="width:137px;" class="text hidden">
                                            <option value="" selected="selected"></option>
                                            <option value="AB" >Alberta</option>
                                            <option value="BC" >British Columbia</option>
                                            <option value="MB" >Manitoba</option>
                                            <option value="NB" >New Brunswick</option>
                                            <option value="NL" >Newfoundland and Labrador</option>
                                            <option value="NT" >Northwest Territories</option>
                                            <option value="NS" >Nova Scotia</option>
                                            <option value="NU" >Nunavut</option>
                                            <option value="ON" >Ontario</option>
                                            <option value="PE" >Prince Edward Island</option>
                                            <option value="QC" >Quebec</option>
                                            <option value="SK" >Saskatchewan</option>
                                            <option value="YT" >Yukon</option>
                                        </select>
                                        <select id="Region" name="Region" style="width:137px;" class="text hidden">
                                            <option value="PR">Puerto Rico</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="tbxZip">Zip/Postal Code:</label>
                                    <div class="int-holder">
                                        <input type="text" id="tbxZip" name="tbxZip" />
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="tbxPhone">Phone Number:</label>
                                    <div class="int-holder">
                                        <input id="tbxPhone" name="tbxPhone" placeholder="10 digits only" type="text"  />
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="tbxExt">Extension:</label>
                                    <div class="int-holder">
                                        <input id="tbxExt" name="tbxExt" placeholder="optional" type="text" />
                                    </div>
                                </div>
                                <!-- check-box -->
                                <div class="check-box">
                                    <input id="ckbxAddressDiffer" name=ckbxAddressDiffer type="checkbox"/>
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
                                            <input id="s_first_name" type="text" name="s_first_name" class="shipping_validate"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="s_last_name">Ship Last Name:</label>
                                        <div class="int-holder">
                                            <input id="s_last_name" type="text" name="s_last_name" class="shipping_validate"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="shipCountry">Country:</label>
                                        <div class="int-holder">
                                         <select id="shipCountry" name="shipCountry" class="text" style="width:137px;">
                                            <option value="United States" selected="selected">United States</option>
                                            <option value="Canada" selected="selected">Canada</option>
                                            <option value="Puerto Rico" selected="selected">Puerto Rico</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="s_address">Address:</label>
                                    <div class="int-holder">
                                        <input id="s_address" type="text" name="s_address">
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
                                       <input id="s_city" type="text" name="s_city">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="shipState">State/Province:</label>
                                    <div class="int-holder" id="Ship_state_province">
                                        <select id="shipState" name="shipState" style="width:137px;" class="text" >
                                            <option value="" selected="selected"></option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="CA" >California</option>
                                            <option value="CO" >Colorado</option>
                                            <option value="CT" >Connecticut</option>
                                            <option value="DC" >Dist Of Columbia</option>
                                            <option value="DE" >Delaware</option>
                                            <option value="FL" >Florida</option>
                                            <option value="GA" >Georgia</option>
                                            <option value="HI" >Hawaii</option>
                                            <option value="IA" >Iowa</option>
                                            <option value="ID" >Idaho</option>
                                            <option value="IL" >Illinois</option>
                                            <option value="IN" >Indiana</option>
                                            <option value="KS" >Kansas</option>
                                            <option value="KY" >Kentucky</option>
                                            <option value="LA" >Louisiana</option>
                                            <option value="MA" >Massachusetts</option>
                                            <option value="MD" >Maryland</option>
                                            <option value="ME" >Maine</option>
                                            <option value="MI" >Michigan</option>
                                            <option value="MN" >Minnesota</option>
                                            <option value="MO" >Missouri</option>
                                            <option value="MS" >Mississippi</option>
                                            <option value="MT" >Montana</option>
                                            <option value="NC" >North Carolina</option>
                                            <option value="ND" >North Dakota</option>
                                            <option value="NE" >Nebraska</option>
                                            <option value="NH" >New Hampshire</option>
                                            <option value="NJ" >New Jersey</option>
                                            <option value="NM" >New Mexico</option>
                                            <option value="NV" >Nevada</option>
                                            <option value="NY" >New York</option>
                                            <option value="OH" >Ohio</option>
                                            <option value="OK" >Oklahoma</option>
                                            <option value="OR" >Oregon</option>
                                            <option value="PA" >Pennsylvania</option>
                                            <option value="RI" >Rhode Island</option>
                                            <option value="SC" >South Carolina</option>
                                            <option value="SD" >South Dakota</option>
                                            <option value="TN" >Tennessee</option>
                                            <option value="TX" >Texas</option>
                                            <option value="UT" >Utah</option>
                                            <option value="VA" >Virginia</option>
                                            <option value="VI" >Vermont</option>
                                            <option value="WA" >Washington</option>
                                            <option value="WI" >Wisconsin</option>
                                            <option value="WV" >West Virginia</option>
                                            <option value="WY" >Wyoming</option>
                                        </select>
                                        <select id="shipProvince" name="shipProvince" style="width:137px;" class="text hidden">
                                            <option value="" selected="selected"></option>
                                            <option value="AB" >Alberta</option>
                                            <option value="BC" >British Columbia</option>
                                            <option value="MB" >Manitoba</option>
                                            <option value="NB" >New Brunswick</option>
                                            <option value="NL" >Newfoundland and Labrador</option>
                                            <option value="NT" >Northwest Territories</option>
                                            <option value="NS" >Nova Scotia</option>
                                            <option value="NU" >Nunavut</option>
                                            <option value="ON" >Ontario</option>
                                            <option value="PE" >Prince Edward Island</option>
                                            <option value="QC" >Quebec</option>
                                            <option value="SK" >Saskatchewan</option>
                                            <option value="YT" >Yukon</option>
                                        </select>
                                        <select id="shipRegion" name="shipRegion" style="width:137px;" class="text hidden">
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
                            <a href="#popup8" id="payment-options-link" class="link lightbox" style="margin: -23px 140px 10px"><small>See Details</small></a>
                            <div class="row">
                                <input id="multiPay" name="paymentOption" value="multiPay" type="radio" checked />
                                <label id="lblMultiPayRadio" for="multiPay">Multi-Pay: 5 Payments of $79.99</label>
                            </div>
                            <div class="row">
                                <input id="singlePay" name="paymentOption" type="radio" value="singlePay"  />
                                <label id="lblSinglePayRadio" for="singlePay">Single Pay $399.95"</label>
                            </div>
                            <div id="panel1" >
                                <strong class="note">Wait! Choose Single Pay and Receive FREE Shipping!</strong>
                            </div>
                        </div>
                        <!-- radio-box Shipping Methods -->
                        <div class="radio-box">
                            <h2>Shipping Methods:</h2>
                            <a href="#popup9" id="shipping-options-link" class="link lightbox" style="margin: -23px 145px 10px"><small>See Details</small></a>
                            <div class="row">
                                <input id="standardShip" value="standardShip" type="radio" checked="checked" name="shipping" />
                                <label for="standardShip">Standard Shipping 2-4 weeks $24.95</label>
                            </div>
                            <div class="row">
                                <input id="rushShip" type="radio" name="shipping" />
                                <label for="rushShip">Expedited Shipping 7-10 Days</label>
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
                                    <select id="expireMonth" name="expireMonth" style="font-size: 10pt;">
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

                                    &nbsp;&nbsp;
                                    <select name="expireYear" id="expireYear" style="font-size: 10pt;">
                                     <option selected="selected" value="">Year</option>
                                     <option value="2013">2013</option>
                                     <option value="2014">2014</option>
                                     <option value="2015">2015</option>
                                     <option value="2016">2016</option>
                                     <option value="2017">2017</option>
                                     <option value="2018">2018</option>
                                     <option value="2019">2019</option>
                                     <option value="2020">2020</option>

                                 </select>
                             </div>
                         </div>
                         <div class="row">
                            <label for="tbxCVC">CVC Code:</label>
                            <div class="wrapper">
                                <div class="int-holder width01">
                                    <input name="tbxCVC" type="text" id="tbxCVC" autocomplete="off" />
                                </div>
                                <a class="thumbnail link" href="#thumb">What’s This?<span><img src="images/cvv2.jpg" /></span></a>
                            </div>
                        </div>
                        <!-- check-box -->
                        <div class="check-box">
                            <input id="receiveEmail" type="checkbox" name="receiveEmail" />
                            <label for="receiveEmail">Receive News &amp; Promotions by Email</label>
                        </div>

                    </div>
                    <div style="margin: 15px 0 0 -27px; ">
                        <label for="couponCode">Coupon Code</label>
                        <input name="couponCode" type="text" id="couponCode" style="width:75px;" />&nbsp;&nbsp;
                        <input type="submit" name="btnCoupon" value="Apply" id="btnCoupon" style="color:#8B6B3F;" />
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
                            <table cellspacing="0" cellpadding="2" rules="all" border="1" id="confirm" style="border-collapse: collapse;">
                                <tr>
                                    <th scope="col">Item Description</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                                <tr>
                                    <td>
                                        <span id="confirmDescrip">WINBOT 30-Day Risk-Free Trial Package</span>
                                    </td>
                                    <td>
                                        <span id="confirmQty">1</span>
                                    </td>
                                    <td>5 payments of $79.99</td>
                                    <td>
                                        <span id="confirmTotal">$79.99</span>
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <table id="Totals">
                            <tfoot>
                                <tr>
                                    <td colspan="3">Subtotal:</td><td><span id="lblSubtotal"><?php echo $this->cart->total(); ?></span></td>
                                </tr><tr>
                                <td colspan="3">Shipping and Handling:</td><td><span id="lblShipping" style="color:#8B6B3F;font-weight:normal;">$00.00</span></td>
                            </tr><tr>
                            <td colspan="3">*Estimated Taxes:</td><td><span id="lblTax">$00.00</span></td>
                        </tr><tr>
                        <td colspan="3" class="total">Cart Total:</td><td class="total"><span id="lblTotal">$00.00</span></td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

    <a href="#popup7" class="lightbox" id="firstbutton" onclick="_gaq.push(['_trackEvent', 'Cart', 'Click', 'Add to Cart Get Yours Now']);">
        <img src="/assets/images/button-large.png" width="329" height="55" alt="GET YOURS NOW!" /></a>

        <input type="image" name="btnContinue" id="btnContinue" class="button"  style="height:46px;width:272px;" src="/assets/images/btn-continue.png"  />
        <br />
        <span id="result" style="color:Red;"></span>
        <span style="font-size:7pt;">*Final taxes are calculated upon shipment and will be reflected in your Shipping Confirmation email.</span>
    </div>
</fieldset>
<?= form_close() ?>

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

                    <a href="#" class="submit_form_button" onclick="_gaq.push(['_trackEvent', 'Cart', 'Order', 'Place Order']); close_fb(); $('#ibtnContinue').click();">Continue & Place Order</a>

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

    <div id="fb-root"></div>
    <script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

        <!--
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
    -->
</body>
</html>