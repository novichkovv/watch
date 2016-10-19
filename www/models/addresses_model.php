<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 10.09.2016
 * Time: 15:37
 */
class addresses_model extends model
{
//    public function getUserAddress($user_id)
//    {
//        $stm = $this->pdo->prepare('
//            SELECT
//                a.*
//            FROM
//                user_addresses a
//                    JOIN
//                orders o ON a.id = o.address_id
//                    JOIN
//                users u ON o.user_id = u.id
//            WHERE
//                u.id = :user_id
//            ORDER BY o.create_date DESC
//            LIMIT 1
//        ');
//        return $this->get_row($stm, array('user_id' => $user_id));
//    }
}