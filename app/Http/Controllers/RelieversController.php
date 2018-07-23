<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Reliever;

class RelieversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('relievers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * get Relivers in json
     */
    public function getRelievers()
    {
        if(Auth::user()->isAdmin()) {
            
            $relievers = Reliever::orderBy('id','DESC')->get();
            
            return $relievers;

        } else {

            $relievers = Reliever::where('company_id',Auth::user()->company_id)
                            ->orderBy('id','desc')
                            ->get();

            return $relievers;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'from_worker',
            'to_worker',
            'from_date',
            'to_date',
        ]);

        // $reliever = Reliever::create([
        //     'user_id' => $request->input('user_id'),
        //     'reasons' => $request->input('reasons'),
        //     'from_date' => $request->input('from_date'),
        //     'to_date' => $request->input('to_date'),
        //     'from_worker' => $request->input('from_worker'),
        //     'to_worker' => $request->input('to_worker'),
        //     'status' => $request->input('status'),
        // ]);

        $reliever = new Reliever;
        $reliever->user_id = $request->input('user_id');
        $reliever->reasons =  $request->input('reasons');
        $reliever->from_date =  Carbon::parse($request->input('from_date'));
        $reliever->to_date =  Carbon::parse($request->input('to_date'));
        $reliever->from_worker =  $request->input('from_worker');
        $reliever->to_worker =  $request->input('to_worker');
        $reliever->status = $request->input('status');
        $reliever->company()->associate($request->input('company_list'));
        $reliever->save();


        return ['redirect' => route('relievers.index')];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
