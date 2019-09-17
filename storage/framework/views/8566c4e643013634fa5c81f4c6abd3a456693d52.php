<?php $__env->startSection('styles'); ?>
    <style>

        @media (max-width: 475.98px) {
            .boxes .col-sm-6 div#datatable_filter {
                float: none;
                text-align: center;
            }

            .boxes .col-sm-6 {
                float:  none;
                text-align: center;
                display:  inline-block;
                width:  10px;
            }
        }

        @media (min-width: 476px) and (max-width: 767.98px) {
            .boxes .col-sm-6 div#datatable_filter {
                float: right;
            }

            .boxes .col-sm-6 {
                float:  right;
                display:  inline-block;
                width:  50%;
            }
        }

    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('title'); ?>
    المناديب
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="btn-group btn-group-justified m-b-10">
            <a href="#add" class="btn btn-success waves-effect btn-lg waves-light" data-animation="fadein" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a">اضافة مندوب <i class="fa fa-plus"></i> </a>
            <a href="#deleteAll" class="btn btn-danger waves-effect btn-lg waves-light delete-all" data-animation="blur" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a">حذف المحدد <i class="fa fa-trash"></i> </a>
            <a class="btn btn-primary waves-effect btn-lg waves-light" onclick="window.location.reload()" role="button">تحديث الصفحة <i class="fa fa-refresh"></i> </a>
        </div>

        <div class="col-sm-12">
            <div class="card-box table-responsive boxes">
                <table id="datatable" class="table table-bordered table-responsives">
                    <thead>
                    <tr>
                        <th>
                            تحديد
                            <input type="checkbox" id="checkedAll" style="margin-right: 10px">
                        </th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>رقم الهاتف</th>
                        <th> المدينه</th>
                        <th> المستودع </th>
                        <th>تاريخ التسجيل</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($user->id == 1): ?>
                                    <input type="checkbox" class="form-check-label" disabled>
                                <?php else: ?>
                                    <input type="checkbox" class="form-check-label checkSingle" id="<?php echo e($user->id); ?>">
                                <?php endif; ?>
                            </td>
                            <td><img src="<?php echo e(appPath()); ?>/images/users/<?php echo e($user->avatar); ?>" alt="user-img" width="60px" title="Mat Helme" class="img-circle img-thumbnail img-responsive"></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->phone); ?></td>
                            <td><?php echo e($user->city->name_ar); ?></td>
                            <td><?php echo e($user->dalegateInformation->warehouse->name); ?></td>
                            <td><?php echo e($user->created_at->diffForHumans()); ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a" style="color: #c89e28; font-weight: bold;"
                                        data-id             = "<?php echo e($user->id); ?>"
                                        data-phone          = "<?php echo e($user->phone); ?>"
                                        data-name           = "<?php echo e($user->name); ?>"
                                        data-email          = "<?php echo e($user->email); ?>"
                                        data-photo          = "<?php echo e($user->avatar); ?>"
                                        data-role           = "<?php echo e($user->role); ?>"
                                        data-city_id        = "<?php echo e($user->city_id); ?>"
                                        data-warehouse_id   = "<?php echo e($user->dalegateInformation->warehouse->id); ?>"
                                        data-address        = "<?php echo e($user->address); ?>"
                                    >
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <?php if($user->id !== 1): ?>
                                        <a href="#delete" class="delete btn btn-danger" style="color: #c83338; font-weight: bold;" data-animation="blur" data-plugin="custommodal"
                                            data-overlaySpeed="100" data-overlayColor="#36404a"
                                            data-id = "<?php echo e($user->id); ?>"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->

    </div>

    <!-- add user modal -->
    <div id="add" class="modal-demo" >
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title" style="background-color: #36404a">
            مندوب جديد
        </h4>
        <form action="<?php echo e(route('adddelegate')); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم</label>
                            <input type="text" autocomplete="nope" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-2" class="control-label">رقم الهاتف</label>
                            <input type="text" autocomplete="nope" name="phone" required class="form-control phone" id="phone">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-2" class="control-label">العنوان</label>
                            <input type="text" autocomplete="nope" name="address" required class="form-control " >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">البريد الالكتروني</label>
                            <input type="email" autocomplete="nope" name="email" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">كلمة السر</label>
                            <input type="password" autocomplete="nope" name="password" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">المدينه</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="city_id">
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>"><?php echo e($city->name_ar); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">المستودع</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="warehouse_id">
                                    <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($warehouse->id); ?>"><?php echo e($warehouse->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 12px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">الصورة الشخصية</label>
                            <div class="col-sm-10">
                                <input type="file" name="avatar" class="dropify">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 12px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">صوره المركبه</label>
                            <div class="col-sm-10">
                                <input type="file" name="car_image" class="dropify">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 12px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">صوره رخصه القياده</label>
                            <div class="col-sm-10">
                                <input type="file" name="licenses_image" class="dropify">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light">اضافة</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" onclick="Custombox.close();">رجوع</button>
            </div>
        </form>
    </div>

    <!-- edit user modal -->
    <div id="edit" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title" style="background-color: #36404a">
            تعديل <span id="username"></span>
        </h4>
        <form action="<?php echo e(route('editdelegate')); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم</label>
                            <input type="text" autocomplete="nope" name="edit_name" value="" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-2" class="control-label">رقم الهاتف</label>
                            <input type="text" autocomplete="nope" name="edit_phone" value="" required class="phone form-control" id="phone">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-2" class="control-label">العنوان</label>
                            <input type="text" autocomplete="nope" name="edit_address" value="" required class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">البريد الالكتروني</label>
                            <input type="email" autocomplete="nope" name="edit_email" value="" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">كلمة السر</label>
                            <input type="password" autocomplete="nope" name="password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">المدينه</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="city_id">
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($city->id); ?>" id="c_<?php echo e($city->id); ?>"><?php echo e($city->name_ar); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">المستودع</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="warehouse_id">
                                    
                                    <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($warehouse->id); ?>" id="w_<?php echo e($warehouse->id); ?>"><?php echo e($warehouse->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">الصورة الشخصية</label>
                            <div class="col-sm-10">
                                <input type="file" name="avatar" class="dropify photo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">صوره المركبه</label>
                            <div class="col-sm-10">
                                <input type="file" name="car_image" class="dropify photo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">صوره رخصه القياده</label>
                            <div class="col-sm-10">
                                <input type="file" name="licenses_image" class="dropify photo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light">تعديل</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" onclick="Custombox.close();">رجوع</button>
            </div>
        </form>
    </div>

   <div id="delete" class="modal-demo" style="position:relative; right: 32%">
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title">حذف مشرف</h4>
        <div class="custombox-modal-container" style="width: 400px !important; height: 160px;">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="margin-top: 35px">
                        هل تريد مواصلة عملية الحذف ؟
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form action="<?php echo e(route('deleteadmin')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="delete_id" value="">
                        <button style="margin-top: 35px" type="submit" class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5 send-delete-all"  style="margin-top: 19px">حـذف</button>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>

    <div id="deleteAll" class="modal-demo" style="position:relative; right: 32%">
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title">حذف المحدد</h4>
        <div class="custombox-modal-container" style="width: 400px !important; height: 160px;">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="margin-top: 35px">
                        هل تريد مواصلة عملية الحذف ؟
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button style="margin-top: 35px" type="submit" class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5 send-delete-all" style="margin-top: 19px">حـذف</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script>
        $('.edit').on('click',function(){
            //get valus
            let id         = $(this).data('id');
            let name       = $(this).data('name');
            //let photo      = $(this).data('photo');
            let phone      = $(this).data('phone');
            let email      = $(this).data('email');
            let city_id    = $(this).data('city_id');
            let address    = $(this).data('address');
            let warehouse_id    = $(this).data('warehouse_id');
            // let role      = $(this).data('role');

            $("input[name='id']").val(id);
            $("input[name='edit_name']").val(name);
            $("input[name='edit_phone']").val(phone);
            $("input[name='edit_email']").val(email);
            $("input[name='edit_address']").val(address);
            $('#c_'+city_id).attr('selected', true)
            $('#w_'+warehouse_id).attr('selected', true)

            $("#username").html(name);
        });

        $('.delete').on('click',function(){

            let id         = $(this).data('id');

            $("input[name='delete_id']").val(id);

        });

        $("#checkedAll").change(function(){
            if(this.checked){
                $(".checkSingle").each(function(){
                    this.checked=true;
                })
            }else{
                $(".checkSingle").each(function(){
                    this.checked=false;
                })
            }
        });

        $(".checkSingle").click(function () {
            if ($(this).is(":checked")){
                var isAllChecked = 0;
                $(".checkSingle").each(function(){
                    if(!this.checked)
                        isAllChecked = 1;
                })
                if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
            }else {
                $("#checkedAll").prop("checked", false);
            }
        });

        $('.send-delete-all').on('click', function (e) {
            var usersIds = [];
            $('.checkSingle:checked').each(function () {
                var id = $(this).attr('id');
                usersIds.push({
                    id: id,
                });
            });
            var requestData = JSON.stringify(usersIds);
            // console.log(requestData);
            if (usersIds.length > 0) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('deleteadmins')); ?>",
                    data: {data: requestData, _token: '<?php echo e(csrf_token()); ?>'},
                    success: function( msg ) {
                        if (msg == 'success') {
                            location.reload()
                        }
                    }
                });
            }
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>