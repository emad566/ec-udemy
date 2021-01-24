<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use DB;
use Auth;
class postsController extends Controller
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
        $posts = Post::all();
        return view('dashboard.posts.index', compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.posts.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // try{

            DB::beginTransaction();

            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['user_id'] = Auth::id();

            $post = new Post($inputs);
            $post->post_title = $request->post_title;
            $post->post_details = $request->post_details;
            $post->post_tags = $request->post_tags;


            if($image  = $request->file('image')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Post::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Post::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Post::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Post::files_path().image_name($image, $image_name, '800-500'));
                $post->image = $image_name;
            }
            $post->save();

            DB::commit();
            $notification = array(
                'message' => trans('main.SavedSuccessfully'),
                'alert-type' => 'success',
                'success' => trans('main.SavedSuccessfully'),
            );
            return redirect()->route('posts.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $categories = Category::all();
        return view('dashboard.posts.show', compact(['post','categories']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('dashboard.posts.edit', compact(['post','categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        // try{
            DB::beginTransaction();

            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;


            if($image  = $request->file('image')){
                $image_name = image_name($image);
                Image::make($image)->resize(300,200)->save(Post::files_path().$image_name);
                Image::make($image)->resize(300,200)->save(Post::files_path().image_name($image, $image_name, '300-200'));
                Image::make($image)->resize(600,400)->save(Post::files_path().image_name($image, $image_name, '600-400'));
                Image::make($image)->resize(800,500)->save(Post::files_path().image_name($image, $image_name, '800-500'));
                $msg = $post->image_delete('image');
                $inputs['image'] = $image_name;
                $image = '';
            }

            $post->update($inputs);
            $post->post_title = $request->post_title;
            $post->post_details = $request->post_details;
            $post->post_tags = $request->post_tags;
            $post->save();
            DB::commit();

            $notification = array(
                'message' => trans('main.UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.UpdateSuccess'),
            );

            return redirect()->route('posts.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('update')]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id)
    {
        // try {
            DB::beginTransaction();

            $post = Post::find($post_id);
            if (!$post)
                return back()->with(['error' => 'Error: No Post with this ID ']);

            $post->image_delete();
            $post->delete();
            DB::commit();
            $notification = array(
                'message' => trans('main.DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.DeleteSuccess'),
            );

            return redirect()->route('posts.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function delete(Request $request)
    {
        // try {


            DB::beginTransaction();

            $post_ids = $request->posts;
            if($post_ids){
                foreach($post_ids as $post_id){
                    $post = Post::find($post_id);
                    if($post){
                        $post->image_delete();
                        $post->delete();
                    }
                }
            }
            DB::commit();

            $notification = array(
                'message' => trans('main.DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.DeleteSuccess'),
            );
            return redirect()->route('posts.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('delete')]);
        // }
    }

    public function updateIsActive(Request $request, Post $post)
    {
        try {
            DB::beginTransaction();
            if($post){
                $is_active = ($post->is_active)? 0 : 1;
            }
            $post->update(['is_active'=>$is_active]);
            DB::commit();
            $notification = array(
                'message' => trans('main.UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.UpdateSuccess'),
            );
            return redirect()->route('posts.index')->with($notification);

        } catch (\Exception $ex) {
            return redirect()->route('posts.index')->with(['error' => $this->getFileNameError('updateIsActive')]);
        }
    }
}
