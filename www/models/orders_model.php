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
            WHERE
                o.create_date >= :last_update
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
                SUM(IF(cc_status_id = 0, 1, 0)) AS unaccepted,
                SUM(IF(cc_status_id = 1, 1, 0)) AS accepted,
                SUM(IF(cc_status_id = 2, 1, 0)) AS approved,
                SUM(IF(cc_status_id IN(4,5), 1, 0)) AS declined
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
                SUM(IF(o.cc_status_id = 2, p.price, 0)) AS sum,
                SUM(IF(o.cc_status_id = 2, p.payment, 0)) AS payment,
                SUM(IF(o.cc_status_id IN (0,1), 1, 0)) AS accepted,
                SUM(IF(o.cc_status_id = 2, 1, 0)) AS approved,
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
                SUM(IF(o.cc_status_id = 2, p.price, 0)) AS sum,
                SUM(IF(o.cc_status_id = 2, p.payment, 0)) AS payment,
                SUM(IF(o.cc_status_id = 1, 1, 0)) AS accepted,
                SUM(IF(o.cc_status_id = 2, 1, 0)) AS approved,
                SUM(IF(o.cc_status_id IN(4,5), 1, 0)) AS declined,
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
            ' . ($my_name ? ' AND o.my_name = :my_name' : '') . '
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
            $this->writeLog('test', $stm->getQuery($terms));
//        echo $stm->getQuery($terms);
            $tmp = $this->get_all($stm, $terms);
        } else {
            $tmp = $this->get_all($stm);
        }
        $stats = [];

        $res = [];
        foreach ($tmp as $item) {
            $stats[$item['issue_date']] = $item;
        }
        for($i = strtotime($date_from); $i <= strtotime($date_to); $i += 24*3600) {
            $res['cpa'][date('Y,m,d', $i)] = ($stats[date('Y-m-d', $i)]['approved'] ? ($stats[date('Y-m-d', $i)]['spent']/$stats[date('Y-m-d', $i)]['approved']) : 0);
            $res['revenue'][date('Y,m,d', $i)] = ($stats[date('Y-m-d', $i)]['earned'] ? $stats[date('Y-m-d', $i)]['earned'] : 0 ) - ($stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] :0);
        }
