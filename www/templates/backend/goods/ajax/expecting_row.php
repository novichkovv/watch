<?php $rand = rand(); ?>
<tr>
    <td class="input-td"><input class="num td-input" type="text"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][code]" value=""></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][stock]" value="<?php echo $good['stock_number']; ?>"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][name]" value="<?php echo $good['good_name']; ?>"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][quantity]" value="<?php echo $quantity; ?>"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][cost]" value="<?php echo $good['price']; ?>"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][price]" value="<?php echo $price; ?>"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][sum]" value="<?php echo ($good['price'] * $quantity); ?>"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][nds]" value=""></td>
    <td class="input-td"><input class="td-input" type="text" value="" name="expecting[<?php echo $rand . $good_id; ?>][nds_sum]"></td>
    <td class="input-td"><input class="td-input" type="text" name="expecting[<?php echo $rand . $good_id; ?>][total]" value="<?php echo ($good['price'] * $quantity); ?>"></td>
    <td><button class="delete_row btn btn-icon red"><i class="fa fa-trash"></i> </button></td>
</tr>