<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Company;
use App\Reliever;
use App\Classification;
use App\Labor;

class LaborsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'position' => 'required',
            'gender' => 'required',
            'birthday' => 'required'
        ]);

        $labor = Auth::user()->labors()->create($request->all());
        $labor->associate()->company($request->input('company_list'));
        $labor->associate()->classification($request->input('classfication_list'));
        $labor->save();

        return $labor;
    }

    /**
     * Change labors status
     */
    public function changeStatus(Labor $labor) 
    {
        if($labor->status == 1) {
            $labor->status = 0;
        } else {
            $labor->status = 1;
        }
        $labor->save();

        return $labor;
    }

    /**
     * Display labor by it's company to JSON format
     */
    public function getLaborByCompany(Company $company)
    {
        $labors = Labor::where('company_id',$company->id)->get();
        return $labors;
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
