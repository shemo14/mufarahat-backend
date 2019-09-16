<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('title'); ?>
    المنتجات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="btn-group btn-group-justified m-b-10">
        <a href="#add" class="btn btn-success waves-effect btn-lg waves-light" data-animation="fadein" data-plugin="custommodal"
            data-overlaySpeed="100" data-overlayColor="#36404a">اضافة منتج جديد <i class="fa fa-plus"></i> </a>
        
        <a class="btn btn-primary waves-effect btn-lg waves-light" onclick="window.location.reload()" role="button">تحديث الصفحة <i class="fa fa-refresh"></i> </a>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="card-box table-responsive boxes">

                <table id="datatable" class="table table-bordered table-responsives">
                    <thead>
                    <tr>
                        
                        <th>الرقم</th>
                        <th>اسم المنتج</th>
                        <th>القسم </th>
                        <th>السعر</th>
                        <th>تخفيض </th>
                        <th>الكميه </th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <td><?php echo e($row->id); ?></td>
                            <td><?php echo e($row->name_ar); ?></td>
                            <td><?php echo e($row->category->name_ar); ?></td>
                            <td><?php echo e($row->price); ?></td>
                            <td>
                                <?php if($row->discount == null ): ?>
                                    <span class="label label-success">لايوجد خصم</span>
                                <?php else: ?>
                                   <span class="label label-danger"><?php echo e($row->discount); ?> %</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($row->quantity); ?></td>
                            <td><?php echo e($row->created_at->diffForHumans()); ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a"
                                        data-id                 = "<?php echo e($row->id); ?>"
                                        data-name_ar            = "<?php echo e($row->name_ar); ?>"
                                        data-name_en            = "<?php echo e($row->name_en); ?>"
                                        data-description_ar     = "<?php echo e($row->description_ar); ?>"
                                        data-description_en     = "<?php echo e($row->description_en); ?>"
                                        data-price              = "<?php echo e($row->price); ?>"
                                        data-quantity           = "<?php echo e($row->quantity); ?>"
                                        data-discount           = "<?php echo e($row->discount); ?>"
                                        data-category_id        = "<?php echo e($row->category_id); ?>"
                                    >
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#ad_<?php echo e($row->id); ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#delete" class="delete btn btn-danger" data-animation="blur" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a"
                                        data-id = "<?php echo e($row->id); ?>"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- add user modal -->
                        <div id="ad_<?php echo e($row->id); ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content" style="width: 800px">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="slider owl-carousel">
                                                <?php $__currentLoopData = $row->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="item">
                                                        <a href="<?php echo e(route('deleteImg', $image->id)); ?>" class="btn btn-danger">حذف الملف</a>

                                                        <img src="<?php echo e(Request::root()); ?>/images/products/<?php echo e($image->name); ?>" style="height: 300px; width: 100%;" />
                                                    </div>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->

    </div>

    <!-- add user modal -->
    <div id="add" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title" style="background-color: #36404a">
            منتج جديد
        </h4>
        <form action="<?php echo e(route('addProduct')); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="modal-body">
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالعربيه</label>
                            <input type="text" autocomplete="nope" name="name_ar" required class="form-control" placeholder="الاسم بالعربيه ...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالانجليزيه</label>
                            <input type="text" autocomplete="nope" name="name_en" required class="form-control" placeholder="الاسم بالانجليزيه ...">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الوصف بالعربيه</label>
                            <textarea name="description_ar" id="" class="form-control" cols="30" rows="10" required ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الوصف بالانجليزيه</label>
                            <textarea name="description_en" id="" class="form-control" cols="30" rows="10" required ></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">السعر </label>
                            <input type="number" autocomplete="nope" name="price" required class="form-control" placeholder="السعر ...">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الكميه المتاحه </label>
                            <input type="number" autocomplete="nope" name="quantity" required class="form-control" placeholder="ادخل  الكميه المتاحه من المنتج  ...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">تخفيض </label>
                            <input type="number" autocomplete="nope" name="discount"  class="form-control" placeholder="ادخل نسبه الخصم...">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <select name="category_id" class="form-control"  required id="">
                                <option> اختر القسم التابع له المنتج --</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($row->id); ?>"><?php echo e($row->name_ar); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="col-sm-4 control-label">صور الاعلان</label>
                                <input type="file" name="images[]" multiple class="dropify" data-max-file-size="5M" required>
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
            تعديل <span id="category"></span>
        </h4>
        <form id="edit" action="<?php echo e(route('updateProduct')); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row" style="margin-top: 15px;">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالعربيه</label>
                            <input type="text" autocomplete="nope" id="name_ar" name="name_ar" required class="form-control" placeholder="الاسم بالعربيه ...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالعربيه</label>
                            <input type="text" autocomplete="nope" id="name_en" name="name_en" required class="form-control" placeholder="الاسم بالانجليزيه ...">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الوصف بالعربيه</label>
                            <textarea name="description_ar" id="description_ar" class="form-control" cols="30" rows="10" required ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الوصف بالانجليزيه</label>
                            <textarea name="description_en" id="description_en" class="form-control" cols="30" rows="10" required ></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">السعر </label>
                            <input type="number" autocomplete="nope" id="price" name="price" required class="form-control" placeholder="السعر ...">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الكميه المتاحه </label>
                            <input type="number" autocomplete="nope" id="quantity" name="quantity" required class="form-control" placeholder="ادخل  الكميه المتاحه من المنتج  ...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-1" class="control-label">تخفيض </label>
                            <input type="number" autocomplete="nope" id="discount" name="discount"  class="form-control" placeholder="ادخل نسبه الخصم...">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <select name="category_id" class="form-control"  required id="">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row->id); ?>" id="<?php echo e($row->id); ?>"><?php echo e($row->name_ar); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="col-sm-4 control-label">اضافه المزيد من الصور </label>
                                <input type="file" name="images[]" multiple class="dropify" data-max-file-size="5M">
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
        <h4 class="custom-modal-title">حذف المنتج</h4>
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
                    <form action="<?php echo e(route('deleteProduct')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="delete_id" value="">
                        <button style="margin-top: 35px" type="submit" class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5" style="margin-top: 19px">حـذف</button>
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


		$('.edit').on('click',function() {

			let id                  = $(this).data('id');
			let name_ar             = $(this).data('name_ar');
			let name_en             = $(this).data('name_en');
			let description_ar      = $(this).data('description_ar');
			let description_en      = $(this).data('description_en');
			let price               = $(this).data('price');
			let discount            = $(this).data('discount');
			let quantity            = $(this).data('quantity');
			let category_id         = $(this).data('category_id');


            $('#edit').find("input[name='id']").val(id);
            
            $('#name_ar').val(name_ar);
            $('#name_en').val(name_en);
            $('#description_ar').val(description_ar);
            $('#description_en').val(description_en);
            $('#price').val(price);
            $('#quantity').val(quantity);
            $('#discount').val(discount);
            $('#'+category_id).attr('selected','selected');

		});

		$('.delete').on('click',function(){

			let id         = $(this).data('id');
			$("input[name='delete_id']").val(id);

		});
    </script>

    <script>

        $(document).ready(function () {
            $('.slider').owlCarousel({
                items: 1,
                loop: false,
                rtl: true,
                autoplay: true
        })
        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.index', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>