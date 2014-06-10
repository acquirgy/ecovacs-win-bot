<!DOCTYPE HTML>
<html>
<head>
    <title>Your Order Summary</title>
    <style type="text/css">
    p.MsoNormal, li.MsoNormal, div.MsoNormal
    {
        margin: 0in;
        margin-bottom: .0001pt;
        font: 12px Tahoma, Arial, sans-serif;
        color: #8b6b3f;
    }

    @page Section1
    {
        size: 8.5in 11.0in;
        margin: 1.0in 1.0in 1.0in 1.0in;
    }
    </style>
</head>
<body lang="EN-US" style="color: #8b6b3f">
    <div>
        <div align="center">
            <table style='border: thin solid #333333; width: 442.5pt; background: #FFFFFF'>
                <tr>
                    <td style='padding: 0in 0in 0in 0in'>
                        <img alt="" src="http://creative.acquirgy.com/CreativeReview/EcoVacs/WINBOT/Ecovacs-WinBot-Email.jpg" width="600" height="108" />
                    </td>
                </tr>
                <tr>
                    <td style='padding: 0in 0in 0in 7.5pt'>
                        <p class="MsoNormal">
                            <br />
                            <span style='color: #4F94DA; font-size: 26px;'>Order Confirmation:</span>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td style='padding: 7.5pt 0in 0in 7.5pt'>
                        <p class="MsoNormal" style='margin-bottom: 12.0pt; font-size: 14px;'>
                            Thank you for ordering your WINBOT Package!<br />
                            Please see below for your order details.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 0in 0in 0in 0in'>
                            <div align="center">
                                <table class="MsoNormal" border="0" cellpadding="0" width="590pt" style='width: 442.5pt'>
                                    <tr>
                                        <td width="50%" style='width: 50.0%; padding: 7.5pt .75pt .75pt 7.5pt'>
                                            <p class="MsoNormal" style="font-size: 14px;">
                                                <strong>Order Details: </strong>
                                            </p>
                                        </td>
                                        <td width="50%" style='width: 50.0%; padding: 7.5pt 7.5pt .75pt .75pt'>
                                            <p class="MsoNormal">
                                               &nbsp;

                                           </p>
                                       </td>
                                   </tr>
                                   <tr>
                                    <td width="50%" style='width: 50.0%; padding: 7.5pt .75pt .75pt 7.5pt'>
                                        <p class="MsoNormal">
                                            <strong>Bill To: </strong><?=$order['b_first_name'] ?>&nbsp;<?=$order['b_last_name'] ?>
                                            <br />
                                            <strong>Order Number: </strong><?=$order['string_id'] ?>
                                        </p>
                                    </td>
                                    <td width="50%" style='width: 50.0%; padding: 7.5pt 7.5pt .75pt .75pt'>
                                        <p class="MsoNormal">
                                           <strong>Order Entered On: </strong>
                                           <?=date("m/d/Y", strtotime($order['created_at'])) ?><br />
                                           <strong>Ship Via: </strong><?=$order['shipping_type'] ?>

                                       </p>
                                   </td>
                               </tr>
                               <tr>
                                <td width="50%" style='width: 50.0%; padding: 7.5pt .75pt .75pt 7.5pt'>
                                    <p class="MsoNormal" style='margin-bottom: 12.0pt'>
                                     <br />
                                     <strong>Ship To:</strong><br />
                                     <?=$order['s_first_name'] ?>&nbsp;<?=$order['s_last_name'] ?><br />
                                     <?=$order['s_address'] ?> <?=$order['s_apt'] ? $order['s_apt'] : '' ?><br />
                                     <?=$order['s_city'] . ', ' . $order['s_state_province'] . ' ' . $order['s_zip']?>
                                 </p>
                             </td>
                             <td width="50%" style='width: 50.0%; padding: 7.5pt 7.5pt .75pt .75pt'>
                                <p class="MsoNormal" style='margin-bottom: 12.0pt'>
                                    <strong>Connect With Us:</strong><br />
                                    <a href="https://www.facebook.com/EcovacsRobotics"><img src="http://creative.acquirgy.com/CreativeReview/EcoVacs/WINBOT/facebook.gif" width="36" height="35" alt="FaceBook" border="0"></a>
                                    <a href="https://twitter.com/ecovacsrobot"><img src="http://creative.acquirgy.com/CreativeReview/EcoVacs/WINBOT/twitter.jpg" width="36" height="35" alt="Twitter" border="0"></a>
                                    <a href="http://pinterest.com/ecovacsrobotics/"><img src="http://creative.acquirgy.com/CreativeReview/EcoVacs/WINBOT/pinterest.gif" width="36" height="35" alt="Pinterest" border="0"></a>
                                    <a href="http://www.youtube.com/user/ECOVACSRobotics"><img src="http://creative.acquirgy.com/CreativeReview/EcoVacs/WINBOT/youtube.gif" width="36" height="35" alt="YouTube" border="0"></a>

                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td style='padding: 0in 0in 0in 0in'>
                <div align="center">
                    <table class="MsoNormal" border="1" cellspacing="0" cellpadding="0" width="95%" style="background: white; border: outset #8b6b3f 1.0pt;" >
                        <tr>

                            <th style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt; background-color: #8b6b3f; color: #FFFFFF;'>
                                <p class="MsoNormal" style='text-align: center; color: #FFFFFF;'>
                                    <b>DESCRIPTION</b>
                                </p>
                            </th>
                            <th style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt; background-color: #8b6b3f; color: #FFFFFF;'>
                                <p class="MsoNormal" style='text-align: center; color: #FFFFFF;'>
                                    <b>QTY</b>
                                </p>
                            </th>
                            <th style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt; background-color: #8b6b3f; color: #FFFFFF;'>
                                <p class="MsoNormal" style='text-align: center; color: #FFFFFF;'>
                                    <b>PRICE</b>
                                </p>
                            </th>
                            <th style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt; background-color: #8b6b3f; color: #FFFFFF;'>
                                <p class="MsoNormal" style='text-align: right; color: #FFFFFF;'>
                                    <b>TOTAL</b>
                                </p>
                            </th>
                        </tr>
                        <?php foreach($order['order_lines'] as $item) { ?>
                        <tr>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class='MsoNormal' style='text-align: left;'><?= $item['product_title'] ?></p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class='MsoNormal' style='text-align: center;'><?= $item['qty'] ?></p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class='MsoNormal' style='text-align: right;'><?= $item['product_price'] ?></p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class='MsoNormal' style='text-align: right;'><?= $item['qty'] * $item['product_price'] ?></p>
                            </td>
                        </tr>
                         <?php } ?>
                        <tr>
                            <td colspan="3" style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    <sup><span style='color: #990000'>*</span></sup>Product Sub-Total:
                                </p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    <?= number_format((float)$order['subtotal'], 2, '.', '');?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    Discount:
                                </p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    <?= number_format((float)$order['discount_total'], 2, '.', '');?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    Estimated Taxes:
                                </p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    <?= number_format((float)$order['tax_total'], 2, '.', '');?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    Shipping Charge:
                                </p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" style='text-align: right'>
                                    <?= number_format((float)$order['shipping_total'], 2, '.', '');  ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" align="right" style='text-align: right'>
                                    Order Total:
                                </p>
                            </td>
                            <td style='border: inset #8b6b3f 1.0pt; padding: 1.5pt 1.5pt 1.5pt 1.5pt'>
                                <p class="MsoNormal" align="right" style='text-align: right'>
                                    <?= number_format((float)$order['total'], 2, '.', ''); ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td style='padding: 0in 0in 0in 0in'>
                <div align="center">
                    <table class="MsoNormal" border="0" cellpadding="0" width="95%" style='width: 95.0%'>
                        <tr>
                            <td style='padding: .75pt .75pt .75pt 3.75pt'>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding: .75pt .75pt .75pt 3.75pt'>
                                <p class="MsoNormal">
                                    <sup><span style='font-size: 10.5pt; color: #990000'>*</span></sup>
                                    <span style='font-size: 10.5pt;'>
                                        <?php if($order['payment_option'] == 'multipay') { echo 'Multi-Pay Option: For your convenience, your credit card will be charged the initial payment at the time your order ships. Your credit card will then be charged $79.99 every thirty (30) days for the next 4 months.'; }?>
                                        <?php if($order['payment_option'] == 'singlepay') { echo 'Your credit card will be charged at the time your order ships.'; }?>
                                    </span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td style='padding: 7.5pt 0in 0in 7.5pt'>
                <p class="MsoNormal" style='margin-bottom: 12.0pt'>
                </p>
            </td>
        </tr>
        <tr>
            <td style='background-color: #8b6b3f; text-align: center;'>
                <p class="MsoNormal" style='margin-bottom: 4px; margin-top: 4px;'>
                    <span style='font-size: 10pt; color: #FFFFFF;'>

                        <strong>**PLEASE DO NOT REPLY TO THIS EMAIL**</strong><br />
                        This email was sent from a notification-only address that cannot accept incoming
                        e-mail.</span></p>
                    </td>
                </tr>
                <tr>
                    <td style='background: white; padding: 5px;'>
                        <p class="MsoNormal" style='text-align: center'>
                            <span style='font-size: 7.5pt; font-family: tahoma;'>We respect your privacy.
                                View our <a href="http://www.ecovacs.com/privacy.html" target="_blank">privacy policy</a>. </span>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    </html>