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
<!--    2-->
</div>