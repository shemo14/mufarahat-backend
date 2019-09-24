@section('styles')
@endsection

@extends('dashboard.index')
@section('title')
    @php
        if ($status > 0 ) {
           $title = $status == 1 ? 'الطلبات قيد  التنفيذ ' : 'الطلبات المنفذه ' ;
        }else
        {
             $title = 'الطلبات الجديده' ;
        }
    @endphp
        {{$title}}
@endsection
@section('content')

    <div class="btn-group btn-group-justified m-b-10">
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
                        <th>اسم المستخدم</th>
                        <th>السعر</th>
                        <th>الكوبون </th>
                        <th>نوع التغليف </th>
                        <th>طريقه الدفع</th>
                        <th>المندوب</th>
                        <th>عرض الفاتوره</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($orders as $row)
                        <tr>
                            <td>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$row->id}}">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </td>
                            <td>{{$row->user->name}}</td>
                            <td>{{$row->price}}</td>
                            <td>{{$row->coupon != null ? $row->coupon->number : 'لايوجد'}}</td>
                            <td>{{$row->packaging->name}}</td> 
                            <td>
                                @if ($row->payment_type == 0)
                                    فيزا
                                @endif
                                @if ($row->payment_type == 1)
                                    مدي
                                @endif
                                @if ($row->payment_type == 2)
                                    دفع عند الاستلام
                                @endif
                                @if ($row->payment_type == 3)
                                    Apple Pay
                                @endif
                            </td> 
                            <td>{{$row->dalegate != null ?  $row->dalegate->name  : 'لايوجد'}}</td> 
                            <td><a href="{{ route('showinvoice', $row->id) }}"> عرض الفاتوره</a></td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                        
                            <td>
                                <a href="#edit" class="edit btn btn-success" data-animation="fadein" data-plugin="custommodal"
                                        data-overlaySpeed="100" data-overlayColor="#36404a"
                                        data-user               = "{{$row->user->name}}"
                                        data-coupon             = "{{$row->coupon != null ? $row->coupon->number : 'لايوجد'}}"
                                        data-packaging          = "{{$row->packaging->name_ar}}"
                                        data-payment_type       = "{{$row->payment_type}}"
                                        data-dalegate           = "{{$row->dalegate != null ?  $row->dalegate->name  : 'لايوجد'}}"
                                        data-price              = "{{$row->price}}"
                                        data-notes              = "{{$row->notes}}"
                                        data-name               = "{{$row->name}}"
                                        data-phone              = "{{$row->phone}}"
                                    >
                                        <i class="fa fa-cogs"></i>
                                </a>
                                <div class="btn-group" role="group" aria-label="Basic example">
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

    <!-- edit user modal -->
    <div id="edit" class="modal-demo">
            <button type="button" class="close" onclick="Custombox.close();" style="opacity: 1">
                <span>&times</span><span class="sr-only" style="color: #f7f7f7">Close</span>
            </button>
            <h4 class="custom-modal-title" style="background-color: #36404a">
                تعديل <span id="category"></span>
            </h4>
      
            <form id="edit">
                <div class="modal-body">
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">اسم العميل</label>
                                <input type="text" autocomplete="nope" id="user" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">رقم الكوبون</label>
                                <input type="text" id="coupon" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">نوع التغليف</label>
                                <input type="text" autocomplete="nope" id="packaging" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">طريقه الدفع</label>
                                <input type="text" id="payment_type" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">اسم المندوب</label>
                                <input type="text" autocomplete="nope" id="dalegate" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">سعر الطلب</label>
                                <input type="number" id="price" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">اسم المستلم</label>
                                <input type="text" autocomplete="nope" id="name" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">رقم الهاتف </label>
                                <input type="text" id="phone" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">ملاحظات</label>
                                <textarea id="notes" class="form-control" cols="30" rows="10" readonly></textarea>
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
                    <form action="{{route('deleteOrder')}}" method="post">
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
			let user               = $(this).data('user');
			let coupon             = $(this).data('coupon');
			let packaging          = $(this).data('packaging');
			let payment_type       = $(this).data('payment_type');
			let dalegate           = $(this).data('dalegate');
			let price              = $(this).data('price');
			let notes              = $(this).data('notes');
			let name               = $(this).data('name');
			let phone              = $(this).data('phone');
            
            $('#user').val(user);
            $('#coupon').val(coupon);
            $('#packaging').val(packaging);
            $('#payment_type').val(payment_type);
            $('#price').val(price);
            $('#dalegate').val(dalegate);
            $('#notes').val(notes);
            $('#name').val(name);
            $('#phone').val(phone);

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
                    url: "{{route('deleteOrders')}}",
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
