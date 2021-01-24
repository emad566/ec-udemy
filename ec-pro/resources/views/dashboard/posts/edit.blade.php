@extends('dashboard.master', ['form'=>1, 'textEeditor'=>1])

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ trans('main.The Blog') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <a href="{{ route('posts.index') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{ trans('main.Show All') }}</a>
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
                    <h4 class="card-title">{{ trans('main.The Blog') }}</h4>
                    <h6 class="card-subtitle">{{ trans('main.Edit') }}</h6>
                    <hr>
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                    <form class="form" action="{{route('posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{ $post->id }}">

                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$post, 'type'=>'text', 'name'=>'post_title', 'trans'=>'Post Title', 'maxlength'=>191, 'required'=>'required', 'cols'=>12]) !!}
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_id"> {{ trans('main.The Category') }}
                                    </label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">{{ trans('main.No Parent') }}</option>
                                        <?php
                                            $traverse = '';
                                            $traverse = function ($categories, $prefix = '') use (&$traverse, $post) {
                                                foreach ($categories as $category_item) {
                                        ?>
                                                    <option @if($category_item->id == old('category_id') || $category_item->id == $post->category_id ) selected @endif value="{{$category_item-> id }}">{{ PHP_EOL.$prefix.' '.$category_item->category_name }}</option>
                                        <?php
                                                    $traverse($category_item->children, $prefix.'-');
                                                }
                                            };

                                            $traverse($categories);

                                        ?>
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger"> {{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            {!! textarea(['errors'=>$errors, 'edit'=>$post, 'type'=>'text', 'name'=>'post_details', 'trans'=>'Post Details', 'maxlength'=>10000, 'cols'=>12, 'attr'=>'rows=5', 'class'=>'textEeditor']) !!}
                            {!! input(['errors'=>$errors, 'edit'=>$post, 'type'=>'text', 'name'=>'post_tags', 'trans'=>'Post Tags', 'maxlength'=>191, 'cols'=>12, 'attr'=>'data-role="tagsinput"']) !!}
                        </div>

                        <div class="row">
                            {!! img(['errors'=>$errors, 'edit'=>$post, 'type'=>'text', 'name'=>'image', 'trans'=>'Image', 'cols'=>12]) !!}
                        </div>

                        <hr>
                        <div class="row">
                            {!! checkbox(['errors'=>$errors, 'edit'=>$post, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
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

