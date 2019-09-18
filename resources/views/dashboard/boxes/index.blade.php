@section('styles')
@endsection

@extends('dashboard.index')
@section('title')
    البوكسات
@endsection
@section('content')

    <div class="btn-group btn-group-justified m-b-10">
        <a href="#add" class="btn btn-success waves-effect btn-lg waves-light" data-animation="fadein" data-plugin="custommodal"
            data-overlaySpeed="100" data-overlayColor="#36404a">اضافة بوكس جديد <i class="fa fa-plus"></i> </a>
        <a href="#deleteAll" class="btn btn-danger waves-effect btn-lg waves-light delete-all" data-animation="blur" data-plugin="custommodal"
        data-overlaySpeed="100" data-overlayColor="#36404a">حذف المحدد <i class="fa fa-trash"></i> </a>
        <a class="btn btn-primary waves-effect btn-lg waves-light" onclick="window.location.reload()" role="button">تحديث الصفحة <i class="fa fa-refresh"></i> </a>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="card-box table-responsive boxes">

                <table id="datatable" class="table table-bordered table-responsives">
                    <thead>
                    <tr>
                        <th>
                            <label class="custom-control material-checkbox" style="margin: auto">
                                <input type="checkbox" class="material-control-input" id="checkedAll">
                                <span class="material-control-indicator"></span>
                            </label>
                        </th>
                        <th>الصورة</th>
                        <th>الاسم بالعربية</th>
                        <th>الاسم بالانجليزية</th>
                        <th>السعر</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($boxes as $row)
                        <tr>
                            <td>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$row->id}}">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </td>
                            <td><a href="{{appPath()}}/images/boxes/{{$row->image}}" target="_blank"><img src="{{appPath()}}/images/boxes/{{$row->image}}" alt="user-img" width="60px" title="Mat Helme" class="img-circle img-thumbnail img-responsive"></a></td>
                            <td>{{$row->name_ar}}</td>
                            <td>{{$row->name_en}}</td>
                            <td>{{$row->price}}</td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a"
                                        data-id         = "{{$row->id}}"
                                        data-name_ar     = "{{$row->name_ar}}"
                                        data-name_en = "{{$row->name_en}}"
                                        data-price = "{{$row->price}}"
                                    >
                                        <i class="fa fa-cogs"></i>
                                    </a>

                                    <a href="#boxproducts{{$row->id}}" class="edit btn btn-primary" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a">
                                        <i class="fa fa-product-hunt"></i>
                                    </a>
                                    <div id="boxproducts{{$row->id}}" class="modal-demo">
                                        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
                                            <span>&times</span><span class="sr-only" style="color: #36404a">Close</span>
                                        </button>
                                        <h4 class="custom-modal-title" style="background-color: #36404a">
                                            تحديث المنتجات داخل البوكس  
                                        </h4>
                                        <form action="{{route('EditBoxProducts')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input type="number" hidden name="box_id" value="{{$row->id}}">
                                            <div class="modal-body products_div_edit">
                                                @foreach ($row->items as $item)
                                                    <div class="row "  style="margin-top: 15px;">
                                                        <div class="col-md-12">
                                                           <div class="col-md-6">
                                                               <select  class="form-control" name="product[]" required>
                                                                   @foreach ($products as $row)
                                                                       <option value="{{$row->id}}" {{$item->product_id == $row->id ? 'selected' : ''}}>{{$row->name_ar}}</option>
                                                                   @endforeach
                                                               </select>
                                                           </div>
                                                           <div class="col-md-4">
                                                           <input type="number" class="form-control" placeholder="عدد القطع من هذا النوع"   value="{{$item->quantity}}" id="product_ammount" name="ammounts[]" required>
                                                           </div>
                                                           <div class="col-md-2">
                                                                <input type="button" value="حذف" class="btn btn-danger remove">
                                                           </div>
                                                       </div>
                                                   </div> 
                                                @endforeach
                                            </div>
                                            <div class="row" style="margin-top: 5px;margin-bottom: 5px;">
                                                <div class="col-md-3" style="margin: 4px;">
                                                        <input type="button" value="اضافه المزيد" class="btn btn-primary float-right" id="add_product_edit" >
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">تعديل</button>
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" onclick="Custombox.close();">رجوع</button>
                                            </div>
                                        </form>
                                    </div>

                                    <a href="#delete" class="delete btn btn-danger" data-animation="blur" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a"
                                        data-id = "{{$row->id}}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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
            قسم جديد
        </h4>
        <form action="{{route('addBox')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالعربية</label>
                            <input type="text" autocomplete="nope" name="name_ar" required class="form-control" placeholder="الاسم بالعربية ...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">الاسم بالانجليزية</label>
                            <input type="text" autocomplete="nope" name="name_en" required class="form-control" placeholder="الاسم بالانجليزية ...">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-2" class="control-label">السعر</label>
                            <input type="number" autocomplete="nope" name="price" required class="form-control" placeholder="سعر البوكس...">
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="col-sm-4 control-label">صورة البوكس</label>
                                <input type="file" name="image2" class="dropify" data-max-file-size="1M">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row products_div"  style="margin-top: 15px;">
                     <div class="col-md-12">
                        <div class="col-md-6">
                            <select  class="form-control" name="product[]" required>
                                <option value=""> قم باختيار المنتجات</option>
                                @foreach ($products as $row)
                                    <option value="{{$row->id}}">{{$row->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" placeholder="عدد القطع من هذا النوع" id="product_ammount" name="ammounts[]" required>
                        </div>
                        <div class="col-md-2">
                            <input type="button" value="اضافه المزيد" class="btn btn-primary" id="add_product">
                        </div>
                        <input type="hidden" name="products_array" id="products_array">
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
            تعديل <span id="row"></span>
        </h4>
        <form id="edit" action="{{route('updateBox')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالعربية</label>
                            <input type="text" autocomplete="nope" name="name_ar" required class="form-control" placeholder="الاسم بالعربية ...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">الاسم بالانجليزية</label>
                            <input type="text" autocomplete="nope" name="name_en" required class="form-control" placeholder="الاسم بالانجليزية ...">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-2" class="control-label"> السعر</label>
                            <input type="number" autocomplete="nope" name="price" required class="form-control" placeholder="سعر البوكس...">
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="col-sm-4 control-label">صورة البوكس</label>
                                <input type="file" name="image2" class="dropify" data-max-file-size="1M">
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
        <h4 class="custom-modal-title">حذف </h4>
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
                    <form action="{{route('deleteBox')}}" method="post">
                        {{csrf_field()}}
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
   

@endsection

@section('script')
    <script>


		$('.edit').on('click',function() {

			let id      = $(this).data('id');
			let name_ar = $(this).data('name_ar');
			let name_en = $(this).data('name_en');
			let price   = $(this).data('price');


            $('#edit').find("input[name='id']").val(id);
            $('#edit').find("input[name='name_ar']").val(name_ar);
            $('#edit').find("input[name='name_en']").val(name_en);
            $('#edit').find("input[name='price']").val(price);
			
			$("#row").html(name_ar);
		});

		$('.delete').on('click',function(){

			let id         = $(this).data('id');
			$("input[name='delete_id']").val(id);

		});

        function addProductDiv(parentDivName){
            var products ;
             products += '@foreach ($products as $item)';
             products += '<option value="{{$item->id}}">{{$item->name_ar}}</option>';
             products += '@endforeach';

            var input1 = '<div class="col-md-12">';
            input1 += '<div class="col-md-6">';
            input1 += '<select  class="form-control" name="product[]" required>';
            input1 += '<option value=""> قم باختيار المنتجات</option>';
            input1 +=  products;
            input1 += ' </select>';
            input1 += '</div>';
            input1 += '<div class="col-md-4">';
            input1 += ' <input type="number" class="form-control" placeholder="عدد القطع من هذا النوع" id="product_ammount" name="ammounts[]" required>';
            input1 += '</div>';
            input1 += '<div class="col-md-2">';
            input1 += '<input type="button" value="حذف" class="btn btn-danger remove" id="add_product">';
            input1 += '</div>';
            $('.'+parentDivName).append(input1);
        }

		$('#add_product').on('click',function(){
            addProductDiv('products_div');
		});
		$('#add_product_edit').on('click',function(){
            addProductDiv('products_div_edit');
		});


        $(document).on('click','.remove',function (e) {
            e.preventDefault(); $(this).parent('div').parent('div').remove(); 
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
                    url: "{{route('deleteBoxs')}}",
                    data: {data: requestData, _token: '{{csrf_token()}}'},
                    success: function( msg ) {
                        if (msg == 'success') {
                            location.reload()
                        }
                    }
                });
            }
        });


		
    </script>

@endsection
