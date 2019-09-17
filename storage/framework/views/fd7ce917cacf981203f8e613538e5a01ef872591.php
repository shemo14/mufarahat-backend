<?php $__env->startSection('title'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3><?php echo e($users); ?></h3>
                    <p> عدد المستخدمين</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="<?php echo e(route('users')); ?>" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3><?php echo e($admins); ?></h3>
                    <p> عدد المشرفين</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-secret"></i>
                </div>
                <a href="<?php echo e(route('admins')); ?>" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3><?php echo e($categories); ?></h3>
                    <p> عدد الاقسام</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bars"></i>
                </div>
                <a href="<?php echo e(route('categories')); ?>" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3><?php echo e($roles); ?></h3>
                    <p> عدد الصلاحيات</p>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
                <a href="<?php echo e(route('permissionslist')); ?>" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3><?php echo e($reports); ?></h3>
                    <p> عدد التقارير</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text-o"></i>
                </div>
                <a href="<?php echo e(route('allreports')); ?>" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>