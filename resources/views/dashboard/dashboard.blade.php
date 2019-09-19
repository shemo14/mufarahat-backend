@extends('dashboard.index')
@section('title')
    الرئيسية
@endsection
@section('content')

    <div class="row">

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$users}}</h3>
                    <p> عدد المستخدمين</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{route('users')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$admins}}</h3>
                    <p> عدد المشرفين</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-secret"></i>
                </div>
                <a href="{{route('admins')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$roles}}</h3>
                    <p> عدد الصلاحيات</p>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
                <a href="{{route('permissionslist')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$cities}}</h3>
                    <p> عدد المدن</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building-o"></i>
                </div>
                <a href="{{route('cities')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$wharehouses}}</h3>
                    <p> عدد المستودعات</p>
                </div>
                <div class="icon">
                    <i class="fa fa-industry"></i>
                </div>
                <a href="{{route('warehouses')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$categories}}</h3>
                    <p> عدد الاقسام</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bars"></i>
                </div>
                <a href="{{route('categories')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$products}}</h3>
                    <p> عدد المنتجات</p>
                </div>
                <div class="icon">
                    <i class="fa fa-product-hunt"></i>
                </div>
                <a href="{{route('products')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$offers}}</h3>
                    <p> عدد العروض</p>
                </div>
                <div class="icon">
                    <i class="fa fa-percent"></i>
                </div>
                <a href="{{route('offers')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$boxes}}</h3>
                    <p> عدد البوكسات</p>
                </div>
                <div class="icon">
                    <i class="fa fa-archive"></i>
                </div>
                <a href="{{route('boxs')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$packagins}}</h3>
                    <p> عدد انواع التغليف</p>
                </div>
                <div class="icon">
                    <i class="fa fa-gift"></i>
                </div>
                <a href="{{route('packaging')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$coupons}}</h3>
                    <p> عدد الكوبونات </p>
                </div>
                <div class="icon">
                    <i class="fa fa-percent"></i>
                </div>
                <a href="{{route('coupons')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$questions}}</h3>
                    <p> عدد اسئله الاستبيان</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building-o"></i>
                </div>
                <a href="{{route('questions')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$commanQues}}</h3>
                    <p> عدد ا الاسئله  الشائعه </p>
                </div>
                <div class="icon">
                    <i class="fa fa-question-circle-o"></i>
                </div>
                <a href="{{route('commonQus')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <div class="small-box smallBoxCustom bg-aqua">
                <div class="inner">
                    <h3>{{$reports}}</h3>
                    <p> عدد التقارير</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text-o"></i>
                </div>
                <a href="{{route('allreports')}}" class="small-box-footer"> الذهاب <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

    </div>

@endsection