@extends('dashboard.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <div class="card">
                <div class="card-header">
                    <h4><i class="ft-home"></i>{{ trans('main.Thecoupons') }}</h4>
                    <a href="{{ route('coupons.create') }}" class="btn btn-primary float-right">{{ trans('main.AddNew') }}</a>
                </div>
                <div class="card-body">
                    @include('dashboard.includes.alerts.success')
                    @include('dashboard.includes.alerts.errors')

                    <form id='delete-formMulti' class='delete-formMulti'
                        method='post'
                        action='{{ route('coupons.delete') }}'>
                        @csrf
                        <input type='hidden' name='_method' value='post'>

                        @php
                            $fields = [
                                ['code', false, 'CouponCode'],
                                ['discount', false, 'CouponDiscount'],
                                ];
                        @endphp

                        {!! indexTable([
                            'objs'=>$coupons,
                            'table'=>'coupons',
                            'title'=>'code',
                            'trans'=>'CouponCode',
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
        $(document).ready(function(){
            $(document).on("change", '#allItems', function(event) {
                if($(this).is(':checked')){
                    $('.boxItem').attr('checked', true)
                }else{
                    $('.boxItem').attr('checked', false)
                }
            });


        })
    </script>
@endsection

