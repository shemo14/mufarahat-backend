
<!-- Right Sidebar -->
<div class="side-bar right-bar">
    <a href="javascript:void(0);" class="right-bar-toggle">
        <i class="zmdi zmdi-close-circle-o"></i>
    </a>
    <h4 class="">التقارير</h4>
    <div class="notification-list nicescroll">
        <ul class="list-group list-no-border user-list">
            <?php $__currentLoopData = reports(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <a href="<?php echo e(route('allreports')); ?>" class="user-list-item">
                        <div class="avatar">
                            <img src="<?php echo e(appPath()); ?>/images/admins/<?php echo e($r->User->avatar); ?>">
                        </div>
                        <div class="user-desc">
                            <span class="name"><?php echo e($r->User->name); ?></span>
                            <span class="desc"><?php echo e($r->event); ?></span>
                            <span class="time"><?php echo e($r->created_at->diffForHumans()); ?></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<!-- /Right-bar -->
