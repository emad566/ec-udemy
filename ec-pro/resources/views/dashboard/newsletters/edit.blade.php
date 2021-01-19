@extends('dashboard.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4><i class="ft-home"></i> أضف كبون جديد</h4>
        </div>
        <div class="card-body">
            @include('dashboard.includes.alerts.success')
            @include('dashboard.includes.alerts.errors')
            <form class="form" action="{{route('newsletters.update', $newsletter->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='_method' value='PUT'>
                <input type="hidden" name="id" value="{{ $newsletter->id }}">
                <div class="row">
                    {!! input(['errors'=>$errors, 'type'=>'email', 'edit'=>$newsletter, 'name'=>'email', 'trans'=>'email', 'maxlength'=>20, 'required'=>'required', 'cols'=>6]) !!}
                    {!! checkbox(['errors'=>$errors, 'edit'=>$newsletter, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
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

