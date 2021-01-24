@extends('dashboard.master', ['form'=>1, 'textEeditor'=>1])

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ trans('main.The Products') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('products.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{ trans('main.Show All') }}</a>
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
                    <h4 class="card-title">{{ trans('main.The Products') }}</h4>
                    <h6 class="card-subtitle">{{ trans('main.Edit') }}</h6>
                    <hr>
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                    <form class="form" action="{{route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{ $product->id }}">

                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'product_name', 'trans'=>'Product Name', 'maxlength'=>191, 'required'=>'required', 'cols'=>6]) !!}
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'product_code', 'trans'=>'Product Code', 'maxlength'=>20, 'required'=>'required', 'cols'=>6]) !!}
                        </div>

                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'number', 'name'=>'product_quantity', 'trans'=>'Product Quantity', 'maxlength'=>5, 'required'=>'required', 'cols'=>6]) !!}
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'number', 'name'=>'selling_price', 'trans'=>'Selling Price', 'maxlength'=>8, 'required'=>'required', 'cols'=>6, 'attr'=>'min="0" value="0" max="999999" step="0.01"']) !!}
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id"> {{ trans('main.The Category') }}
                                    </label>
                                    <select name="category_id" id="category_id" class="form-control  " >
                                        <option value="">{{ trans('main.No Parent') }}</option>
                                        <?php
                                            $traverse = '';
                                            $traverse = function ($categories, $prefix = '') use (&$traverse, $product) {
                                                foreach ($categories as $category_item) {
                                        ?>
                                                    <option @if(in_array($category_item->id, $product->categories()->pluck('category_id')->toArray())) selected @endif value="{{$category_item->id }}">{{$category_item->id }} =
                                                        {{ PHP_EOL.$prefix.' '.$category_item->category_name }}</option>
                                        <?php
                                                    $traverse($category_item->children, $prefix.'-');
                                                }
                                            };

                                            $traverse($nodes);

                                        ?>
                                    </select>

                                    @error('category_id')
                                    <span class="text-danger"> {{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            {!! select(['errors'=>$errors, 'edit'=>$product, 'name'=>'brand_id', 'frkName'=>'brand_name', 'rows'=>$brands, 'trans'=>'The Brand', 'label'=>true, 'cols'=>4 ]) !!}
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'product_size', 'trans'=>'Product Size', 'maxlength'=>50, 'cols'=>4, 'attr'=>'data-role="tagsinput"']) !!}
                        </div>

                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'product_weight', 'trans'=>'Product Weight', 'maxlength'=>50,'cols'=>4, 'attr'=>'min="0" value="0" max="999999" step="0.01"']) !!}
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'product_color', 'trans'=>'Product Colors', 'cols'=>4, 'attr'=>'data-role="tagsinput"']) !!}
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'number', 'name'=>'discount_price', 'trans'=>'Discount Price', 'maxlength'=>2, 'cols'=>4]) !!}
                        </div>

                        <div class="row">
                            {!! textarea(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'product_details', 'trans'=>'Product Details', 'maxlength'=>10000, 'cols'=>12, 'attr'=>'rows=5', 'class'=>'textEeditor']) !!}
                        </div>

                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'video_link', 'trans'=>'Video Link', 'maxlength'=>191, 'cols'=>12]) !!}
                        </div>

                        <div class="row">
                            {!! img(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'image_one', 'trans'=>'Image One ( Main Thumbnali)', 'required'=>'required', 'cols'=>4]) !!}
                            {!! img(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'image_two', 'trans'=>'Image Two','cols'=>4]) !!}
                            {!! img(['errors'=>$errors, 'edit'=>$product, 'type'=>'text', 'name'=>'image_three', 'trans'=>'Image Three','cols'=>4]) !!}
                        </div>

                        <hr>
                        <div class="row">
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'main_slider', 'trans'=>'Main Slider', 'cols'=>3, 'check'=>false]) !!}
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'hot_deal', 'trans'=>'Hot Deal', 'cols'=>3, 'check'=>false]) !!}
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'best_rated', 'trans'=>'Best Rated', 'cols'=>3, 'check'=>false]) !!}
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'mid_slider', 'trans'=>'Mid Slider', 'cols'=>3, 'check'=>false]) !!}
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'hot_new', 'trans'=>'Hot New', 'cols'=>3, 'check'=>false]) !!}
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'buyone_getone', 'trans'=>'Buyone Getone', 'cols'=>3, 'check'=>false]) !!}
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'trend', 'trans'=>'Trend Product', 'cols'=>3, 'check'=>false]) !!}
                        </div>

                        <hr>
                        <div class="row">
                            {!! checkbox(['errors'=>$errors, 'edit'=>$product, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
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

