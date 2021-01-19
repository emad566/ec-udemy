<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use DB;
use Auth;
class newslettersController extends Controller
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
        $newsletters = Newsletter::all();
        return view('dashboard.newsletters.index', compact(['newsletters']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.newsletters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsletterRequest $request)
    {
        // try{
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['user_id'] = Auth::id();

            $newsletter = Newsletter::create($inputs);
            DB::commit();
            $notification = array(
                'message' => trans('main.SavedSuccessfully'),
                'alert-type' => 'success',
                'success' => trans('main.SavedSuccessfully'),
            );
            return redirect()->route('newsletters.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        return view('dashboard.newsletters.edit', compact(['newsletter']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(NewsletterRequest $request, Newsletter $newsletter)
    {
        // try{
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;

            $newsletter->update($inputs);
            DB::commit();

            $notification = array(
                'message' => trans('main.UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.UpdateSuccess'),
            );

            return redirect()->route('newsletters.index')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('update')]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy($newsletter_id)
    {
        // try {
            DB::beginTransaction();

            $newsletter = Newsletter::find($newsletter_id);
            if (!$newsletter)
                return back()->with(['error' => 'Error: No Newsletter with this ID ']);

            // $newsletter->delete();
            DB::commit();
            $notification = array(
                'message' => trans('main.DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.DeleteSuccess'),
            );

            return redirect()->route('newsletters.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('destroy')]);
        // }
    }

    public function delete(Request $request)
    {
        // try {
            DB::beginTransaction();

            $newsletter_ids = $request->newsletters;
            if($newsletter_ids){
                foreach($newsletter_ids as $newsletter_id){
                    $newsletter = Newsletter::find($newsletter_id);
                    if($newsletter)
                        $newsletter->delete();
                }
            }
            DB::commit();

            $notification = array(
                'message' => trans('main.DeleteSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.DeleteSuccess'),
            );
            return redirect()->route('newsletters.index')->with($notification);

        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('delete')]);
        // }
    }

    public function updateIsActive(Request $request, Newsletter $newsletter)
    {
        try {
            DB::beginTransaction();
            if($newsletter){
                $is_active = ($newsletter->is_active)? 0 : 1;
            }
            $newsletter->update(['is_active'=>$is_active]);
            DB::commit();
            $notification = array(
                'message' => trans('main.UpdateSuccess'),
                'alert-type' => 'success',
                'success' => trans('main.UpdateSuccess'),
            );
            return redirect()->route('newsletters.index')->with($notification);

        } catch (\Exception $ex) {
            return redirect()->route('newsletters.index')->with(['error' => $this->getFileNameError('updateIsActive')]);
        }
    }

    public function subscribe(NewsletterRequest $request)
    {
        // try{
            DB::beginTransaction();
            $inputs = $request->except('_token');
            $inputs['is_active'] = (!$request->has('is_active')) ? 0 : 1;
            $inputs['user_id'] = Auth::id();

            $newsletter = Newsletter::create($inputs);
            DB::commit();
            $notification = array(
                'message' => trans('main.SavedSuccessfully'),
                'alert-type' => 'success',
                'success' => trans('main.SavedSuccessfully'),
            );
            return redirect()->route('site.home')->with($notification);


        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return back()->withInput($request->all())->with(['error' => $this->getFileNameError('store')]);
        // }
    }
}
