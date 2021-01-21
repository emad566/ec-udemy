@extends('dashboard.master')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ trans('main.The Coupons') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('coupons.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{ trans('main.Show All') }}</a>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- /End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('main.The Coupons') }}</h4>
                    <h6 class="card-subtitle">{{ trans('main.Add New') }}</h6>
                    <hr>
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                    <form class="form" action="{{route('coupons.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {!! input(['errors'=>$errors, 'type'=>'text', 'name'=>'code', 'trans'=>'CouponCode', 'maxlength'=>20, 'required'=>'required', 'cols'=>6]) !!}
                            {!! input(['errors'=>$errors, 'type'=>'number', 'name'=>'discount', 'trans'=>'CouponDiscount', 'maxlength'=>20, 'required'=>'required', 'cols'=>6]) !!}
                        </div>

                        <div class="row">
                            {!! checkbox(['errors'=>$errors, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
                        </div>
                        <hr>
                        <div class="row">
                            {!! buttonAction() !!}
                        </div>

                    </form>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

