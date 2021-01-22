@extends('dashboard.master')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- page-title Bread crumb and right sidebar toggle  -->
    <!-- ============================================================== -->

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ trans('main.The Categories') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">

                <a href="{{ route('categories.create') }}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{ trans('main.Add New') }}</a>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End page-title Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('main.The Categories') }}</h4>
                    <h6 class="card-subtitle">{{ trans('main.Edit') }}: {{ $category->category_name }}</h6>
                    <hr>
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                    <form class="form" action="{{route('categories.update', $category->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type='hidden' name='_method' value='PUT'>
                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$category, 'type'=>'text', 'name'=>'category_name', 'trans'=>'Category Name', 'maxlength'=>50, 'required'=>'required', 'cols'=>12]) !!}
                        </div>

                        <div class="row">
                            {!! input(['errors'=>$errors, 'edit'=>$category, 'type'=>'text', 'name'=>'slug', 'trans'=>'Slug', 'maxlength'=>50, 'required'=>'required', 'cols'=>12]) !!}
                        </div>

                        <div class="row">
                            {!! textarea(['errors'=>$errors, 'edit'=>$category, 'type'=>'text', 'name'=>'description', 'trans'=>'Cetegory Description', 'maxlength'=>150, 'required'=>'required', 'cols'=>12]) !!}
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="parent_id"> {{ trans('main.Parent Category') }}
                                </label>
                                <select name="parent_id" id="parent_id" class=" form-control">
                                    <option value="">{{ trans('main.No Parent') }}</option>
                                    <?php
                                        $traverse = '';
                                        $traverse = function ($categories, $prefix = '') use (&$traverse, $category) {
                                            foreach ($categories as $category_item) {
                                    ?>
                                                @if($category_item->id != $category_item->id)<option @if($category_item->id == old('parent_id') || $category_item->id == $category->parent_id ) selected @endif value="{{$category_item-> id }}">{{ PHP_EOL.$prefix.' '.$category_item->category_name }}</option>@endif
                                    <?php
                                                $traverse($category_item->children, $prefix.'-');
                                            }
                                        };

                                        $traverse($nodes);

                                    ?>
                                </select>
                                @error('parent_id')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="row">
                            {!! checkbox(['errors'=>$errors, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>6, 'class'=>'switcher']) !!}
                        </div>

                        <hr>
                        {!! buttonAction() !!}
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('main.The Categories') }}</h4>
                    <h6 class="card-subtitle">{{ trans('main.Show All') }}</h6>
                    <form id='delete-formMulti' class='delete-formMulti'
                        method='post'
                        action='{{ route('categories.delete') }}'>
                        @csrf
                        <input type='hidden' name='_method' value='post'>

                        <p></p>
                        <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                            <thead>
                                <tr>
                                <th scope="col">{!! Form::checkbox('allCategories', 1, false, ['class'=>'allCategories', 'id'=>'allCategories']) !!} {{ trans('main.Category Name') }}</th>
                                <th scope="col">{{ trans('main.Slug') }}</th>
                                <th scope="col">{{ trans('main.is_active') }}</th>
                                <th scope="col">{{ trans('main.Created_at') }}</th>
                                <th>{{ trans('main.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $traverse = '';
                                    $traverse = function ($categories, $prefix = '') use (&$traverse, $category) {
                                        foreach ($categories as $category_item) {
                                ?>
                                            <tr>
                                                <th scope="col">
                                                    {!! Form::checkbox('categories[]', $category_item->id, false, ['class'=>'categories']) !!}
                                                    <a href="{{ route('categories.edit', $category_item->id) }}">{{ PHP_EOL.$prefix.' '.$category_item->category_name }}</a>
                                                </th>
                                                <td>{{ $category_item->slug }}</td>
                                                <td>{{ $category_item->getActive() }}</td>
                                                <td>{{ $category_item->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{route('categories.edit',$category_item->id)}}"
                                                        class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">{{ trans('main.Edit') }}</a>

                                                        <a href="{{route('categories.destroy',$category_item->id)}}" onclick="
                                                        var result = confirm('Do you want to delete:  {{ $category_item->category_name }}, @if($category_item->hasChildren()) It will be deleted with all its sub catecgries!!!@endif');
                                                        if(!result) {
                                                            event.preventDefault();
                                                        }"

                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{ trans('main.Delete') }}</a>


                                                    <!--#delete-form .delete-form -->
                                                </td>
                                            </tr>
                                <?php
                                            $traverse($category_item->children, $prefix.'-');
                                        }
                                    };

                                    $traverse($nodes);

                                ?>
                            </tbody>
                        </table>

                    </form>
                    <a href="" onclick="
                    var result = confirm('Do you want to delete, It will be deleted with all its sub catecgries!!!');
                    if(result) {
                        event.preventDefault();
                        document.getElementById('delete-formMulti').submit();
                    }else{
                        event.preventDefault();
                    }"

                    class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{ trans('main.Delete') }}</a>

                    <hr>
                    <h4 class="form-section"><i class="ft-home"></i> {{ trans('main.Trash') }} </h4>
                    <form id='delete-formMultiTrashed' class='delete-formMultiTrashed'
                        method='post'
                        action='{{ route('categories.p_delete') }}'>
                        @csrf
                        <input type='hidden' name='_method' value='post'>
                        <input type='hidden' name='_method' value='post'>

                        <p></p>
                        <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                            <thead>
                                <tr>
                                <th scope="col">{!! Form::checkbox('allCategoriesTrashed', 1, false, ['class'=>'allCategoriesTrashed', 'id'=>'allCategoriesTrashed']) !!} {{ trans('main.Category Name') }}</th>
                                <th scope="col">{{ trans('main.Slug') }}</th>
                                <th scope="col">{{ trans('main.is_active') }}</th>
                                <th scope="col">{{ trans('main.Created_at') }}</th>
                                <th>{{ trans('main.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    $traverse = function ($categories, $prefix = '') use (&$traverse) {
                                        foreach ($categories as $category) {
                                ?>
                                            <tr>
                                                <th scope="col"><a href="{{ route('categories.edit', $category->id) }}"></a>
                                                    {!! Form::checkbox('categoriesTrashed[]', $category->id, false, ['class'=>'categoriesTrashed']) !!} {{ PHP_EOL.$prefix.' '.$category->category_name }}
                                                </th>
                                                <td>{{ $category->slug }}</td>
                                                <td>{{ $category->getActive() }}</td>
                                                <td>{{ $category->created_at->diffForHumans() }}</td>

                                                <td>
                                                    <a href="{{route('categories.restore',$category->id)}}"
                                                        class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">{{ trans('main.Rrestore') }}</a>

                                                        <a href="{{route('categories.p_destroy',$category->id)}}" onclick="
                                                        var result = confirm('Do you want to Premently delete:  {{ $category->category_name }}, @if($category->hasChildren()) It will be deleted with all its sub catecgries!!!@endif');
                                                        if(!result) {
                                                            event.preventDefault();
                                                        }"

                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{ trans('main.Permanently Delete') }}</a>


                                                    <!--#delete-form .delete-form -->
                                                </td>
                                            </tr>
                                <?php
                                            $traverse($category->children, $prefix.'-');
                                        }
                                    };

                                    $traverse($nodesTrashed);

                                ?>
                            </tbody>
                        </table>

                    </form>
                    <a href="" onclick="
                    var result = confirm('Do you want to delete, It will be deleted with all its sub catecgries!!!');
                    if(result) {
                        event.preventDefault();
                        document.getElementById('delete-formMultiTrashed').submit();
                    }else{
                        event.preventDefault();
                    }"

                    class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{ trans('main.Permanently Delete') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $(document).on("change", '#allCategories', function(event) {
                if($(this).is(':checked')){
                    $('.categories').prop('checked', true)
                }else{
                    $('.categories').prop('checked', false)
                }
            });


        })
    </script>
@endsection

