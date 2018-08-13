<?php

namespace App\Http\Controllers;

use Flashy;
use App\User;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Display list of all users in the portal
     */
    public function getUsers()
    {
        $users = User::orderBy('id','DESC')->get();

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','id');
        $companies = Company::pluck('name','id');
        return view('users.create',compact('roles','companies'));
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
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:users,email',
            'role_list' => 'required',
            'company_list' => 'required'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $user->attachRole($request->input('role_list'));
        $user->company()->associate($request->input('company_list'));
        $user->save();


        flashy()->success('User has successfully updated!');
        // return redirect('users');
        return ['redirect' => route('users.index')];
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
    public function edit(User $user)
    {
        $roles = Role::pluck('name','id');
        return view('users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role_list' => 'required',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if(!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->attachRole($request->input('role_list'));
        $user->save();

        flashy()->success('Driver has successfully updated!');
        return redirect('users/'.$user->id);
    }

    public function profileEdit(User $user)
    {
        if(Gate::denies('profile-edit', $user, Auth::user())) {
            flashy()->error('Nope, You Cannot Do That!');
            return back();
        }

        return view('users.profile',compact('user'));
    }

    public function profileUpdate(Request $request, User $user)
    {

        if(Gate::denies('profile-update', $user, Auth::user())) {
            return response('Unauthorized', 401);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed|min:6',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if(!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

         return $user;
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

    /**
     * Display Current login user
     *
     * @return object
     */
    public function currentUser()
    {
        return new UserResource(User::find(Auth::user()->id));
    }

    /**
     * Portal Disclaimer
     *
     * @param Request $request
     * @param User $user
     * @return response 202
     */
    public function disclaimer(Request $request, User $user)
    {

        $randomKey = str_random(10);
        Session::put('disclaimer', $randomKey);

        if ($request->session()->has('disclaimer')) {
            return 'success';
        }

    }
}
