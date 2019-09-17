
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!-- User -->
        <div class="user-box">
            <div class="user-img">
                <img src="<?php echo e(appPath()); ?>/images/users/<?php echo e(auth()->user()->avatar); ?>" alt="user-img" title="Mat Helme" class="img-responsive">
                <div class="user-status online"><i class="zmdi zmdi-dot-circle"></i></div>
            </div>
            <h5><a href="#"><?php echo e(auth()->user()->name); ?></a> </h5>
            <ul class="list-inline">
                <li>
                    <a href="<?php echo e(route('logout')); ?>" class="text-custom">
                        <i class="zmdi zmdi-power"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End User -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title basic-title">اقسام الموقع</li>
                <?php echo e(menu()); ?>

            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>

</div>
<!-- Left Sidebar End -->

