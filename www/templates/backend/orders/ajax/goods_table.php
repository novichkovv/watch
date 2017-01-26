<?php echo $sum = 0; ?>
<?php if ($order_goods): ?>
    <?php foreach ($order_goods as $k => $good): ?>
        <?php $sum += $good['order_price']; ?>
        <tr class="good_tr" data-id="<?php echo $k; ?>">
            <td>
                <?php echo $good['good_name']; ?>
                <input type="hidden" name="order_goods[<?php echo $k; ?>][good_id]" value="<?php echo $good['good_id']; ?>">
            </td>
            <td>
                <input name="order_goods[<?php echo $k; ?>][price]" value="<?php echo $good['order_price']; ?>" type="text" class="form-control">
            </td>
            <td>
                <button class="btn outline red delete_good" type="button" data-id="<?php echo $good['id']; ?>"><i class="fa fa-times"></i> </button>
                <?php if ($good['id']): ?>
                    <input type="hidden" name="order_goods[<?php echo $k; ?>][id]" value="<?php echo $good['id']; ?>">
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
<?php if ($product['price_delivery']): ?>
    <?php $sum += ($order['delivery_price'] ? $order['delivery_price'] : $product['price_delivery']); ?>
    <tr class="good_tr" data-id="100">
        <td>
            Доставка
        </td>
        <td>
            <input name="order[delivery_price]" value="<?php echo $order['delivery_price'] ? $order['delivery_price'] : $product['price_delivery']; ?>" type="text" class="form-control">
        </td>
        <td>
            <button class="btn outline red delete_good" type="button" data-id="100"><i class="fa fa-times"></i> </button>
        </td>
    </tr>
<?php endif; ?>
<tr>
    <td>
        Сумма
    </td>
    <td id="order_sum">
        <?php echo $sum; ?>
    </td>
    <td>
    </td>
</tr>

