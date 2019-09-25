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
    طلبات المندوب
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive boxes">
                <table id="datatable" class="table table-bordered table-responsives">
                    <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>اسم العميل</th>
                        <th>السعر </th>
                        <th>نوع التغليف</th>
                        <th>رقم الكوبون</th>
                        <th>طريقه الدفع</th>
                        <th>حاله الطلب </th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->price}}</td>
                            <td>{{$order->packaging->name}}</td>
                            <td>{{$order->coupon != null ? $order->coupon->number : 'لايوجد'}}</td>
                            <td>
                                @if ($order->payment_type == 0)
                                    فيزا
                                @endif
                                @if ($order->payment_type == 1)
                                    مدي
                                @endif
                                @if ($order->payment_type == 2)
                                    دفع عند الاستلام
                                @endif
                                @if ($order->payment_type == 3)
                                    Apple Pay
                                @endif <br>
                            </td>
                            <td>
                                @if ($order->status == 0)
                                    طلب جديد 
                                @endif
                                @if ($order->status == 1)
                                    قيد التنفيذ
                                @endif
                                @if ($order->status == 2)
                                    طلب منفذ  
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->

    </div>

    
@endsection

@section('script')

    <script>
       
    </script>

@endsection