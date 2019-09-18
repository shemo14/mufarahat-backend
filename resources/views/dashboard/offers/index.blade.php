@section('styles')
@endsection

@extends('dashboard.index')
@section('title')
    العروض 
@endsection
@section('content')

    <div class="btn-group btn-group-justified m-b-10">
        <a href="#add" class="btn btn-success waves-effect btn-lg waves-light" data-animation="fadein" data-plugin="custommodal"
            data-overlaySpeed="100" data-overlayColor="#36404a">اضافة عرض  جديد <i class="fa fa-plus"></i> </a>
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
                        <th>اسم المنتج</th>
                        <th>المده </th>
                        <th>السعر</th>
                        <th>تخفيض </th>
                        <th>السعر بعد التخفيض </th>
                        <th>نشط</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($offers as $row)
                        <tr>
                            <td>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$row->id}}">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </td> 
                            <td>{{$row->product->name_ar}}</td>
                            <td>{{$row->time}}</td>
                            <td>{{$row->product->price}}</td>
                            <td>
                                <span class="label label-danger">{{$row->discount}} %</span>
                            </td>
                            <td>{{ $row->product->price - ($row->product->price * $row->discount)/100 }}</td>
                            <td>
                                @if($row->active == 1 )
                                    <span class="label label-success">نشط</span>
                                @else
                                    <span class="label label-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a"
                                        data-id                 = "{{$row->id }}"
                                        data-product_id         = "{{$row->product_id }}"
                                        data-time               = "{{$row->time}}"
                                        data-discount           = "{{$row->discount}}"
                                        data-active             = "{{$row->active}}"
                                    >
                                        <i class="fa fa-cogs"></i>
                                    </a>
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
            عرض جديد
        </h4>
        <form action="{{route('addOffer')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select name="product_id" class="form-control"  required id="">
                                <option> اختر المنتج --</option>
                                @foreach ($products as $row)
                                    <option value="{{$row->id}}">{{$row->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">تخفيض </label>
                            <input type="number" autocomplete="nope" name="discount"  class="form-control" placeholder="ادخل نسبه الخصم...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">مده العروض</label>
                            <input type="number" autocomplete="nope" name="time" required class="form-control" placeholder="مده العرض ...">
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
        <form id="edit" action="{{route('updateOffer')}}" method="post" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select name="product_id" class="form-control"  required id="">
                                @foreach ($products as $row)
                                    <option value="{{$row->id}}" id="{{$row->id}}">{{$row->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">مده العرض </label>
                            <input type="number" autocomplete="nope" id="time" name="time" required class="form-control" placeholder="السعر ...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">تخفيض </label>
                            <input type="number" autocomplete="nope" id="discount" name="discount"  class="form-control" placeholder="ادخل نسبه الخصم...">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <select name="active" class="form-control"  required id="">
                                <option value="1" id="active1">نشط</option>
                                <option value="0" id="active0">غير نشط</option>
                            </select>
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
        <h4 class="custom-modal-title">حذف العرض</h4>
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
                    <form action="{{route('deleteOffer')}}" method="post">
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

			let id          = $(this).data('id');
			let time        = $(this).data('time');
			let discount    = $(this).data('discount');
			let product_id  = $(this).data('product_id');
			let active      = $(this).data('active');
			


            $('#edit').find("input[name='id']").val(id);
            
            $('#discount').val(discount);
            $('#time').val(time);
            $('#'+product_id).attr('selected','selected');
            $('#active'+active).attr('selected','selected');

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
                    url: "{{route('deleteOffers')}}",
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

@endsection
