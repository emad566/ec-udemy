<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use DB;
use Auth;
class productsController extends Controller
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
        $products = Product::all();
        return view('dashboard.products.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('dashboard.products.create', compact(['brands','categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // try{

            DB::beginTransaction();

            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['main_slider'] = (!$request->has('main_slider')) ? 0 : 1;
            $inputs['hot_deal'] = (!$request->has('hot_deal')) ? 0 : 1;
            $inputs['best_rated'] = (!$request->has('best_rated')) ? 0 : 1;
            $inputs['mid_slider'] = (!$request->has('mid_slider')) ? 0 : 1;
            $inputs['hot_new'] = (!$request->has('hot_new')) ? 0 : 1;
            $inputs['buyone_getone'] = (!$request->has('buyone_getone')) ? 0 : 1;
            $inputs['trend'] = (!$request->has('trend')) ? 0 : 1;

            $inputs['user_id'] = Auth::id();

            $product = new Product($inputs);
            $product->product_name = $request->product_name;
            $product->product_details = $request->product_details;


            if($image  = $request->file('image_one')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Product::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Product::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Product::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Product::files_path().image_name($image, $image_name, '800-500'));
                $product->image_one = $image_name;
                $image = '';
            }

            if($image  = $request->file('image_two')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Product::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Product::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Product::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Product::files_path().image_name($image, $image_name, '800-500'));
                $product->image_two = $image_name;
                $image = '';
            }

            if($image  = $request->file('image_three')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Product::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Product::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Product::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Product::files_path().image_name($image, $image_name, '800-500'));
                $product->image_three = $image_name;
                $image = '';
            }
            $product->save();

            DB::commit();
            $notification = array(
                'message' => trans('main.SavedSuccessfully'),
                'alert-type' => 'success',
                'success' => trans('main.SavedSuccessfully'),
            );
            return redirect()->route('products.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('dashboard.products.show', compact(['brands', 'product','categories']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('dashboard.products.edit', compact(['brands', 'product','categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        // try{
            DB::beginTransaction();

            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['main_slider'] = (!$request->has('main_slider')) ? 0 : 1;
            $inputs['hot_deal'] = (!$request->has('hot_deal')) ? 0 : 1;
            $inputs['best_rated'] = (!$request->has('best_rated')) ? 0 : 1;
            $inputs['mid_slider'] = (!$request->has('mid_slider')) ? 0 : 1;
            $inputs['hot_new'] = (!$request->has('hot_new')) ? 0 : 1;
            $inputs['buyone_getone'] = (!$request->has('buyone_getone')) ? 0 : 1;
            $inputs['trend'] = (!$request->has('trend')) ? 0 : 1;


            if($image  = $request->file('image_one')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Product::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Product::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Product::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Product::files_path().image_name($image, $image_name, '800-500'));
                $msg = $product->image_delete('image_one');
                $inputs['image_one'] = $image_name;
                $image = '';
            }

            if($image  = $request->file('image_two')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Product::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Product::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Product::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Product::files_path().image_name($image, $image_name, '800-500'));
                $product->image_delete('image_two');
                $inputs['image_two'] = $image_name;
                $image = '';
            }

            if($image  = $request->file('image_three')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Product::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Product::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Product::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Product::files_path().image_name($image, $image_name, '800-500'));
                $product->image_delete('image_three');
                $inputs['image_three'] = $image_name;
                $image = '';
            }

            $product->update($inputs);
            $product->product_name = $request->product_name;
            $product->product_details = $request->product_details;
            $product->save();
            DB::commit();

            $notification = array(
                'message' => trans('main.UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.UpdateSuccess'),
            );

            return redirect()->route('products.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('update')]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        // try {
            DB::beginTransaction();

            $product = Product::find($product_id);
            if (!$product)
                return back()->with(['error' => 'Error: No Product with this ID ']);

            $product->image_delete();
            $product->delete();
            DB::commit();
            $notification = array(
                'message' => trans('main.DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.DeleteSuccess'),
            );

            return redirect()->route('products.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function delete(Request $request)
    {
        // try {


            DB::beginTransaction();

            $product_ids = $request->products;
            if($product_ids){
                foreach($product_ids as $product_id){
                    $product = Product::find($product_id);
                    if($product){
                        $product->image_delete();
                        $product->delete();
                    }
                }
            }
            DB::commit();

            $notification = array(
                'message' => trans('main.DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.DeleteSuccess'),
            );
            return redirect()->route('products.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('delete')]);
        // }
    }

    public function updateIsActive(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
            if($product){
                $is_active = ($product->is_active)? 0 : 1;
            }
            $product->update(['is_active'=>$is_active]);
            DB::commit();
            $notification = array(
                'message' => trans('main.UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.UpdateSuccess'),
            );
            return redirect()->route('products.index')->with($notification);

        } catch (\Exception $ex) {
            return redirect()->route('products.index')->with(['error' => $this->getFileNameError('updateIsActive')]);
        }
    }
}
