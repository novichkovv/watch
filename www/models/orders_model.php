<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 22:08
 */
class orders_model extends model
{
    public function getOrderDailyStats($date_from, $date_to, $product_id = null, $my_name = null)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                DATE(create_date) as create_date,
                SUM(IF(status_id = 0, 1, 0)) AS unaccepted,
                SUM(IF(status_id IN(2,1), 1, 0)) AS accepted,
                SUM(IF(status_id = 2, 1, 0)) AS approved
            FROM
                orders
            WHERE
                create_date BETWEEN :date_from AND :date_to
            ' . ($product_id ? ' AND product_id = :product_id' : '') . '
            ' . ($my_name ? ' AND my_name = :my_name' : '') . '
            GROUP BY DATE(create_date)
        ');
        $terms = [];
        $terms['date_from'] = $date_from;
        $terms['date_to'] = $date_to;
        if($product_id) {
            $terms['product_id'] = $product_id;
        }
        if($my_name) {
            $terms['my_name'] = $my_name;
        }
        $tmp = $this->get_all($stm, $terms);
        $stats = [];
        foreach ($tmp as $item) {
            $stats[$item['create_date']] = $item;
        }
        $res = [];
        for($i = strtotime($date_from); $i <= strtotime($date_to); $i += 24*3600) {
            $res['unaccepted'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['unaccepted'] ? $stats[date('Y-m-d', $i)]['unaccepted'] : 0;
            $res['accepted'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['accepted'] ? $stats[date('Y-m-d', $i)]['accepted']: 0;
            $res['approved'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['approved'] ? $stats[date('Y-m-d', $i)]['approved'] : 0;
        }
        return $res;
    }

    public function getTodayCount($product_id = null, $my_name = null)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                SUM(IF(o.status_id = 2, o.price, 0)) AS sum,
                SUM(IF(o.status_id IN(2,1), 1, 0)) AS accepted,
                SUM(IF(o.status_id = 2, 1, 0)) AS approved,
                COUNT(o.id) total
            FROM
                orders o
                    JOIN
                products p ON p.id = o.product_id
            WHERE
                DATE(create_date) = DATE(NOW())
            ' . ($product_id ? ' AND o.product_id = :product_id' : '') . '
            ' . ($my_name ? ' AND o.my_name = :my_name' : '') . '
        ');
        $terms = [];
        if($product_id) {
            $terms['product_id'] = $product_id;
        }
        if($my_name) {
            $terms['my_name'] = $my_name;
        }
        return $this->get_row($stm, $terms);
    }

    public function getMonthCount($product_id = null, $my_name = null)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                SUM(IF(status_id = 2, price, 0)) AS sum,
                SUM(IF(status_id IN(2,1), 1, 0)) AS accepted,
                SUM(IF(status_id = 2, 1, 0)) AS approved,
                COUNT(id) total
            FROM
                orders
            WHERE
                MONTH(create_date) = MONTH(NOW()) AND YEAR(create_date) = YEAR (NOW())
            ' . ($product_id ? ' AND product_id = :product_id' : '') . '
            ' . ($my_name ? ' AND my_name = :my_name' : '') . '
        ');
        $terms = [];
        if($product_id) {
            $terms['product_id'] = $product_id;
        }
        if($my_name) {
            $terms['my_name'] = $my_name;
        }
        return $this->get_row($stm, $terms);
    }

    public function getPeriodCount($product_id, $my_name)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                SUM(IF(status_id = 2, price, 0)) AS unaccepted,
                SUM(IF(status_id IN(2,1), 1, 0)) AS accepted,
                SUM(IF(status_id = 2, 1, 0)) AS approved,
                COUNT(id) total
            FROM
                orders
            WHERE
                create_date BETWEEN :date_from AND :date_to
            ' . ($product_id ? ' AND product_id = :product_id' : '') . '
            ' . ($my_name ? ' AND my_name = :my_name' : '') . '
            GROUP BY DATE(create_date)
        ');
    }
}