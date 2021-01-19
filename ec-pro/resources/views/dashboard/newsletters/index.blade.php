@extends('dashboard.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <div class="card">
                <div class="card-header">
                    <h4><i class="ft-home"></i>{{ trans('main.Thenewsletters') }}</h4>
                    <a href="{{ route('newsletters.create') }}" class="btn btn-primary float-right">{{ trans('main.AddNew') }}</a>
                </div>
                <div class="card-body">
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')

                    <form id='delete-formMulti' class='delete-formMulti'
                        method='post'
                        action='{{ route('newsletters.delete') }}'>
                        @csrf
                        <input type='hidden' name='_method' value='post'>

                        @php
                            $fields = [
                                ['email', false, 'email'],
                                ];
                        @endphp

                        {!! indexTable([
                            'objs'=>$newsletters,
                            'table'=>'newsletters',
                            'title'=>'email',
                            'trans'=>'email',
                            'active'=>true,
                            'indexEdit'=>true,
                            'indexDel'=>true,
                            'isread'=>false,
                            'view'=>false,
                            'vars'=>false,
                            'fields'=>$fields
                        ]) !!}

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        
    </script>
@endsection

