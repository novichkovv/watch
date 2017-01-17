<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 27.09.2015
 * Time: 16:45
 */
class products_model extends model
{
    public function getProductGoods($product_id)
    {
        $stm = $this->pdo->prepare('
            SELECT
                g.*
            FROM
                goods g 
                    JOIN
                product_goods pg ON pg.good_id = g.id
            WHERE
                pg.product_id = :product_id
        ');
        return $this->get_all($stm, array('product_id' => $product_id));
    }
}