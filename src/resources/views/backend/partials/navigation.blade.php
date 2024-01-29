<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li<?php  echo $segment == 'dashboard' ? ' class="active"' : '' ?>>
                <a href="{{config('site.admin')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php foreach ($all_parent_modules as $parent_module) { ?>
                <?php
                if (isset($all_child_modules[$parent_module->id])) {
                    if ($parent_module->show_in_navigation == '1') {
                        ?>
                        <li class="treeview<?php echo (check_parent_active($all_child_modules[$parent_module->id], $segment)) ? ' active' : '' ?>">
                            <a href="#">
                                <i class="<?php echo $parent_module->icon_class ?>"></i>
                                <span><?php echo $parent_module->name ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                foreach ($all_child_modules[$parent_module->id] as $child_module) {
                                    if ($child_module->show_in_navigation == '1') {
                                        ?>
                                        <li<?php echo $segment == $child_module->slug ? ' class="active"' : '' ?>><a href="{{config('site.admin')}}{{$child_module->slug}}<?php  //echo base_url(BACKENDFOLDER . '/' . $child_module->slug) ?>"><i class="fa fa-circle-o"></i> <?php echo $child_module->name ?></a></li>
                                    <?php }
                                } ?>
                            </ul>
                        </li>
                    <?php
                    }
                } else {
                    if ($parent_module->show_in_navigation == '1') {
                        ?>
                        <li<?php echo $segment == $parent_module->slug ? ' class="active"' : '' ?>>
                            <a href="<?php //echo //base_url(BACKENDFOLDER . '/' . $parent_module->slug) ?>">
                                <i class="<?php echo $parent_module->icon_class ?>"></i> <span><?php echo $parent_module->name ?></span>
                            </a>
                        </li>
        <?php }
    } ?>
<?php } ?>
            <li>
                <a href="{{ route('BACKEND-LOGOUT') }}">
                    <i class="fa fa-sign-out"></i> <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </section>
</aside>