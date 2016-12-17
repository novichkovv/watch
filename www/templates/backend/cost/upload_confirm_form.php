<?php if ($costs): ?>
    <?php foreach ($costs as $product_name => $products): ?>
        <?php foreach ($products as $date => $cost): ?>
            <tr>
                <td>
                    <input class="fill_td_input datepicker" type="text" name="cost[<?php echo $date; ?>][<?php echo $product_name; ?>][issue_date]" value="<?php echo $date; ?>">
                </td>
                <th>
                    <input class="fill_td_input" type="text" name="product_name" value="<?php echo $product_name; ?>" disabled>
                    <input type="hidden" name="cost[<?php echo $date; ?>][<?php echo $product_name; ?>][product_id]" value="<?php echo $cost['product_id']; ?>">
                </th>

                <td><input class="fill_td_input" type="text" name="cost[<?php echo $date; ?>][<?php echo $product_name; ?>][reach]" value="<?php echo $cost['reach']; ?>"></td>
                <td><input class="fill_td_input" type="text" name="cost[<?php echo $date; ?>][<?php echo $product_name; ?>][results]" value="<?php echo $cost['results']; ?>"></td>
                <td><input class="fill_td_input" type="text" name="cost[<?php echo $date; ?>][<?php echo $product_name; ?>][spent]" value="<?php echo $cost['spent']; ?>"></td>
                <td><input class="fill_td_input" type="text" name="cost[<?php echo $date; ?>][<?php echo $product_name; ?>][relevance_score]" value="<?php echo $cost['relevance_score']; ?>"></td>
                <td><button class="btn-xs btn-icon btn-default btn delete_cost" type="button"><i class="text-danger fa fa-trash"></i> </button> </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>