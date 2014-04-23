<?= form_open('/test/submit') ?>

  <table class="order-lines">
    <thead>
      <tr>
        <td>Qty</td>
        <td>Item Description</td>
        <td>Price</td>
        <td>Remove</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $product) { ?>
        <tr class="product-<?= $product['id'] ?>" data-price="<?= $product['price'] ?>">
          <td>
            <?= form_hidden('order_line[' . $product['id'] . '][id]', $product['id']) ?>
            <?= form_input('order_line[' . $product['id'] . '][qty]', 0, 'class="qty"') ?>
          </td>
          <td><?= $product['title'] ?></td>
          <td><?= $product['price'] ?></td>
          <td>
            <?php if($product['id'] != 1) { ?>
            <a href="#" class="remove" data-id="<?= $product['id'] ?>">remove</a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <ul style="overflow: hidden;">
  <?php foreach($upsells as $upsell) { ?>
    <li style="float: left; width: 200px;">
      <h3><?= $upsell['title'] ?></h3>
      <p>price: <?= $upsell['price'] ?><br />
        <a href="#" class="add" data-id="<?= $upsell['id'] ?>">add</a>
      </p>
    </li>
  <?php } ?>
  </ul>



  <p>
    <?= form_label('s_first_name') ?>
    <?= form_input('s_first_name') ?><br />

    <?= form_label('s_first_name') ?>
    <?= form_input('s_last_name') ?><br />

    <?= form_label('state') ?>
    <?= form_dropdown('state', states(), null, 'class="states"') ?><br />

    <?= form_label('discount_code') ?>
    <?= form_input('discount_code', null, 'class="discount-code"') ?>
    <button class="submit-discount">submit</button>
  </p>

  <div class="order_lines">

  </div>

  <ul class="totals">
    <li>subtotal: $<strong class="sub-total"></strong></li>
    <li>discounttotal: $<strong class="discount-total"></strong></li>
    <li>taxtotal: $<strong class="tax-total"></strong></li>
    <li>total: $<strong class="total"></strong></li>
  </ul>

  <img src="/assets/images/spinner.gif" class="spinner" style="display: none;" />

  <?= form_submit('submit','Submit') ?>


<?= form_close() ?>