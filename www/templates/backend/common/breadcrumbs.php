<div class="page-bar">
    <ul class="page-breadcrumb">
        <?php if (registry::get('route_parts')[0] != 'index'): ?>
        <li>
            <a href="<?php echo SITE_DIR; ?>">
                Главная
            </a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <?php echo registry::get('system_route')['title']; ?>
        </li>
        <?php endif; ?>
        <?php if (registry::get('route_parts')[0] == 'index'): ?>
            <li>
                Главная
            </li>
        <?php endif; ?>
    </ul>
<!--    <div class="page-toolbar">-->
<!--        <div class="btn-group pull-right">-->
<!--            <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions-->
<!--                <i class="fa fa-angle-down"></i>-->
<!--            </button>-->
<!--            <ul class="dropdown-menu pull-right" role="menu">-->
<!--                <li>-->
<!--                    <a href="#">-->
<!--                        <i class="icon-bell"></i> Action</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="#">-->
<!--                        <i class="icon-shield"></i> Another action</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="#">-->
<!--                        <i class="icon-user"></i> Something else here</a>-->
<!--                </li>-->
<!--                <li class="divider"> </li>-->
<!--                <li>-->
<!--                    <a href="#">-->
<!--                        <i class="icon-bag"></i> Separated link</a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
</div>