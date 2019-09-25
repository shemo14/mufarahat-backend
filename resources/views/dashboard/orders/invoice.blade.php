@section('styles')
<style type="text/css">
.btn-primary {
    background-color: #188ae2 !important;
    border: 1px solid #188ae2 !important;
    margin: 9px !important;
    width: 21% !important;
    height: 46px !important;
}
</style>
@endsection
@extends('dashboard.index')
@section('title')
  الفاتوره رقم {{$order->id}}
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-primary" onclick="printArea()">طباعه </button>
            <div class="card-box table-responsive boxes" id="printed_table">
            {{-- invoic header --}}
                <div class="row">
                    <div class="col-xs-6 text-left">
                      <h1>فاتوره</h1>
                    <h1><small>فاتوره رقم #{{$order->id}}</small></h1>
                    </div>
                    <div class="col-xs-6 text-right" >
                        <h1>
                            <a  style="font-family: JF-Flat;" class="logo"><img class="site-logo" src="{{appPath()}}/images/site/logo.png" width="100%" style="height: 70px;"><i style="color: #fff !important;" class="fa fa-home"></i></a>
                        </h1>
                    </div>
                </div>
            {{-- #invoic header --}}

            {{-- site and user details --}}
                <div class="row">
                    <div class="col-xs-5">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                <h4>من : <a href="#">{{settings('site_name_ar')}}</a></h4>
                                </div>
                                <div class="panel-body">
                                <p>
                                    {{settings('address_ar')}}<br>
                                    {{Request::root()}}<br>
                                    {{settings('phone')}}<br>
                                </p>
                                </div>
                            </div>
                    </div>
                    <div class="col-xs-5 col-xs-offset-2 text-left">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                <h4>العميل : <a href="#">{{$order->user->name}}</a></h4>
                                </div>
                                <div class="panel-body">
                                <p>
                                    {{$order->phone != null  ? $order->phone : $order->user->phone }}<br>
                                    {{$order->name != null  ? $order->name : $order->user->name }}<br>
                                </p>
                                </div>
                            </div>
                    </div>
                </div>
            {{-- #site and user details --}}
            
            {{-- order table all products --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><h4>المنتج</h4></th>
                            <th><h4>الكميه</h4></th>
                            <th><h4>السعر</h4></th>
                            <th><h4>اجمالي السعر </h4></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->quantity}}</td>
                                <td class="text-right">{{$item->price}}</td>
                                <td class="text-right">{{$item->quantity * $item->price}} </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            {{-- #order table all products --}}
            
            {{-- Money div--}}
                <div class="row">
                    <div class="col-xs-6">
                        <p>
                            <strong>
                                 نوع التغليف : <br>
                                 طريقه الدفع  : <br>
                                 الكوبون :  <br>
                                اجمالي السعر : <br>
                            </strong>
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <strong>
                           {{$order->packaging->name}} <br>
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
                            {{$order->coupon != null ? $order->coupon->number : 'لايوجد'}} <br>
                            {{$order->price}} <br>
                        </strong>
                    </div>
                </div>
            {{-- #Money div --}}

            {{--  footer --}}
                <div class="row">
                    <div class="col-xs-5">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>Paypal details</h4>
                            </div>
                            <div class="panel-body">
                                <p>tahirtaous@live.com</p>
                                <!--  <p>Bank Name</p>
                            <p>SWIFT : --------</p>
                            <p>Account Number : --------</p>
                            <p>IBAN : --------</p> -->
                            </div>
                        </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="span7">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4>معلومات التواصل</h4>
                                </div>
                                <div class="panel-body">
                                    <p>
                                        العنوان : {{settings('address_ar')}}<br><br>
                                        الهاتف : {{settings('phone')}}<br> <br>
                                        الايميل : {{settings('email')}}<br> <br>
                                    </p>
                                    <!--  <h4>Payment should be mabe by Bank Transfer</h4> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- #footer --}}

            </div>
        </div><!-- end col -->
    </div>
@endsection
@section('script')
    <script>
    function printArea(){
        $('body').css('visibility', 'hidden');
        $('#printed_table').css('visibility', 'visible');
        window.print();
    }
    </script>
@endsection
