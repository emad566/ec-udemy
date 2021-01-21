<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use DB;
use Auth;
// use Kalnoy\Nestedset\Node;

class categoriesController extends Controller
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
        $categories = Category::all();
        $nodes = $categories->toTree();
        $categoriesTrashed = Category::onlyTrashed()->get();
        $nodesTrashed = $categoriesTrashed->toTree();

        return view('dashboard.categories.index', compact(['categories', 'nodes', 'categoriesTrashed', 'nodesTrashed']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('categories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // try{

            DB::beginTransaction();

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $node = new Category($request->except('_token'));
            $node->category_name = $request->category_name;
            $node->user_id = Auth::id();

            if (!$request->parent_id){
                $node->save();
            }else{
                $parent = Category::find($request->parent_id);

                if(!$parent)
                    return back()->withInput($request->all())->with(['error' => 'Error: No Parent with ID '. $request->parent_id]);

                $parent->appendNode($node);
            }

            $notification = array(
                'message' => 'Brand has added sucessfully',
                'alert-type' => 'success',
                'success' => 'ٍSave Success'
            );

            DB::commit();
            return redirect()->route('categories.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $categories = Category::all();
        $nodes = $categories->toTree();
        $categoriesTrashed = Category::onlyTrashed()->get();
        $nodesTrashed = $categoriesTrashed->toTree();

        return view('dashboard.categories.edit', compact(['categories', 'nodes', 'categoriesTrashed', 'nodesTrashed', 'category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        $nodes = $categories->toTree();
        $categoriesTrashed = Category::onlyTrashed()->get();
        $nodesTrashed = $categoriesTrashed->toTree();

        return view('dashboard.categories.edit', compact(['categories', 'nodes', 'categoriesTrashed', 'nodesTrashed', 'category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // try{

            DB::beginTransaction();
            $node = $category;
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $parent = Category::find($request->parent_id);
            if(!$parent && $request->parent_id)
                    return back()->withInput($request->all())->with(['error' => 'Error: No Parent with ID '. $request->parent_id]);

            $node->update($request->except('_token'));
            if($node->id != $request->parent_id){
                $node->parent_id = $request->parent_id;
                $node->category_name = $request->category_name;
                $node->save();
                $node::fixTree();
            }


            $notification = array(
                'message' => 'Brand has Eddet sucessfully',
                'alert-type' => 'success',
                'success' => 'ٍSave Success'
            );

            DB::commit();

            return redirect()->route('categories.edit', $node->id)->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category_id)
    {
        // try {
            $category = Category::find($category_id);
            if (!$category)
                return back()->withInput($request->all())->with(['error' => 'Error: No Category with this ID ']);

            $category->delete();
            $notification = array(
                'message' => 'Brand has Eddet sucessfully',
                'alert-type' => 'success',
                'success' => 'ٍDelete Success'
            );
            return redirect()->route('categories.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function delete(Request $request)
    {
        // try {
            $category_ids = $request->categories;
            if($category_ids){
                foreach($category_ids as $category_id){
                    $category = Category::find($category_id);
                    if($category)
                        $category->delete();
                }
            }

            return redirect()->route('categories.index')->with(['success' => 'Delete Success']);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function p_destroy($category_id)
    {
        // try {
            $category = Category::onlyTrashed()->find($category_id);
            if($category)
                $category->forceDelete();

            return redirect()->route('categories.index')->with(['success' => 'P Delete Success']);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function p_delete(Request $request)
    {
        // try {
            $category_ids = $request->categoriesTrashed;
            if($category_ids){
                foreach($category_ids as $category_id){
                    $category = Category::onlyTrashed()->find($category_id);
                    if($category)
                        $category->forceDelete();
                }
            }

            return redirect()->route('categories.index')->with(['success' => 'M P Delete Success']);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function restore($category_id)
    {
        // try {
            $category = Category::withTrashed()->find($category_id);
            if($category)
                $category->restore();

            return redirect()->route('categories.index')->with(['success' => 'Restore Success']);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }
}
