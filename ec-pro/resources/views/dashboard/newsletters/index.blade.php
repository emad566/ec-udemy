@extends('dashboard.master')

@section('content')
    <div class="row">
            <div class="card w-100">
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
                                ['email', 'email'],
                                ];
                        @endphp
                        <div class="table-responsive">
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
                        </div>
                    </form>

                </div>
            </div>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection

