<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use DB;
use Auth;
use PhpParser\Node\Stmt\Return_;
use Image;
// use Kalnoy\Nestedset\Node;

class brandsController extends Controller
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
        $brands = Brand::all();
        return view('dashboard.brands.index', compact(['brands']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('brands.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        // try{
            DB::beginTransaction();

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $brand = new Brand($request->except('_token'));
            $brand->brand_name = $request->brand_name;
            $brand->user_id = Auth::id();


            if($image  = $request->file('image')){
                $image_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(300,200)->save(Brand::files_path().$image_name);
                $brand->image = $image_name;
            }

            $brand->save();
            DB::commit();

            return redirect()->route('brands.index')->with(['success' => 'ٍSave Success']);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        $brands = Brand::all();
        return view('dashboard.brands.edit', compact(['brands']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $brands = Brand::all();
        return view('dashboard.brands.edit', compact(['brands', 'brand']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        // try{
            $inputs = $request->except(['_token', 'image']);

            DB::beginTransaction();
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['brand_name'] = $request->brand_name;


            if($image  = $request->file('image')){
                $inputs['image'] = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(300,200)->save(Brand::files_path().$inputs['image']);
                $brand->image_delete();
            }
            $brand->update($inputs);

            $brand->save();

            return redirect()->route('brands.edit', $brand->id)->with(['success' => 'ٍSave Success']);
            DB::commit();

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($brand_id)
    {
        // try {
            $brand = Brand::find($brand_id);
            if (!$brand)
                return back()->with(['error' => 'Error: No Brand with this ID ']);

            $brand->image_delete();
            $brand->delete();

            return redirect()->route('brands.index')->with(['success' => 'Delete Success']);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function delete(Request $request)
    {
        // try {
            $brand_ids = $request->brands;
            if($brand_ids){
                foreach($brand_ids as $brand_id){
                    $brand = Brand::find($brand_id);
                    if($brand)
                        $brand->delete();
                }
            }

            return redirect()->route('brands.index')->with(['success' => 'Delete Success']);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

}
