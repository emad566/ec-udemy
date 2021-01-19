@extends('dashboard.master')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('main.Profile') }}
            <a href="{{ route('mainUser.changePass') }}" class="btn btn-primary float-right">{{ trans('main.resetpass') }}</a>
        </div>
        <div class="card-body">
            @include('dashboard.includes.alerts.success')
            @include('dashboard.includes.alerts.errors')
            <form class="form" action="{{route('mainUser.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='_method' value='PUT'>

                <div class="row">
                    {!! img(['errors'=>$errors, 'name'=>'image', 'edit'=>$user, 'trans'=>'userimg', 'cols'=>12]) !!}
                </div>
                <div class="row">
                    {!! input(['errors'=>$errors, 'edit'=>$user, 'name'=>'name', 'trans'=>'Name', 'maxlength'=>191, 'required'=>'required', 'cols'=>6]) !!}
                    {!! input(['errors'=>$errors, 'edit'=>$user, 'type'=>'email','name'=>'email', 'maxlength'=>10, 'trans'=>'email', 'cols'=>6 ]) !!}
                </div>
                <div class="row">
                    {!! input(['errors'=>$errors, 'edit'=>$user, 'name'=>'fName', 'trans'=>'fName', 'maxlength'=>191, 'required'=>'', 'cols'=>6]) !!}
                    {!! input(['errors'=>$errors, 'edit'=>$user, 'name'=>'lName', 'trans'=>'lName', 'maxlength'=>191, 'required'=>'', 'cols'=>6]) !!}
                </div>
                <div class="row">
                    {!! checkbox(['errors'=>$errors, 'edit'=>$user, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12]) !!}
                </div>
                <div class="row">
                    {!! buttonAction() !!}
                </div>
            </form>
        </div>
    </div>
@endsection
