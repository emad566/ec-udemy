<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ trans('main.The Coupons') }}</h4>
                <h6 class="card-subtitle">{{ trans('main.Add New') }}</h6>
                <hr>
                @include('dashboard.includes.alerts.success')
                @include('dashboard.includes.alerts.errors')
                <form class="form" action="{{route('coupons.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {!! input(['errors'=>$errors, 'type'=>'text', 'name'=>'code', 'trans'=>'CouponCode', 'maxlength'=>20, 'required'=>'required', 'cols'=>6]) !!}
                        {!! input(['errors'=>$errors, 'type'=>'number', 'name'=>'discount', 'trans'=>'CouponDiscount', 'maxlength'=>20, 'required'=>'required', 'cols'=>6]) !!}
                    </div>

                    <div class="row">
                        {!! checkbox(['errors'=>$errors, 'name'=>'is_active', 'trans'=>'Active', 'cols'=>12, 'class'=>'switcher']) !!}
                    </div>
                    <hr>
                    <div class="row">
                        {!! buttonAction() !!}
                    </div>

                </form>
                <p></p>
            </div>
        </div>
    </div>
</div>
