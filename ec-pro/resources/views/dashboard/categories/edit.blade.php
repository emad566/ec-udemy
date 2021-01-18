@extends('dashboard.master')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <i class="ft-home"></i> Edit Category: {{ $category->category_name }}</h4>
                </div>
                <div class="card-body">
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                <form class="form" action="{{route('categories.update', $category->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type='hidden' name='_method' value='PUT'>


                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="category_name"> Category Name
                            </label>
                            <input type="text" id="category_name"
                                    class="form-control"
                                    placeholder="Category Name"
                                    value="@if(old('category_name')){{old('category_name')}}@else{{ $category->category_name }}@endif"
                                    name="category_name">
                            @error("category_name")
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="slug"> Slug
                            </label>
                            <input type="text" id="slug"
                                    class="form-control"
                                    placeholder="slug"
                                    value="@if(old('slug')){{old('slug')}}@else{{ $category->slug }}@endif"
                                    name="slug">
                            @error("slug")
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="description"> Cetegory Description
                            </label>
                            <textarea type="text" id="description"
                                    class="form-control"
                                    placeholder="Cetegory Description"
                                    name="description">@if(old('description')){{old('description')}}@else{{ $category->description }}@endif</textarea>
                            @error("description")
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="parent_id"> Parent Category
                            </label>
                            <select name="parent_id" id="parent_id" class="select2 form-control">
                                <option value="">None</option>
                                <?php
                                    $traverse = '';
                                    $traverse = function ($categories, $prefix = '') use (&$traverse, $category) {
                                        foreach ($categories as $category_item) {
                                ?>
                                            <option @if($category_item->id == old('parent_id') || $category_item->id == $category->parent_id ) selected @endif value="{{$category_item-> id }}">{{ PHP_EOL.$prefix.' '.$category_item->category_name }}</option>
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
                        <div class="col-md-6">
                            <div class="form-group mt-1">
                                <input type="checkbox" value="1"
                                        name="is_active"
                                        id="switcheryColor4"
                                        class="switchery" data-color="success"
                                        @if($category->is_active || old('is_active')) checked @endif
                                        />
                                <label for="switcheryColor4"
                                        class="card-title ml-1">Active </label>

                                @error("is_active")
                                <span class="text-danger">{{$message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-actions">

                        <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> Update
                        </button>
                    </div>
                </form>
                <p></p>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xs-12 table-responsive">
        <div class="card">
            <div class="card-header">
                <i class="ft-home"></i> The Categories</h4>
            </div>
            <div class="card-body">
                <form id='delete-formMulti' class='delete-formMulti'
                    method='post'
                    action='{{ route('categories.delete') }}'>
                    @csrf
                    <input type='hidden' name='_method' value='post'>

                    <a href="{{route('categories.index')}}"
                        class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">Add new Category</a>

                    <p></p>
                    <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                        <thead>
                            <tr>
                            <th scope="col">{!! Form::checkbox('allCategories', 1, false, ['class'=>'allCategories', 'id'=>'allCategories']) !!} Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">is Active</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $traverse = '';
                                $traverse = function ($categories, $prefix = '') use (&$traverse, $category) {
                                    foreach ($categories as $category_item) {
                            ?>
                                        <tr>
                                            <th scope="col"><a href="{{ route('categories.edit', $category_item->id) }}">
                                                {!! Form::checkbox('categories[]', $category_item->id, false, ['class'=>'categories']) !!} {{ PHP_EOL.$prefix.' '.$category_item->category_name }}
                                            </a></th>
                                            <td>{{ $category_item->slug }}</td>
                                            <td>{{ $category_item->getActive() }}</td>
                                            <td>{{ $category_item->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{route('categories.edit',$category_item->id)}}"
                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">Edit</a>

                                                    <a href="{{route('categories.destroy',$category_item->id)}}" onclick="
                                                    var result = confirm('Do you want to delete:  {{ $category_item->category_name }}, @if($category_item->hasChildren()) It will be deleted with all its sub catecgries!!!@endif');
                                                    if(!result) {
                                                        event.preventDefault();
                                                    }"

                                                    class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">Delete</a>


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

                class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">Delete</a>

                <h4 class="form-section"><i class="ft-home"></i> Trashed Category</h4>
                <form id='delete-formMultiTrashed' class='delete-formMultiTrashed'
                    method='post'
                    action='{{ route('categories.p_delete') }}'>
                    @csrf
                    <input type='hidden' name='_method' value='post'>

                    <p></p>
                    <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                        <thead>
                            <tr>
                            <th scope="col">{!! Form::checkbox('allCategoriesTrashed', 1, false, ['class'=>'allCategoriesTrashed', 'id'=>'allCategoriesTrashed']) !!} Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">is Active</th>
                            <th scope="col">Created_at</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                $traverse = function ($categories, $prefix = '') use (&$traverse) {
                                    foreach ($categories as $category) {
                            ?>
                                        <tr>
                                            <th scope="col"><a href="{{ route('categories.edit', $category->id) }}">
                                                {!! Form::checkbox('categoriesTrashed[]', $category->id, false, ['class'=>'categoriesTrashed']) !!} {{ PHP_EOL.$prefix.' '.$category->category_name }}
                                            </a></th>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->getActive() }}</td>
                                            <td>{{ $category->created_at->diffForHumans() }}</td>

                                            <td>
                                                <a href="{{route('categories.restore',$category->id)}}"
                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">Restore</a>

                                                    <a href="{{route('categories.p_destroy',$category->id)}}" onclick="
                                                    var result = confirm('Do you want to Premently delete:  {{ $category->category_name }}, @if($category->hasChildren()) It will be deleted with all its sub catecgries!!!@endif');
                                                    if(!result) {
                                                        event.preventDefault();
                                                    }"

                                                    class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">P Delete</a>


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
                    $('.categories').attr('checked', true)
                }else{
                    $('.categories').attr('checked', false)
                }
            });


        })
    </script>
@endsection

