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
    انواع التغليف 
@endsection
@section('content')

    <div class="row">

        <div class="btn-group btn-group-justified m-b-10">
            <a href="#add" class="btn btn-success waves-effect btn-lg waves-light" data-animation="fadein" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a">اضافة نوع جديد  <i class="fa fa-plus"></i> </a>
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
                            <label class="custom-control material-checkbox" style="margin: auto">
                                <input type="checkbox" class="material-control-input" id="checkedAll">
                                <span class="material-control-indicator"></span>
                            </label>
                        </th>
                        <th>الاسم بالعربيه </th>
                        <th>الاسم بالانجليزيه </th>
                        <th>السعر</th>
                        <th>تاريخ التسجيل</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($packagings as $row)
                        <tr>
                            <td>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$row->id}}">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </td> 
                            <td>{{$row->name_ar}}</td>
                            <td>{{$row->name_en}}</td>
                            <td>{{$row->price}}</td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a" style="color: #c89e28; font-weight: bold;"
                                        data-id                = "{{$row->id}}"
                                        data-name_en           = "{{$row->name_ar}}"
                                        data-name_ar           = "{{$row->name_en}}"
                                        data-price             = "{{$row->price}}"
                                    >
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <a href="#delete" class="delete btn btn-danger" style="color: #c83338; font-weight: bold;" data-animation="blur" data-plugin="custommodal"
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
    <div id="add" class="modal-demo" >
        <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
            <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
        </button>
        <h4 class="custom-modal-title" style="background-color: #36404a">
        نوع تغليف  جديد
        </h4>
        <form action="{{route('addPackaging')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label"> الاسم بالعربيه</label>
                            <input type="text" autocomplete="nope" name="name_ar" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">الاسم بالانجليزيه</label>
                            <input type="text" autocomplete="nope" name="name_en" required class="form-control ">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">السعر </label>
                            <input type="number" autocomplete="nope" name="price" required class="form-control">
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
        <form action="{{route('updatePackaging')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالعربيه</label>
                            <input type="text"  name="name_ar" id="name_ar" value="" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">الاسم بالانجليزيه</label>
                            <input type="text"  name="name_en" id="name_en" value="" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">السعر</label>
                            <input type="number" name="price" id="price" value="" required class="form-control">
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
        <h4 class="custom-modal-title">حذف  النوع</h4>
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
                    <form action="{{route('deletePackaging')}}" method="post">
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
            let id           = $(this).data('id');
            let name_ar      = $(this).data('name_ar');
            let name_en      = $(this).data('name_en');
            let price        = $(this).data('price');

            $("input[name='id']").val(id);
            $("#name_ar").val(name_ar);
            $("#name_en").val(name_en);
            $("#price").val(price);
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
                    url: "{{route('deletePackagings')}}",
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