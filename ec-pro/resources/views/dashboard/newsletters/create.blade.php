@extends('dashboard.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4><i class="ft-home"></i> أضف كبون جديد</h4>
        </div>
        <div class="card-body">
            @include('dashboard.includes.alerts.success')
            @include('dashboard.includes.alerts.errors')
            <form class="form" action="{{route('newsletters.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {!! input(['errors'=>$errors, 'type'=>'email', 'name'=>'email', 'trans'=>'email', 'maxlength'=>60, 'required'=>'required', 'cols'=>6]) !!}
                    {!! checkbox(['errors'=>$errors, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
                </div>
                <div class="row">
                    {!! buttonAction() !!}
                </div>

            </form>
            <p></p>
        </div>
    </div>
@endsection

@section('script')

@endsection

