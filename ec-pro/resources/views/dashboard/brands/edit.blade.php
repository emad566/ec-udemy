@extends('dashboard.master')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <i class="ft-home"></i> Edit Brand: {{ $brand->brand_name }}</h4>
                </div>
                <div class="card-body">
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                    <form class="form" action="{{route('brands.update', $brand->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type='hidden' name='_method' value='PUT'>


                        <input type="hidden" name="id" value="{{ $brand->id }}">
                        @if($brand->image) <img width="50" height="50" src="{{ $brand->image }}" alt="{{ $brand->brand_name }}">@endif
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="brand_name"> brand Name
                                </label>
                                <input type="text" id="brand_name"
                                        class="form-control"
                                        placeholder="brand Name"
                                        value="@if(old('brand_name')){{old('brand_name')}}@else{{ $brand->brand_name }}@endif"
                                        name="brand_name">
                                @error("brand_name")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group mb-1">

                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Choose file</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input image" id="image" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Upload Image</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-1">
                                    <input type="checkbox" value="1"
                                            name="is_active"
                                            id="switcheryColor4"
                                            class="switchery" data-color="success"
                                            @if($brand->is_active || old('is_active')) checked @endif
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
                    <i class="ft-home"></i> The Brands</h4>
                </div>
                <div class="card-body">
                    <form id='delete-formMulti' class='delete-formMulti'
                        method='post'
                        action='{{ route('brands.delete') }}'>
                        @csrf
                        <input type='hidden' name='_method' value='post'>

                        <a href="{{route('brands.index')}}"
                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">Add new brand</a>

                        <p></p>
                    <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                        <thead>
                            <tr>
                            <th scope="col">{!! Form::checkbox('allbrands', 1, false, ['class'=>'allbrands', 'id'=>'allbrands']) !!} Name</th>
                            <th>Image</th>
                            <th scope="col">is Active</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                            <tr>
                                <th scope="col"><a href="{{ route('brands.edit', $brand->id) }}">
                                    {!! Form::checkbox('brands[]', $brand->id, false, ['class'=>'brands']) !!} {{ $brand->brand_name }}
                                </a></th>
                                <td>@if($brand->image) <img width="50" height="50" src="{{ $brand->image }}" alt="{{ $brand->brand_name }}">@endif</td>
                                <td>{{ $brand->getActive() }}</td>
                                <td>{{ $brand->created_at->diffForHumans() }}</td>

                                <td>
                                    <a href="{{route('brands.edit',$brand->id)}}"
                                        class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">Edit</a>

                                        <a href="{{route('brands.destroy',$brand->id)}}" onclick="
                                        var result = confirm('Do you want to delete:  {{ $brand->brand_name }}');
                                        if(!result) {
                                            event.preventDefault();
                                        }"

                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">Delete</a>


                                    <!--#delete-form .delete-form -->
                                </td>
                            </tr>
                            @endforeach
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

