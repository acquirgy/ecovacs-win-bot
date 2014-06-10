<!-- Facebook Script -->
<div id="fb-root"></div>
<!--Load the JavaScript SDK asynchronously-->
<script>(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script>
    <!-- This script will track FB likes/unlikes/shares and send the data to Google Analytics. -->
        window.fbAsyncInit = function () {
            FB.Event.subscribe('edge.create', function (targetUrl) {
                _gaq.push(['_trackSocial', 'facebook', 'like', targetUrl]);
            });
            FB.Event.subscribe('edge.remove', function (targetUrl) {
                _gaq.push(['_trackSocial', 'facebook', 'unlike', targetUrl]);
            });
            FB.Event.subscribe('message.send', function (targetUrl) {
                _gaq.push(['_trackSocial', 'facebook', 'send', targetUrl]);
            });
        };
</script>

<div class="w1 inner alt gradient">
    <div id="wrapper">
        <!-- header -->
        <header id="header">
            <div class="wrapper">
                <!-- logo -->
                <strong class="logo"><a href="<?php echo base_url(); ?>">ECOVAS | Live Smart. Enjoy Life.</a></strong>
                <!-- logotype -->
                <strong class="logotype"><a href="#">WINBOT &trade;</a></strong>
                <!-- phone -->
                <span class="phone">For more information or to order by phone, call: <strong>(800) 840-9148</strong></span>
            </div>
        </header>
        <!-- main -->
        <div id="main">
            <!-- container -->
            <div class="container">
                <span class="decor"><img src="/assets/images/divider03.png" width="1" height="524" alt="image description"></span>
                <!-- content -->
                <section class="content">
                    <h1 class="main-title"><b>Thank You!</b> Your WINBOT Package is on its way!</h1>
                    <article class="order-block">
                        <h2>Your Order Details:</h2>
                        <div class="holder">
                            <p>
                                Your Packaging is shipping via
                                <span class="shipping-method"><?= $order['shipping_type'] ?></span></p>
                            <br />
                        </div>
                        <table class="details-table">
                            <tbody>
                                <tr>
                                    <th style="text-align: left">Order Date:</th>
                                    <td><?= date('m/d/Y', strtotime($order['created_at'] )) ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Order Number:</th>
                                    <td><span class="order-number"><?= $order['string_id'] ?></span></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Name:</th>
                                    <td>
                                        <span class="confirm-name">
                                            <?= $order['s_first_name'] . ' ' . $order['s_last_name'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Address:</th>
                                    <td>
                                        <span class="confirm-address">
                                            <?= $order['s_address'] . ', ' . $order['s_city'] . ', ' .
                                                $order['s_state_province'] . ' ' . $order['s_zip'] ?></span></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left">Payment Option:</th>
                                    <td><span class="confirm-payment"><?= $order['payment_option'] ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </article>
                    <!-- order-table -->
                    <div class="order-table">
                        <table style="background-color:White;border-color:#8B6B3F;border-collapse:collapse;">
                            <thead>
                                  <tr>
                                    <th>Item Description</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($order['order_lines'] as $order_line) { ?>
                              <tr>
                                <td><span><?= $order_line['product_title'] ?></span></td>
                                <td><span><?= $order_line['qty'] ?></span></td>
                                <td><?php if($order_line['product_price'] == 0) { ?>
                                    <span style="color:Red;font-weight:bold;">FREE</span>
                                    <?php } else if($order_line['product_price'] == 79.99) { ?>
                                        <span>5 payments of $79.99</span>
                                    <?php } else { ?>
                                        <span>$<?= $order_line['product_price'] ?></span>
                                    <?php } ?></td>
                                <td>
                                    <span>$<?= $order_line['qty'] * $order_line['product_price'] ?></span>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <table id="Totals">
                            <tbody>
                                <tr>
                                    <td colspan="3">Subtotal:</td>
                                    <td>$<span class="confirm-subtotal"><?= number_format((float)$order['subtotal'], 2, '.', ''); ?></span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Discount:</td>
                                    <td>$<span class="confirm-discount"><?= number_format((float)$order['discount_total'], 2, '.', ''); ?></span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Shipping and Handling:</td>
                                    <td>$<span class="confirm-shipping"><?= number_format((float)$order['shipping_total'], 2, '.', ''); ?></span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">*Estimated Taxes:</td>
                                    <td>$<span class="confirm-tax"><?= number_format((float)$order['tax_total'], 2, '.', ''); ?></span></td>
                                </tr>
                                <tr class="total">
                                    <td colspan="3">Total:</td>
                                    <td>$<span class="confirm-total"><?= number_format((float)$order['total'], 2, '.', ''); ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- ad-box -->
                    <article class="ad-box">
                        <a href="#" class="logo-moneyback"><img src="/assets/images/logo-moneyback.png" width="85" height="100" alt="image description"></a>
                        <div class="holder">
                            <h1>100% MONEY-BACK GUARANTEE!</h1>
                            <p>If you are not completely satisfied with your WINBOT 30-Day Risk-Free Trial Package, simply send it back for a full refund – <b>no questions asked!</b></p>
                        </div>
                    </article>
                </section>
                <!-- aside -->
                <aside class="aside">
                    <!-- print -->
                    <span class="print">
                        <img src="/assets/images/ico-print.png" width="27" height="29" alt="image description" />
                        <a href="JavaScript:window.print();">Click here</a> to print a reciept
                    </span>
                    <!-- social -->
                    <div class="social">
                        <h3>Share this great deal with friends:</h3>
                        <div class="holder">
                            <div class="fb">
                                <div class="fb-like" data-href="https://www.winbot7.com" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="tahoma"></div>
                            </div>
                            <div class="twitter">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="https://www.Winbot7.com" data-count="none" data-text="I just got my WINBOT™ Window Cleaning Robot – Check it out!">Tweet</a>

                                <script>!function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = p + '://platform.twitter.com/widgets.js'; fjs.parentNode.insertBefore(js, fjs); } }(document, 'script', 'twitter-wjs');</script>
                            </div>
                            <div class="pin">

                                <a href="//pinterest.com/pin/create/button/?url=https%3A%2F%2Fwww.Winbot7.com&media=https%3A%2F%2Fwww.Winbot7.com%2Fimages%2Fwinbot-Pin.jpg&description=I%20just%20got%20my%20WINBOT%20Window%20Cleaning%20Robot%20%E2%80%93%20Check%20it%20out!" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
                            </div>
                        </div>
                    </div>
                    <!-- more-products -->
                    <div class="more-products">
                        <div class="holder">
                            <h3>Learn more:</h3>
                            <p>For information on ECOVACS Robotics other products, visit <a href="http://www.ecovacs.com">ecovacs.com</a></p>
                        </div>
                        <img class="img" src="/assets/images/image02.png" width="387" height="284" alt="image description" />
                    </div>
                </aside>
            </div>
        </div>
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
</div>

<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>

<!-- Order total Pixel -->
<img src="https://www.ifactz.com/tracking/convert.asp?OfferShortName=ECOVACS2&ZipCode=&vars=OrderValue|<%=subtotal%>" height=1 width=1>

<!-- extension cord upsell -->
<img src="https://www.ifactz.com/tracking/track.asp?OfferShortName=ECOVACS2&p1=Info+Requests&q1=<%=upsellCordCount%>" height=1 width=1>

<!-- additional WINBOT upsell -->
<img src="https://www.ifactz.com/tracking/track.asp?OfferShortName=ECOVACS2&p1=Upsell+A&q1=<%=upsellACount%>" height=1 width=1>

<!-- cleaning pads and solution upsells -->
<img src="https://www.ifactz.com/tracking/track.asp?OfferShortName=ECOVACS2&p1=Upsell+B&q1=<%=upsellBCount%>" height=1 width=1>


<!-- Google Code for Order Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 986770280;
    var google_conversion_language = "en";
    var google_conversion_format = "2";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "5EMKCICItgUQ6NbD1gM";
    var google_conversion_value = 0;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
    <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/986770280/?value=0&amp;label=5EMKCICItgUQ6NbD1gM&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>