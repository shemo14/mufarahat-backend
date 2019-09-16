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
    الكوبونات
@endsection
@section('content')

    <div class="row">

        <div class="btn-group btn-group-justified m-b-10">
            <a href="#add" class="btn btn-success waves-effect btn-lg waves-light" data-animation="fadein" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a">اضافة كوبون <i class="fa fa-plus"></i> </a>
            <a class="btn btn-primary waves-effect btn-lg waves-light" onclick="window.location.reload()" role="button">تحديث الصفحة <i class="fa fa-refresh"></i> </a>
        </div>

        <div class="col-sm-12">
            <div class="card-box table-responsive boxes">
                <table id="datatable" class="table table-bordered table-responsives">
                    <thead>
                    <tr>
                      
                        <th>الرقم</th>
                        <th> عدد مرات الاستخدام المتبقيه</th>
                        <th>تاريخ الانتهاء</th>
                        <th>القسم التابع له </th>
                        <th>نسبه الخصم </th>
                        <th>تاريخ التسجيل</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($coupons as $row)
                        <tr>
                            <td>{{$row->number}}</td>
                            <td>{{$row->usage_number}}</td>
                            <td>{{date('d/m/Y', strtotime($row->expire_date))}}</td>
                            <td>{{$row->category->name_ar}}</td>
                            <td>{{$row->discount}}</td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a" style="color: #c89e28; font-weight: bold;"
                                        data-id               = "{{$row->id}}"
                                        data-number           = "{{$row->number}}"
                                        data-usage_number     = "{{$row->usage_number}}"
                                        data-expire_date      = "{{$row->expire_date}}"
                                        data-category_id      = "{{$row->category_id}}"
                                        data-discount         = "{{$row->discount}}"
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
            كوبون  جديد
        </h4>
        <form action="{{route('addCoupons')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">رقم الكوبون</label>
                            <input type="text" autocomplete="nope" name="number" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">عدد مرات الاستخدام</label>
                            <input type="text" autocomplete="nope" name="usage_number" required class="form-control ">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">تاريخ الانتهاء</label>
                            <input type="date" autocomplete="nope" name="expire_date" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">القسم </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category_id">
                                    @foreach($Categories as $city)
                                        <option value="{{$city->id}}" id="{{$city->id}}">{{$city->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-3" class="control-label">نسبه الخصم </label>
                                <input type="number" autocomplete="nope" name="discount" required class="form-control">
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
        <form action="{{route('updateCoupons')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">رقم الكوبون </label>
                            <input type="text" id="number"  name="number" value="" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">عدد مرات الاستخدام المتبقيه</label>
                            <input type="text" id="usage_number"  name="usage_number" value="" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">تاريخ الانتهاء</label>
                            <input type="date"  id="expire_date" name="expire_date" value=""  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">القسم</label>
                            <select class="form-control" name="category_id">
                                @foreach($Categories as $city)
                                    <option value="{{$city->id}}" id="c_{{$city->id}}">{{$city->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-3" class="control-label">نسبه الخصم </label>
                            <input type="text"  id="discount" name="discount" value="" required class="form-control">
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
        <h4 class="custom-modal-title">حذف  كوبون</h4>
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
                    <form action="{{route('deleteCoupons')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="delete_id" value="">
                        <button style="margin-top: 35px" type="submit" class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5 send-delete-all"  style="margin-top: 19px">حـذف</button>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>

@endsection

@section('script')

    <script>
        $('.edit').on('click',function(){
            let id                = $(this).data('id');
            let number            = $(this).data('number');
            let usage_number      = $(this).data('usage_number');
            let expire_date       = $(this).data('expire_date');
            let category_id       = $(this).data('category_id');
            let discount          =  $(this).data('discount');

            $("input[name='id']").val(id);
            $("#number").val(number);
            $("#usage_number").val(usage_number);
            $("#expire_date").val(expire_date);
            $("#discount").val(discount);
            $("#c_"+category_id).attr('selected','true');
        });

        $('.delete').on('click',function(){
            let id         = $(this).data('id');
            $("input[name='delete_id']").val(id);

        });
    </script>

@endsection