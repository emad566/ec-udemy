
@extends('dashboard.master', ['datatable'=>1])

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ trans('main.The Blog') }} / {{ trans('main.Edit') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('brands.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{ trans('main.Add New') }}</a>
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
                    <h4 class="card-title">{{ trans('main.The Brands') }}</h4>
                    <h6 class="card-subtitle"></h6>
                    <div class="row">
                        <div class="col-lg-4 col-xs-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <i class="ft-home"></i> Edit Brand: {{ $brand->brand_name }}</h4>
                                </div>
                                <div class="card-body">
                                    @include('dashboard.includes.alerts.success')
                                    @include('dashboard.includes.alerts.errors')
                                    <form class="form" action="{{route('brands.update', $brand->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type='hidden' name='_method' value='PUT'>
                                        <input type='hidden' name='id' value='{{ $brand->id }}'>


                                        <input type="hidden" name="id" value="{{ $brand->id }}">
                                        <div class="row">
                                            {!! input(['errors'=>$errors, 'edit'=>$brand, 'type'=>'text', 'name'=>'brand_name', 'trans'=>'Brand Name', 'maxlength'=>20, 'required'=>'required', 'cols'=>12]) !!}
                                            {!! img(['errors'=>$errors, 'edit'=>$brand, 'type'=>'text', 'name'=>'image', 'trans'=>'Image', 'cols'=>12]) !!}
                                        </div>

                                        <div class="row">
                                            {!! checkbox(['errors'=>$errors, 'edit'=>$brand, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
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
                        <div class="col-lg-8 col-xs-12 table-responsive">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <i class="ft-home"></i> {{ trans('main.The Brands') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form id='delete-formMulti' class='delete-formMulti'
                                        method='post'
                                        action='{{ route('brands.delete') }}'>
                                        @csrf
                                        <input type='hidden' name='_method' value='post'>

                                        @include('dashboard.includes.alerts.success')
                                        @include('dashboard.includes.alerts.errors')

                                        @php
                                            $fields = [
                                                ['image', 'Image', 'img'],
                                                ['brand_name', 'Brand Name'],
                                                ['created_at', 'Created_at'],
                                                ];
                                        @endphp

                                        <div class="table-responsive m-t-40">
                                            {!! indexTable([
                                                'objs'=>$brands,
                                                'table'=>'brands',
                                                'title'=>'brand_name',
                                                'trans'=>'brand Name',
                                                'active'=>true,
                                                'indexEdit'=>true,
                                                'indexDel'=>true,
                                                'isread'=>false,
                                                'view'=>false,
                                                'vars'=>false,
                                                'fields'=>$fields
                                            ]) !!}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(document).on("change", '#allbrands', function(event) {
                if($(this).is(':checked')){
                    $('.brands').attr('checked', true)
                }else{
                    $('.brands').attr('checked', false)
                }
            });
        })
    </script>
@endsection