//        if(!$product_id) {
//            foreach ($tmp as $item) {
//                $stats[$item['product_id']][$item['issue_date']] = $item;
//                for($i = strtotime($date_from); $i <= strtotime($date_to); $i += 24*3600) {
//                    $res[$item['product_id']]['spent'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] : 0;
//                    $res[$item['product_id']]['reach'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['reach'] ? $stats[date('Y-m-d', $i)]['reach']: 0;
//                    $res[$item['product_id']]['approved'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['approved'] ? $stats[date('Y-m-d', $i)]['approved'] : 0;
//                    $res[$item['product_id']]['accepted'][date('Y,m,d', $i)] = $stats[date('Y-m-d', $i)]['accepted'] ? $stats[date('Y-m-d', $i)]['approved'] : 0;
//                    $res[$item['product_id']]['product_name'] = $stats[date('Y-m-d', $i)]['product_name'];
//                }
//            }
//        } else {
//            foreach ($tmp as $item) {
//                $stats[$item['issue_date']] = $item;
//            }
////            print_r($stats);
//            for($i = strtotime($date_from); $i <= strtotime($date_to); $i += 24*3600) {
//                $res['cpa'][date('Y,m,d', $i)] = ($stats[date('Y-m-d', $i)]['approved'] ? ($stats[date('Y-m-d', $i)]['spent']/$stats[date('Y-m-d', $i)]['approved']) : 0);
//                $res['revenue'][date('Y,m,d', $i)] = ($stats[date('Y-m-d', $i)]['earned'] ? $stats[date('Y-m-d', $i)]['earned'] : 0 ) - ($stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] :0);
//                echo ($stats[date('Y-m-d', $i)]['spent'] ? $stats[date('Y-m-d', $i)]['spent'] : 0 ) . "\n";
//                echo ($stats[date('Y-m-d', $i)]['earned'] ? $stats[date('Y-m-d', $i)]['earned'] : 0 ) . "\n";
//            }
//        }
//        print_r($res);
//        exit;
        return $res;
    }

    public function getProductsStats($product_id = null, $date_from = null, $date_to = null, $my_name = null)
    {
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
        $stm = $this->pdo->prepare('
            SELECT 
                p.id,
                SUM(reach) reach,
                SUM(results) results,
                SUM(spent) spent,
                AVG(relevance_score) score
            FROM
                costs c
                    JOIN
                products p ON p.id = c.product_id
            WHERE 1
            ' . ($my_name ? ' AND c.my_name = :my_name' : '') . '
            ' . ($product_id ? ' AND p.id = :product_id' : '') . '
            ' . ($date_from ? ' AND c.issue_date >= :date_from' : '') . '
            ' . ($date_to ? ' AND c.issue_date <= :date_to' : '') . '
            GROUP BY p.id
        ');
        if($terms) {
            $costs = $this->get_all($stm, $terms);
        } else {
            $costs = $this->get_all($stm);
        }
        $stm = $this->pdo->prepare('
            SELECT 
                p.id,
                p.product_name,
                SUM(if(cc_status_id  = 2, p.price, 0)) earned,
                SUM(if(cc_status_id = 2, 1, 0)) approved,
                SUM(if(cc_status_id = 3, 1, 0)) declined,
                COUNT(o.id) total
            FROM
                products p
                    JOIN
                orders o on o.product_id = p.id
            WHERE 1
            ' . ($my_name ? ' AND o.my_name = :my_name' : '') . '
            ' . ($product_id ? ' AND p.id = :product_id' : '') . '
            ' . ($date_from ? ' AND o.create_date >= :date_from' : '') . '
            ' . ($date_to ? ' AND o.create_date <= :date_to' : '') . '
            GROUP BY p.id
        ');
        if($terms) {
            $orders = $this->get_all($stm, $terms);
        } else {
            $orders = $this->get_all($stm);
        }
        $stm = $this->pdo->prepare('
            SELECT 
                product_id id,
                COUNT(id) visitors
            FROM
                visitors
            WHERE 1
            ' . ($my_name ? ' AND account = :my_name' : '') . '
            ' . ($product_id ? ' AND product_id = :product_id' : '') . '
            ' . ($date_from ? ' AND create_date >= :date_from' : '') . '
            ' . ($date_to ? ' AND create_date <= :date_to' : '') . '
            GROUP BY product_id
        ');
        if($terms) {
            $visitors = $this->get_all($stm, $terms);
        } else {
            $visitors = $this->get_all($stm);
        }
        $res = [];
        foreach ($costs as $cost) {
            $res[$cost['id']] = $cost;
        }
        foreach ($orders as $order) {
            foreach ($order as $key => $value) {
                $res[$order['id']][$key] = $value;
            }
        }
        foreach ($visitors as $visitor) {
            foreach ($visitor as $key => $value) {
                $res[$visitor['id']][$key] = $value;
            }
        }
        return $res;
    }

    public function citySuggest($val, $region_code, $county_code)
    {
        $stm = $this->pdo->prepare('
            SELECT
                f1.CODE,
                f1.AOGUID,
                f1.OFFNAME,
                f1.SHORTNAME,
                IF(f1.AOLEVEL = 6, CONCAT(f2.OFFNAME, " ", f2.SHORTNAME), \'\') PARENTNAME,
                f1.CITYCODE,
                f1.REGIONCODE,
                f1.CODE,
                f1.AREACODE,
                f1.POSTALCODE
            FROM 
                fias f1 join fias f2 ON f1.PARENTGUID = f2.AOGUID
            WHERE
                f1.OFFNAME LIKE "' . $val . '%" 
            AND f1.AOLEVEL IN(4,6)
            ' . ($region_code ? 'AND f1.REGIONCODE = "' . $region_code . '"' : '') . '
            ' . ($county_code ? 'AND f1.AREACODE = "' . $county_code . '"' : '') . '
            LIMIT 5
        ');
        return $this->get_all($stm);
    }

    public function fiasSuggest($val, $level = null, $region_code = null, $parent = null)
    {
        $stm = $this->pdo->prepare('
            SELECT
                * 
            FROM 
                fias 
            WHERE
                OFFNAME LIKE "' . $val . '%" 
            ' . ($level ? 'AND AOLEVEL = :level': '') . '
            ' . ($region_code ? 'AND REGIONCODE = :region_code': '') . '
            ' . ($parent ? 'AND PARENTGUID = :parent': '') . '
            LIMIT 5
        ');
        $terms = [];
        if($level) {
            $terms['level'] = $level;
        }
        if($parent) {
            $terms['parent'] = $parent;
        }
        if($region_code) {
            $terms['region_code'] = $region_code;
        }
        if($terms) {
            return $this->get_all($stm, $terms);
        } else {
            return $this->get_all($stm);
        }
    }

    public function houseSuggest($num, $auguid)
    {
        $stm = $this->pdo->prepare('
            SELECT
                * 
            FROM 
                fias_houseint 
            WHERE
                INTSTART <= :num AND INTEND >= :num
                AND AOGUID = :auguid
            LIMIT 5
            
        ');
        return $this->get_all($stm, ['auguid' => $auguid, 'num' => $num]);
    }

    public function getOrderGoods($order_id)
    {
        $stm = $this->pdo->prepare('
            SELECT
                g.*,
                o.price order_price,
                p.price as product_price,
                o.id id,
                o.good_id,
                o.product_id
            FROM 
                order_goods o 
                    JOIN
                goods g ON g.id = o.good_id
                    LEFT JOIN
                products p ON p.id = o.product_id
            WHERE
                o.order_id = :order_id
        ');
        return $this->get_all($stm, array('order_id' => $order_id));
    }

    public function getReservedGoods()
    {
        $stm = $this->pdo->prepare('
            SELECT
                og.good_id,
                og.order_id
            FROM 
                order_goods og
                    JOIN
                orders o ON og.order_id = o.id
                    WHERE
                o.payment_status_id IN(2,3,4)
                    AND
                og.create_date < NOW() - INTERVAL 30 MINUTE
        ');
        return $this->get_all($stm);
    }
}