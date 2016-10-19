<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 22:08
 */
class orders_model extends model
{
    public function getOrder($order_id)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                * 
            FROM 
                orders o 
                    JOIN 
                users u ON o.user_id = u.id
                    JOIN
                user_addresses a ON a.id = o.address_id
                    JOIN
                products p ON p.id = o.product_id
            WHERE
                o.id = :order_id
        ');
        return $this->get_row($stm, array('order_id' => $order_id));
    }
}