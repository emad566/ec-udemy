@extends('dashboard.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="form-section"><i class="ft-home"></i> {{ trans('main.resetpass') }} </h4>
        </div>
        <div class="card-body">
            @include('dashboard.includes.alerts.success')
            @include('dashboard.includes.alerts.errors')
            <form class="form" action="{{route('mainUser.updatePass')}}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <input type='hidden' name='_method' value='PUT'>

                <div class="form-body">

                    <div class="row">
                        {!! input(['errors'=>$errors, 'name'=>'oldpassword', 'type'=>'password', 'trans'=>'oldpassword', 'attr'=>'maxlength="20"   minlength="1"', 'required'=>'required', 'cols'=>12 ]) !!}
                    </div>

                    <div class="row">
                        {!! input(['errors'=>$errors, 'name'=>'password', 'type'=>'password', 'trans'=>'newpassword', 'attr'=>'maxlength="20" minlength="6"', 'required'=>'required', 'cols'=>6 ]) !!}

                        {!! input(['errors'=>$errors, 'name'=>'password_confirmation', 'type'=>'password', 'trans'=>'password_confirmation', 'attr'=>'maxlength="20" minlength="6"', 'required'=>'required', 'cols'=>6 ]) !!}
                    </div>



                </div>
                {!! buttonAction() !!}
            </form>
        </div>
    </div>
@endsection
