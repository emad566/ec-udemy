<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use DB;
use Auth;
class couponsController extends Controller
{
    public function generalErrorMsg(){
        return trans('main.ThereIsAnErrorPlsTryAgainlater');
    }

    protected function getFileNameError($funcName, $msg=""){
        $msg = ($msg)? $msg : $this->generalErrorMsg();
        $fn =  basename(__FILE__, '.php');
        return  $msg . ": " . $fn . '@' .$funcName;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('dashboard.coupons.index', compact(['coupons']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        // try{
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['user_id'] = Auth::id();

            $coupon = Coupon::create($inputs);
            DB::commit();
            $notification = array(
                'message' => trans('SavedSuccessfully'),
                'alert-type' => 'success',
                'success' => trans('SavedSuccessfully'),
            );
            return redirect()->route('coupons.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupons.edit', compact(['coupon']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        // try{
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;

            $coupon->update($inputs);
            DB::commit();

            $notification = array(
                'message' => trans('UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('UpdateSuccess'),
            );

            return redirect()->route('coupons.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('update')]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($coupon_id)
    {
        // try {
            DB::beginTransaction();

            $coupon = Coupon::find($coupon_id);
            if (!$coupon)
                return back()->with(['error' => 'Error: No coupon with this ID ']);

            // $coupon->delete();
            DB::commit();
            $notification = array(
                'message' => trans('DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('DeleteSuccess'),
            );

            return redirect()->route('coupons.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function delete(Request $request)
    {
        // try {
            DB::beginTransaction();

            $coupon_ids = $request->coupons;
            if($coupon_ids){
                foreach($coupon_ids as $coupon_id){
                    $coupon = coupon::find($coupon_id);
                    if($coupon)
                        $coupon->delete();
                }
            }
            DB::commit();

            $notification = array(
                'message' => trans('DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('DeleteSuccess'),
            );
            return redirect()->route('coupons.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('delete')]);
        // }
    }

    public function updateIsActive(Request $request, Coupon $coupon)
    {
        try {
            DB::beginTransaction();
            if($coupon){
                $is_active = ($coupon->is_active)? 0 : 1;
            }
            $coupon->update(['is_active'=>$is_active]);
            DB::commit();
            $notification = array(
                'message' => trans('UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('UpdateSuccess'),
            );
            return redirect()->route('coupons.index')->with($notification);

        } catch (\Exception $ex) {
            return redirect()->route('coupons.index')->with(['error' => $this->getFileNameError('updateIsActive')]);
        }
    }
}
