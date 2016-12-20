<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 22:08
 */
class orders_model extends model
{

    public function getOrdersForCron()
    {
        $stm = $this->pdo->prepare('
            SELECT * FROM orders WHERE status_id NOT IN (3,4,5,6) AND DATE(create_date) > DATE(NOW()) - INTERVAL 14 DAY
        ');
        return $this->get_all($stm);
    }

    public function getNewApprovedOrders()
    {
        $stm = $this->pdo->prepare('
            SELECT 
                COUNT(o.id) qty
            FROM
                orders o
                    JOIN
                m1_accounts a ON o.my_name = a.account_name
            WHERE
                a.user_id = 75
                    AND o.pay_date >= :last_update
                    AND o.status_id = 2
        ');
    $this->writeLog('test', $stm->getQuery(['last_update' => registry::get('user')['last_update']]));
        return $this->get_row($stm, ['last_update' => registry::get('user')['last_update']])['qty'];
    }

    public function getOrderDailyStats($date_from, $date_to, $product_id = null, $my_name = null)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                DATE(create_date) as create_date,
                SUM(1) as all_orders,
                SUM(IF(status_id = 0, 1, 0)) AS unaccepted,
                SUM(IF(status_id = 1, 1, 0)) AS accepted,
                SUM(IF(status_id IN (2,5,6), 1, 0)) AS approved,
                SUM(IF(status_id = 3, 1, 0)) AS declined
            FROM
                orders
            WHERE
                create_date >= :date_from AND create_date <= :date_to
            ' . ($product_id ? ' AND product_id = :product_id' : '') . '
            ' . ($my_name ? ' AND my_name = :my_name' : '') . '
            GROUP BY DATE(create_date)
        ');
        $terms = [];
        $terms['date_from'] = $date_from . ' 00:00:00';
        $terms['date_to'] = $date_to . '23:59:59';
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
            $res['declined'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['declined'] ? $stats[date('Y-m-d', $i)]['declined'] : 0;
            $res['all_orders'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['all_orders'] ? $stats[date('Y-m-d', $i)]['all_orders'] : 0;
        }
        return $res;
    }

    public function getTodayCount($product_id = null, $my_name = null)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                SUM(IF(o.status_id IN (2,5,6), p.price, 0)) AS sum,
                SUM(IF(o.status_id = 1, 1, 0)) AS accepted,
                SUM(IF(o.status_id IN (2,5,6), 1, 0)) AS approved,
                COUNT(o.id) total
            FROM
                orders o
                    JOIN
                products p ON p.id = o.product_id
            WHERE
                DATE(o.create_date) = DATE(NOW())
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
                SUM(IF(o.status_id IN (2,5,6), p.price, 0)) AS sum,
                SUM(IF(o.status_id = 3, 1, 0)) AS accepted,
                SUM(IF(o.status_id IN (2,5,6), 1, 0)) AS approved,
                COUNT(o.id) total
            FROM
                orders o
                    JOIN
                products p ON p.id = o.product_id
            WHERE
                MONTH(o.create_date) = MONTH(NOW()) AND YEAR(o.create_date) = YEAR (NOW())
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

    public function getVisitorsByProduct($product_id = null, $date_from = null, $date_to = null, $my_name = null)
    {
        $stm = $this->pdo->prepare('
            SELECT 
                *
            FROM
                visitors v
            WHERE 1
            ' . ($my_name ? ' AND account = :my_name' : '') . '
            ' . ($product_id ? ' AND product_id = :product_id' : '') . '
            ' . ($date_from ? ' AND create_date >= :date_from' : '') . '
            ' . ($date_to ? ' AND create_date <= :date_to' : '') . '
            GROUP BY session_id
        ');
        $terms = [];
        if($product_id) {
            $terms['product_id'] = $product_id;
        }
        if($date_from) {
            $terms['date_from'] = $date_from;
        }
        if($date_to) {
            $terms['date_to'] = $date_to;
        }
        if($my_name) {
            $terms['my_name'] = $my_name;
        }
        if($terms) {
            $tmp = $this->get_all($stm, $terms);
        } else {
            $tmp = $this->get_all($stm);
        }
        $res = [];
        $res['total'] = 0;
        foreach ($tmp as $item) {
            $res['total'] ++;
            if(!isset($res['products'][$item['product_id']])) {
                $res['products'][$item['product_id']] = 1;
            } else {
                $res['products'][$item['product_id']] ++;
            }
        }
        return $res;
    }

    public function getCostApprovedStats($product_id = null, $date_from = null, $date_to = null, $my_name = null)
    {
        if(!$date_from) {
            $date_from = date('Y-m-d 00:00:00', strtotime(date('Y-m-d') . ' - 10 day'));
        }
        if(!$date_to) {
            $date_to = date('Y-m-d H:i:s');
        }
        $stm = $this->pdo->prepare('
            SELECT 
                sum(p.price) earned,
                c.spent,
                c.reach reach,
                c.results results,
                p.price price,
                p.id product_id,
                p.product_name,
                c.issue_date,
                count(o.id) approved
            FROM
                costs c
                    LEFT JOIN
                orders o ON DATE(o.create_date) = c.issue_date
                    AND c.product_id = o.product_id
                    JOIN
                products p ON p.id = c.product_id
            WHERE
                o.status_id IN (2 , 5, 6)
            ' . ($my_name ? ' AND o.account = :my_name' : '') . '
            ' . ($product_id ? ' AND p.id = :product_id' : '') . '
            ' . ($date_from ? ' AND c.issue_date >= :date_from' : '') . '
            ' . ($date_to ? ' AND c.issue_date <= :date_to' : '') . '
            GROUP BY issue_date
        ');
        $terms = [];
        if($product_id) {
            $terms['product_id'] = $product_id;
        }
        if($date_from) {
            $terms['date_from'] = $date_from;
        }
        if($date_to) {
            $terms['date_to'] = $date_to;
        }
        if($my_name) {
            $terms['my_name'] = $my_name;
        }
        if($terms) {
//        echo $stm->getQuery($terms);
            $tmp = $this->get_all($stm, $terms);
        } else {
            $tmp = $this->get_all($stm);
        }
        $stats = [];

        $res = [];
        if(!$product_id) {
            foreach ($tmp as $item) {
                $stats[$item['product_id']][$item['issue_date']] = $item;
                for($i = strtotime($date_from); $i <= strtotime($date_to); $i += 24*3600) {
                    $res[$item['product_id']]['spent'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] : 0;
                    $res[$item['product_id']]['reach'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['reach'] ? $stats[date('Y-m-d', $i)]['reach']: 0;
                    $res[$item['product_id']]['approved'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['approved'] ? $stats[date('Y-m-d', $i)]['approved'] : 0;
                    $res[$item['product_id']]['accepted'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['accepted'] ? $stats[date('Y-m-d', $i)]['approved'] : 0;
                    $res[$item['product_id']]['product_name'] = $stats[date('Y-m-d', $i)]['product_name'];
                }
            }
        } else {
            foreach ($tmp as $item) {
                $stats[$item['issue_date']] = $item;
            }
//            print_r($stats);
            for($i = strtotime($date_from); $i <= strtotime($date_to); $i += 24*3600) {
                $res['cpa'][date('Y,m,d', $i)] = ($stats[date('Y-m-d', $i)]['approved'] ? ($stats[date('Y-m-d', $i)]['spent']/$stats[date('Y-m-d', $i)]['approved']) : 0);
                $res['revenue'][date('Y,m,d', $i)] = ($stats[date('Y-m-d', $i)]['earned'] ? $stats[date('Y-m-d', $i)]['earned'] : 0 ) - ($stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] :0);
                echo ($stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] : 0 ) . "\n";
                echo ($stats[date('Y-m-d', $i)]['earned'] ? $stats[date('Y-m-d', $i)]['earned'] : 0 ) . "\n";
            }
        }
//        print_r($res);
//        exit;
        return $res;
    }
}