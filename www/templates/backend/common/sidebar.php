<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
            <?php if($sidebar): ?>
                <?php foreach($sidebar as $k => $v): ?>
                    <li <?php if(registry::get('route_parts')[0] == $v['route']) echo 'class="active"' ?>>
                            <?php if(!$v['children']): ?>
                                <a href="<?php echo ($v['external'] ? '' : SITE_DIR ) . ($v['route'] ? $v['route'] .'/' : '') ; ?>">
                            <?php endif; ?>
                            <?php if($v['children']): ?>
                                <a href="#" class="expand">
                            <?php endif; ?>
                                <!--                    <a href="--><?php //echo SITE_DIR . $v['route']; ?><!--/">-->
                                <?php if($v['icon']) echo '<i class="' . $v['icon'] . '"></i>'; ?>
                                <span><?php echo $v['title']; ?></span>
                            </a>
                            <?php if($v['children']): ?>
                                <ul class="sub-menu">
                                    <?php foreach($v['children'] as $child): ?>
                                        <li>
                                            <a href="<?php echo SITE_DIR . $child['route']; ?>/">
                                                <i class="<?php echo $child['icon']; ?>"></i>
                                                <?php echo $child['title']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
<!--            <li class="start --><?php //if(registry::get('route_parts')[0] == 'index') echo 'active'; ?><!--">-->
<!--                <a href="--><?php //echo SITE_DIR; ?><!--">-->
<!--                    <i class="icon-home"></i>-->
<!--                    <span class="title">Dashboard</span>-->
<!--                    <span class="selected"></span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="start --><?php //if(registry::get('route_parts')[0] == 'generate') echo 'active'; ?><!--">-->
<!--                <a href="--><?php //echo SITE_DIR; ?><!--generate/">-->
<!--                    <i class="icon-bubbles"></i>-->
<!--                    <span class="title">Generate</span>-->
<!--                    <span class="selected"></span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="start --><?php //if(registry::get('route_parts')[0] == 'services') echo 'active'; ?><!--">-->
<!--                <a href="--><?php //echo SITE_DIR; ?><!--services/">-->
<!--                    <i class="icon-docs"></i>-->
<!--                    <span class="title">Services</span>-->
<!--                    <span class="selected"></span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="start --><?php //if(registry::get('route_parts')[0] == 'users') echo 'active'; ?><!--">-->
<!--                <a href="--><?php //echo SITE_DIR; ?><!--users/">-->
<!--                    <i class="icon-docs"></i>-->
<!--                    <span class="title">Users</span>-->
<!--                    <span class="selected"></span>-->
<!--                </a>-->
<!--            </li>-->
        </ul>
    </div>
</div>