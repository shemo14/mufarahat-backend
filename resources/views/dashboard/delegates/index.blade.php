@section('styles')
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
@endsection

@extends('dashboard.index')
@section('title')
    المناديب المفعلين 
@endsection
@section('content')

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
                    @foreach($users as $user)
                        <tr>
                            <td>
                                @if($user->id == 1)
                                    <input type="checkbox" class="form-check-label" disabled>
                                @else
                                    <input type="checkbox" class="form-check-label checkSingle" id="{{$user->id}}">
                                @endif
                            </td>
                            <td><img src="{{appPath()}}/images/users/{{$user->avatar}}" alt="user-img" width="60px" title="Mat Helme" class="img-circle img-thumbnail img-responsive"></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->city->name_ar}}</td>
                            <td>{{$user->dalegateInformation->warehouse->name}}</td>
                            <td>{{$user->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a" style="color: #c89e28; font-weight: bold;"
                                        data-id             = "{{$user->id}}"
                                        data-phone          = "{{$user->phone}}"
                                        data-name           = "{{$user->name}}"
                                        data-email          = "{{$user->email}}"
                                        data-photo          = "{{$user->avatar}}"
                                        data-role           = "{{$user->role}}"
                                        data-city_id        = "{{$user->city_id}}"
                                        data-warehouse_id   = "{{$user->dalegateInformation->warehouse->id}}"
                                        data-address        = "{{$user->address}}"
                                    >
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    @if($user->id !== 1)
                                        <a href="#delete" class="delete btn btn-danger" style="color: #c83338; font-weight: bold;" data-animation="blur" data-plugin="custommodal"
                                            data-overlaySpeed="100" data-overlayColor="#36404a"
                                            data-id = "{{$user->id}}"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endif
                                    <a href="#active" class="active btn btn-warning" style="color: #c83338; font-weight: bold;" data-animation="blur" data-plugin="custommodal"
                                            data-overlaySpeed="100" data-overlayColor="#36404a"
                                            data-id = "{{$user->id}}"
                                        >
                                            <i class="fa fa-times"></i>
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
    <div id="add" class="modal-demo" >
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title" style="background-color: #36404a">
            مندوب جديد
        </h4>
        <form action="{{route('adddelegate')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
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
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">المستودع</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="warehouse_id">
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @endforeach
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
        <form action="{{route('editdelegate')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
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
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" id="c_{{$city->id}}">{{$city->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">المستودع</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="warehouse_id">
                                    
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{$warehouse->id}}" id="w_{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @endforeach
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


    <div id="active" class="modal-demo" style="position:relative; right: 32%">
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title">الغاء تفعيل المندوب</h4>
        <div class="custombox-modal-container" style="width: 400px !important; height: 160px;">
            <div class="row">
                <div class="col-sm-12">
                    <h3 style="margin-top: 35px">
                        هل تريد مواصلة عملية الغاء التفعيل  ؟
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{route('activate')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="active_id" value="">
                        <button style="margin-top: 35px" type="submit" class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 send-delete-all"  style="margin-top: 19px">الغاء التفعيل </button>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
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
                    <form action="{{route('deleteadmin')}}" method="post">
                        {{csrf_field()}}
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

@endsection

@section('script')

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

        $('.active').on('click',function(){
            let id         = $(this).data('id');
            $("input[name='active_id']").val(id);
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
                    url: "{{route('deleteadmins')}}",
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