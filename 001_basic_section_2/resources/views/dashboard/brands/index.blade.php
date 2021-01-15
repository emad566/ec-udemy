<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Brands .. <b> </b>
            <b style="float: right">Total Brands
                <span class="badge badge-danger">{{ count($brands) }}</span>
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <h4 class="form-section"><i class="ft-home"></i> Add New brand</h4>
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')
                    <form class="form" action="{{route('brands.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="brand_name"> brand Name
                                </label>
                                <input type="text" id="brand_name"
                                        class="form-control"
                                        placeholder="brand Name"
                                        value="{{old('brand_name')}}"
                                        name="brand_name">
                                @error("brand_name")
                                <span class="text-danger">{{$message}}</span>
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
                                <i class="la la-check-square-o"></i> Add New brand
                            </button>
                        </div>
                    </form>
                    <p></p>
                </div>

                <div class="col-lg-8 col-xs-12 table-responsive">
                    <form id='delete-formMulti' class='delete-formMulti'
                        method='post'
                        action='{{ route('brands.delete') }}'>
                        @csrf
                        <input type='hidden' name='_method' value='post'>

                        <p></p>
                        <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                            <thead>
                                <tr>
                                <th scope="col">{!! Form::checkbox('allbrands', 1, false, ['class'=>'allbrands', 'id'=>'allbrands']) !!} Name</th>
                                <th scope="col">is Active</th>
                                <th scope="col">Created_at</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                <tr>
                                    <th scope="col"><a href="{{ route('brands.edit', $brand->id) }}">
                                        {!! Form::checkbox('brands[]', $brand->id, false, ['class'=>'brands']) !!} {{ $brand->brand_name }}
                                    </a></th>
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
                    var result = confirm('Do you want to delete');
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
</x-app-layout>

