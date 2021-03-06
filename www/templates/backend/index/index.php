<h3 class="page-title"> Главная
    <small></small>
</h3>
<div class="row">
    <div class="col-md-3">
        Товар
    </div>
    <div class="col-md-3">
        Кто
    </div>
    <div class="col-md-3">
        С
    </div>
    <div class="col-md-3">
        По
    </div>
</div>
<form method="post" id="stats_filter_form">
    <div class="row">
        <div class="col-md-3">
            <select class="form-control filter" name="filter_product_id">
                <option value="">Все</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['id']; ?>">
                        <?php echo $product['product_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control filter" name="filter_name">
                <option value="">Все</option>
                <?php foreach ($accounts as $account): ?>
                    <option value="<?php echo $account['account_name']; ?>">
<!--                    --><?php //if ($account['user_id'] == registry::get('user')['id']): ?>
<!--                        selected-->
<!--                    --><?php //endif; ?><!-->
                        <?php echo $account['account_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="filter_date_from" class="filter form-control datepicker" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')); ?>">
        </div>
        <div class="col-md-3">
            <input type="text" name="filter_date_to" class="filter form-control datepicker" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
</form>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Статистика КЦ</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <!--                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                    <!--                    <a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="false"> Сегодня </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_2" data-toggle="tab" aria-expanded="false"> <?php echo tools_class::$months_rus[date('m')]; ?> </a>
                        </li>
                        <li class="">
                            <a href="#tab_1_3" data-toggle="tab" aria-expanded="false"> Период </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="today sum" data-counter="counterup" data-value="<?php echo $stats['today']['sum']; ?>"><?php echo $stats['today']['sum'] ? $stats['today']['sum'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Выручка </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="today approved" data-counter="counterup" data-value="<?php echo $stats['today']['approved'] ? $stats['today']['approved'] : 0; ?>"><?php echo $stats['today']['approved'] ? $stats['today']['approved'] : 0; ?></span> </div>
                                            <div class="desc"> Подтвержено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="today accepted" data-counter="counterup" data-value="<?php echo $stats['today']['accepted']; ?>"><?php echo $stats['today']['accepted'] ? $stats['today']['accepted'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> В обработке </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="today total" data-counter="counterup" data-value="<?php echo $stats['today']['total']; ?>"><?php echo $stats['today']['total'] ? $stats['today']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Заказов </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="visitors today" data-counter="counterup" data-value="<?php echo $visitors['today']['total']; ?>"><?php echo $visitors['today'] ?$visitors['today']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Посетителей </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="month sum" data-counter="counterup" data-value="<?php echo $stats['month']['sum']; ?>"><?php echo $stats['month']['sum'] ? $stats['month']['sum'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Выручка </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span  class="month approved" data-counter="counterup" data-value="12,5"><?php echo $stats['month']['approved'] ? $stats['month']['approved'] : 0; ?></span> </div>
                                            <div class="desc"> Подтвержено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-down"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="month accepted" data-counter="counterup" data-value="<?php echo $stats['month']['accepted']; ?>"><?php echo $stats['month']['accepted'] ? $stats['month']['accepted'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Отказ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="month total" data-counter="counterup" data-value="<?php echo $stats['month']['total']; ?>"><?php echo $stats['month']['total'] ? $stats['month']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Всего </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="visitors month" data-counter="counterup" data-value="<?php echo $visitors['month']['total']; ?>"><?php echo $visitors['month'] ?$visitors['month']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Посетителей </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_3">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="period sum" data-counter="counterup" data-value="<?php echo $stats['period']['sum']; ?>"><?php echo $stats['period']['sum'] ? $stats['period']['sum'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Выручка </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span  class="period approved" data-counter="counterup" data-value="12,5"><?php echo $stats['period']['approved'] ? $stats['period']['approved'] : 0; ?></span> </div>
                                            <div class="desc"> Подтвержено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-down"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="period accepted" data-counter="counterup" data-value="<?php echo $stats['period']['accepted']; ?>"><?php echo $stats['period']['accepted'] ? $stats['period']['accepted'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Отказ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="period total" data-counter="counterup" data-value="<?php echo $stats['period']['total']; ?>"><?php echo $stats['period']['total'] ? $stats['period']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Всего </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="visitors period" data-counter="counterup" data-value="<?php echo $visitors['period']['total']; ?>"><?php echo $visitors['period'] ?$visitors['period']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Посетителей </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Статистика Отправлений</span>
                    <span class="caption-helper"></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <!--                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>-->
                    <!--                    <a href="javascript:;" class="reload" data-original-title="" title=""> </a>-->
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_2_1" data-toggle="tab" aria-expanded="false"> Сегодня </a>
                        </li>
                        <li class="">
                            <a href="#tab_2_2" data-toggle="tab" aria-expanded="false"> <?php echo tools_class::$months_rus[date('m')]; ?> </a>
                        </li>
                        <li class="">
                            <a href="#tab_2_3" data-toggle="tab" aria-expanded="false"> Период </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_2_1">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_today delivered_sum" data-counter="counterup" data-value="<?php echo $stats['del_today']['delivered_sum']; ?>"><?php echo $stats['del_today']['delivered_sum'] ? $stats['del_today']['delivered_sum'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Выручка </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_today delivered" data-counter="counterup" data-value="<?php echo $stats['del_today']['delivered'] ? $stats['del_today']['delivered'] : 0; ?>"><?php echo $stats['del_today']['delivered'] ? $stats['del_today']['delivered'] : 0; ?></span> </div>
                                            <div class="desc"> Подтвержено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_today accepted" data-counter="counterup" data-value="<?php echo $stats['del_today']['accepted']; ?>"><?php echo $stats['del_today']['accepted'] ? $stats['del_today']['accepted'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> В обработке </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_today total" data-counter="counterup" data-value="<?php echo $stats['del_today']['total']; ?>"><?php echo $stats['del_today']['total'] ? $stats['del_today']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Заказов </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="visitors del_today" data-counter="counterup" data-value="<?php echo $visitors['del_today']['total']; ?>"><?php echo $visitors['del_today'] ?$visitors['del_today']['total'] : 0; ?></span> </div>
                                            <div class="desc"> Посетителей </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2_2">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_month delivered_sum" data-counter="counterup" data-value="<?php echo $stats['del_month']['delivered_sum']; ?>"><?php echo $stats['del_month']['delivered_sum'] ? $stats['del_month']['delivered_sum'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Выручка </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span  class="del_month delivered" data-counter="counterup" data-value="12,5"><?php echo $stats['del_month']['delivered'] ? $stats['del_month']['delivered'] : 0; ?></span> </div>
                                            <div class="desc"> Выкуплено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-down"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_month canceled" data-counter="counterup" data-value="<?php echo $stats['del_month']['canceled']; ?>"><?php echo $stats['del_month']['canceled'] ? $stats['del_month']['canceled'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Не выкуплено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_month waiting" data-counter="counterup" data-value="<?php echo $stats['del_month']['waiting']; ?>"><?php echo $stats['del_month']['waiting'] ? $stats['del_month']['waiting'] : 0; ?></span> </div>
                                            <div class="desc"> В доставке </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="waiting_sum del_month" data-counter="counterup" data-value="<?php echo $stats['del_month']['waiting_sum']; ?>"><?php echo $stats['del_month']['waiting_sum'] ? $stats['del_month']['waiting_sum'] : 0; ?></span> </div>
                                            <div class="desc"> Сумма в доставке </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2_3">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                        <div class="visual">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_period delivered_sum" data-counter="counterup" data-value="<?php echo $stats['del_period']['delivered_sum']; ?>"><?php echo $stats['del_period']['delivered_sum'] ? $stats['del_period']['delivered_sum'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Выручка </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span  class="del_period delivered" data-counter="counterup" data-value="12,5"><?php echo $stats['del_period']['delivered'] ? $stats['del_period']['delivered'] : 0; ?></span> </div>
                                            <div class="desc"> Выкулено </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-thumbs-o-down"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_period canceled" data-counter="counterup" data-value="<?php echo $stats['del_period']['canceled']; ?>"><?php echo $stats['del_period']['canceled'] ? $stats['del_period']['canceled'] : 0; ?></span>
                                            </div>
                                            <div class="desc"> Отказ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="del_period waiting" data-counter="counterup" data-value="<?php echo $stats['del_period']['waiting']; ?>"><?php echo $stats['del_period']['waiting'] ? $stats['del_period']['waiting'] : 0; ?></span> </div>
                                            <div class="desc"> В доставке </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                        <div class="visual">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span class="waiting_sum del_period" data-counter="counterup" data-value="<?php echo $stats['del_period']['waiting_sum']; ?>"><?php echo $stats['del_period'] ?$stats['del_period']['waiting_sum'] : 0; ?></span> </div>
                                            <div class="desc"> Сумма в доставке </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Заказы</span>
                    <span class="caption-helper">Статистика</span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-default graph-filter" id="all_orders" style="width: 100%">Все</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn graph-filter" id="unaccepted" style="width: 100%">Не принято</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn graph-filter" id="accepted" style="width: 100%">В обработке</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-default graph-filter" id="approved" style="width: 100%">Подтверждено</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-default graph-filter" id="declined" style="width: 100%">Отказ</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="demo-container">
                            <div id="placeholder" class="demo-placeholder" style="height: 300px;">

                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active graph-2-filter">
                                    <a data-tooltip="р. за апрув" href="#cpa" data-toggle="tab" aria-expanded="false"> Стоимость Заказа </a>
                                </li>
                                <li class="graph-2-filter">
                                    <a data-tooltip="р." href="#revenue" data-toggle="tab" aria-expanded="false"> Прибыль </a>
                                </li>
<!--                                <li class="graph-2-filter">-->
<!--                                    <a href="#tab_2_3" data-toggle="tab" aria-expanded="false"> Охвату </a>-->
<!--                                </li>-->
                            </ul>

                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="demo-container">
                                            <div id="cost_stats" class="demo-placeholder" style="height: 300px;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Продукты</span>
                    <span class="caption-helper">Статистика</span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="fullscreen" data-original-title="" title=""> </a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Охват</th>
                        <th>Результат</th>
                        <th>Потрачено</th>
                        <th>Оценка</th>
                        <th>Выручка</th>
                        <th>Подтв</th>
                        <th>Отказ</th>
                        <th>Заказов</th>
                        <th>Посетило</th>
                        <th>Прибыль</th>
                        <th>CPA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($product_stats as $product): ?>
                        <tr>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo $product['reach']; ?></td>
                            <td><?php echo $product['results']; ?></td>
                            <td><?php echo $product['spent']; ?></td>
                            <td><?php echo $product['score']; ?></td>
                            <td><?php echo $product['earned']; ?></td>
                            <td><?php echo $product['approved']; ?></td>
                            <td><?php echo $product['declined']; ?></td>
                            <td><?php echo $product['total']; ?></td>
                            <td><?php echo $product['visitors']; ?></td>
                            <td><?php echo ($product['earned'] - $product['spent']); ?></td>
                            <td><?php echo ($product['approved'] ? (($product['spent'] ? $product['spent'] : 0)/$product['approved']) : 0); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        setTimeout(function(){
            var params = {
                'action': 'update_last_update',
                'common': true,
                'callback': function (msg) {
                    $('title').html('Backend');
                }
            };
            ajax(params);
        }, 3000);

        $(window).focus(function(){
            setTimeout(function(){
                var params = {
                    'action': 'update_last_update',
                    'common': true,
                    'callback': function (msg) {
                        $('title').html('Backend');
                    }
                };
                ajax(params);
            }, 3000);
        });

        setInterval(function() {
            $("#stats_filter_form").submit();
            var params = {
                'action': 'get_new_approved_orders',
                'common': true,
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            if(respond.new_approved_orders != 0) {
                                $("title").html("(" + respond.new_approved_orders + ") Backend");
                            } else {
                                $("title").html("Backend");
                            }
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
        }, 1000*60);

        $(".filter").change(function() {
            $(this).closest('form').submit();
        });

        $(".graph-filter").click(function () {
            if($(this).hasClass('btn-default')) {
                $(this).removeClass('btn-default');
            } else {
                $(this).addClass('btn-default');
            }
            $("#stats_filter_form").submit();
        });

        $("body").on("submit", "#stats_filter_form", function () {
            var params = {
                'action': 'get_stats',
                'get_from_form': 'stats_filter_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            for(var i in respond.today) {
                                $(".today." + i).html(respond.today[i] ? respond.today[i] : 0);
                            }
                            for(var i in respond.month) {
                                $(".month." + i).html(respond.month[i] ? respond.month[i] : 0);
                            }
                            for(var i in respond.period) {
                                $(".period." + i).html(respond.period[i] ? respond.period[i] : 0);
                            }
                            for(var i in respond.del_today) {
                                $(".del_today." + i).html(respond.del_today[i] ? respond.del_today[i] : 0);
                            }
                            for(var i in respond.del_month) {
                                $(".del_month." + i).html(respond.del_month[i] ? respond.del_month[i] : 0);
                            }
                            for(var i in respond.del_period) {
                                $(".del_period." + i).html(respond.del_period[i] ? respond.del_period[i] : 0);
                            }
                            for(var i in respond.visitors) {
                                console.log(i);
                                $(".visitors." + i).html(respond.visitors[i]['total'] ? respond.visitors[i]['total'] : 0);
                            }
                            var a = $(".graph-2-filter.active").find('a');
                            var stat_id = $(a).attr("href").substring(1);
                            var tooltip = $(a).attr('data-tooltip');
                            show_stats(respond[stat_id], tooltip);
                            $(function() {
                                var arr = respond.unaccepted;
                                //{"2016, 10,09":"3","2016, 10,10":"8","2016, 10,11":"8","2016, 10,12":"10","2016, 10,13":"11","2016, 10,14":"10","2016, 10,15":"15","2016, 10,16":"4","2016, 10,17":"15","2016, 10,18":"16","2016, 10,19":"10","2016, 10,20":"7","2016, 10,21":"10","2016, 10,22":"5","2016, 10,23":"5","2016, 10,24":"5"};//<?php echo $graph; ?>;
                                var n = 0;
                                var d2 = [];
                                for(var i in arr)
                                {
                                    d2.push([new Date(i).getTime(), arr[i]]);
                                    if(n == 0)var date_start = new Date(i).getTime();
                                    n ++;
                                }
                                var date_end = new Date(i).getTime();

                                var arr2 = respond.accepted;
                                //var arr2 = {"2016, 10, 10":"1","2016, 10, 14":"2","2016, 10, 16":"1","2016, 10, 17":"1","2016, 10, 20":"2"};//<?php echo $unsigned; ?>;
                                var d1 = [];
                                for(var i in arr)
                                {
                                    d1.push([new Date(i).getTime(), arr2[i] ? arr2[i] : 0]);
                                }

                                var arr3 = respond.approved;
                                //var arr2 = {"2016, 10, 10":"1","2016, 10, 14":"2","2016, 10, 16":"1","2016, 10, 17":"1","2016, 10, 20":"2"};//<?php echo $unsigned; ?>;
                                var d3 = [];
                                for(var i in arr)
                                {
                                    d3.push([new Date(i).getTime(), arr3[i] ? arr3[i] : 0]);
                                }

                                // A null signifies separate line segments
                                var arr4 = respond.declined;
                                //var arr2 = {"2016, 10, 10":"1","2016, 10, 14":"2","2016, 10, 16":"1","2016, 10, 17":"1","2016, 10, 20":"2"};//<?php echo $unsigned; ?>;
                                var d4 = [];
                                for(var i in arr)
                                {
                                    d4.push([new Date(i).getTime(), arr4[i] ? arr4[i] : 0]);
                                }

                                var arr5 = respond.all_orders;
                                //var arr2 = {"2016, 10, 10":"1","2016, 10, 14":"2","2016, 10, 16":"1","2016, 10, 17":"1","2016, 10, 20":"2"};//<?php echo $unsigned; ?>;
                                var d5 = [];
                                for(var i in arr)
                                {
                                    d5.push([new Date(i).getTime(), arr5[i] ? arr5[i] : 0]);
                                }

                                var colors = [];
                                var stats = [];

                                if($("#unaccepted").hasClass('btn-default')) {
                                    stats.push({  data: d2, label: 'Не принято'});
                                    colors.push("#4651ee");
                                }
                                if($("#accepted").hasClass('btn-default')) {
                                    stats.push({data: d1, label: 'В обработкке'});
                                    colors.push("#cbccd2");
                                }
                                if($("#approved").hasClass('btn-default')) {
                                    stats.push({data: d3, label: 'Подтверждено'});
                                    colors.push("#41d62d");
                                }
                                if($("#declined").hasClass('btn-default')) {
                                    stats.push({data: d4, label: 'Отказ'});
                                    colors.push("#ff6b3d");
                                }
                                if($("#all_orders").hasClass('btn-default')) {
                                    stats.push({data: d5, label: 'Все'});
                                    colors.push("#faff5b");
                                }

                                $.plot("#placeholder", stats  ,{
                                        xaxis: {
                                            min: date_start,
                                            max: date_end,
                                            mode: "time",
                                            tickSize: [1,"day"],//"<?php echo $period; ?>"],
                                            monthNames: [ "янв", "фев","мрт","апр","май","инь","иль","авг","сен","окт","ноя","дек"],
                                            tickLength: 0,
                                            axisLabel: 'Day',//'<?php echo ucfirst($period); ?>',
                                            axisLabelUseCanvas: true,
                                            axisLabelFontSizePixels: 11,
                                            axisLabelPadding: 5
                                        },
                                        colors: colors,
                                        series: {
                                            lines: {
                                                show: true,
                                                fill: false,
                                                fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.2 } ] },
                                                lineWidth: 1.5 },
                                            points: {
                                                show: true,
                                                radius: 2.5,
                                                fill: true,
                                                fillColor: "#ffffff",
                                                symbol: "circle",
                                                lineWidth: 1.1 }
                                        },
                                        grid: { hoverable: true, clickable: true },
                                        legend: {
                                            show: true
                                        }
                                    }
                                );

                                function showTooltip(x, y, contents, areAbsoluteXY) {
                                    var rootElt = 'body';

                                    $('<div id="tooltip" class="chart-tooltip">' + contents + '</div>').css( {
                                        top: y - 50,
                                        left: x - 9,
                                        opacity: 0.9,
                                        position: 'absolute',
                                        'background-color':"#eee",
                                        padding: "10px 3px"
                                    }).prependTo(rootElt).show();
                                }

                                var previousPoint = null;
                                $("#placeholder").bind("plothover", function (event, pos, item) {
                                    $("#x").text(pos.x.toFixed(2));
                                    $("#y").text(pos.y.toFixed(2));

                                    if ($("#placeholder").length > 0) {
                                        if (item) {
                                            if (previousPoint != item.dataIndex) {
                                                previousPoint = item.dataIndex;

                                                $("#tooltip").remove();
                                                var x = item.datapoint[0].toFixed(2),
                                                    y = item.datapoint[1].toFixed(2);
                                                var date = new Date(parseInt(x));
                                                var day = date.getDate();
                                                var month = [];
                                                month[0] = "Января";
                                                month[1] = "Февраля";
                                                month[2] = "Марта";
                                                month[3] = "Апреля";
                                                month[4] = "Мая";
                                                month[5] = "Июня";
                                                month[6] = "Июля";
                                                month[7] = "Августа";
                                                month[8] = "Сентября";
                                                month[9] = "Октября";
                                                month[10] = "Ноябя";
                                                month[11] = "Декабря";
                                                var m = month[date.getMonth()];
                                                showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " " + (parseInt(day)<10 ? '0' + day : day) + " " + m +  ": <b>" + parseInt(y) + "</b>", false);
                                            }
                                        }
                                        else {
                                            $("#tooltip").remove();
                                            previousPoint = null;
                                        }
                                    }
                                });
                                // Add the Flot version string to the footer

                                //$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
                            })
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
            return false;
        });
        var stats = <?php echo json_encode($stats); ?>;
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var stat_id = $(this).attr("href").substring(1);
            var tooltip = $(this).attr('data-tooltip');
            var params = {
                'action': 'get_tab_stats',
                'get_from_form': 'stats_filter_form',
                'callback': function (msg) {
                    ajax_respond(msg,
                        function (respond) { //success
                            show_stats(respond[stat_id], tooltip);
                        },
                        function (respond) { //fail
                        }
                    );
                }
            };
            ajax(params);
//            show_stats(stats[stat_id], tooltip);
//            console.log(stats[stat_id]);
//            console.log(tooltip);
//            console.log(stat_id);
//            console.log(stats);
        });
        show_stats(stats['cpa'], "р. за апрув");



        function show_stats(arr, tooltip) {
            var chart_id = "#cost_stats";
            var n = 0;
            var d = [];
            for(var i in arr)
            {
                d.push([new Date(i).getTime(), arr[i]]);
                if(n == 0)var date_start = new Date(i).getTime();
                n ++;
            }
            var date_end = new Date(i).getTime();

            $.plot(chart_id, [{data: d}]  ,{
                    xaxis: {
                        min: date_start,
                        max: date_end,
                        mode: "time",
                        tickSize: [1,"day"],//"<?php echo $period; ?>"],
                        monthNames: [ "янв", "фев","мрт","апр","май","инь","иль","авг","сен","окт","ноя","дек"],
                        tickLength: 0,
                        axisLabel: 'Day',//'<?php echo ucfirst($period); ?>',
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 11,
                        axisLabelPadding: 5,
                        ticks: [[0, "\u03c0/2"]]
                    },
                    colors: [
                        "#41d62d",
                        "#ff6b3d",
                        "#faff5b"],
                    series: {
                        lines: {
                            show: true,
                            fill: false,
                            fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.2 } ] },
                            lineWidth: 1.5 },
                        points: {
                            show: true,
                            radius: 2.5,
                            fill: true,
                            fillColor: "#ffffff",
                            symbol: "circle",
                            lineWidth: 1.1 }
                    },
                    grid: { hoverable: true, clickable: true },
                    legend: {
                        show: false
                    }
                }
            );

            function showTooltip(x, y, contents, areAbsoluteXY) {
                var rootElt = 'body';

                $('<div id="tooltip" class="chart-tooltip">' + contents + '</div>').css( {
                    top: y - 50,
                    left: x - 9,
                    opacity: 0.9,
                    position: 'absolute',
                    'background-color':"#eee",
                    padding: "10px 3px"
                }).prependTo(rootElt).show();
            }

            var previousPoint = null;
            $(chart_id).bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if ($("#placeholder").length > 0) {
                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            var date = new Date(parseInt(x));
                            var day = date.getDate();
                            var month = [];
                            month[0] = "Января";
                            month[1] = "Февраля";
                            month[2] = "Марта";
                            month[3] = "Апреля";
                            month[4] = "Мая";
                            month[5] = "Июня";
                            month[6] = "Июля";
                            month[7] = "Августа";
                            month[8] = "Сентября";
                            month[9] = "Октября";
                            month[10] = "Ноябя";
                            month[11] = "Декабря";
                            var m = month[date.getMonth()];
                            showTooltip(item.pageX, item.pageY,
                                (parseInt(day)<10 ? '0' + day : day) + " " + m +  ": <b>" + parseInt(y) + " " + tooltip + "</b>", false);
                        }
                    }
                    else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                }
            });
            // Add the Flot version string to the footer

            //$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
        };




        // daily common
        $(function() {
            var arr = <?php echo json_encode($stats['unaccepted']); ?>;
            //{"2016, 10,09":"3","2016, 10,10":"8","2016, 10,11":"8","2016, 10,12":"10","2016, 10,13":"11","2016, 10,14":"10","2016, 10,15":"15","2016, 10,16":"4","2016, 10,17":"15","2016, 10,18":"16","2016, 10,19":"10","2016, 10,20":"7","2016, 10,21":"10","2016, 10,22":"5","2016, 10,23":"5","2016, 10,24":"5"};//<?php echo $graph; ?>;
            var n = 0;
            var d2 = [];
            for(var i in arr)
            {
                d2.push([new Date(i).getTime(), arr[i]]);
                if(n == 0)var date_start = new Date(i).getTime();
                n ++;
            }
            var date_end = new Date(i).getTime();

            var arr2 = <?php echo json_encode($stats['accepted']); ?>;
            //var arr2 = {"2016, 10, 10":"1","2016, 10, 14":"2","2016, 10, 16":"1","2016, 10, 17":"1","2016, 10, 20":"2"};//<?php echo $unsigned; ?>;
            var d1 = [];
            for(var i in arr)
            {
                d1.push([new Date(i).getTime(), arr2[i] ? arr2[i] : 0]);
            }

            var arr3 = <?php echo json_encode($stats['approved']); ?>;
            //var arr2 = {"2016, 10, 10":"1","2016, 10, 14":"2","2016, 10, 16":"1","2016, 10, 17":"1","2016, 10, 20":"2"};//<?php echo $unsigned; ?>;
            var d3 = [];
            for(var i in arr)
            {
                d3.push([new Date(i).getTime(), arr3[i] ? arr3[i] : 0]);
            }

            var arr4 = <?php echo json_encode($stats['declined']); ?>;
            var d4 = [];
            for(var i in arr)
            {
                d4.push([new Date(i).getTime(), arr4[i] ? arr4[i] : 0]);
            }

            var arr5 = <?php echo json_encode($stats['all_orders']); ?>;
            var d5 = [];
            for(var i in arr)
            {
                d5.push([new Date(i).getTime(), arr5[i] ? arr5[i] : 0]);
            }

            // A null signifies separate line segments



            $.plot("#placeholder", [{data: d3, label: 'Подтверждено'},{data: d4, label: 'Отказ'},{data: d5, label: 'Все'} ]  ,{
                    xaxis: {
                        min: date_start,
                        max: date_end,
                        mode: "time",
                        tickSize: [1,"day"],//"<?php echo $period; ?>"],
                        monthNames: [ "янв", "фев","мрт","апр","май","инь","иль","авг","сен","окт","ноя","дек"],
                        tickLength: 0,
                        axisLabel: 'Day',//'<?php echo ucfirst($period); ?>',
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 11,
                        axisLabelPadding: 5
                    },
                    colors: [
                        "#41d62d",
                        "#ff6b3d",
                        "#faff5b"],
                    series: {
                        lines: {
                            show: true,
                            fill: false,
                            fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.2 } ] },
                            lineWidth: 1.5 },
                        points: {
                            show: true,
                            radius: 2.5,
                            fill: true,
                            fillColor: "#ffffff",
                            symbol: "circle",
                            lineWidth: 1.1 }
                    },
                    grid: { hoverable: true, clickable: true },
                    legend: {
                        show: true
                    }
                }
            );

            function showTooltip(x, y, contents, areAbsoluteXY) {
                var rootElt = 'body';

                $('<div id="tooltip" class="chart-tooltip">' + contents + '</div>').css( {
                    top: y - 50,
                    left: x - 9,
                    opacity: 0.9,
                    position: 'absolute',
                    'background-color':"#eee",
                    padding: "10px 3px"
                }).prependTo(rootElt).show();
            }

            var previousPoint = null;
            $("#placeholder").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if ($("#placeholder").length > 0) {
                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            var date = new Date(parseInt(x));
                            var day = date.getDate();
                            var month = [];
                            month[0] = "Января";
                            month[1] = "Февраля";
                            month[2] = "Марта";
                            month[3] = "Апреля";
                            month[4] = "Мая";
                            month[5] = "Июня";
                            month[6] = "Июля";
                            month[7] = "Августа";
                            month[8] = "Сентября";
                            month[9] = "Октября";
                            month[10] = "Ноябя";
                            month[11] = "Декабря";
                            var m = month[date.getMonth()];
                            showTooltip(item.pageX, item.pageY,
                                item.series.label + " " + (parseInt(day)<10 ? '0' + day : day) + " " + m +  ": <b>" + parseInt(y) + "</b>", false);
                        }
                    }
                    else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                }
            });
            // Add the Flot version string to the footer

            //$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
        });
    });
</script>