<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class RolesPermissionsController extends Controller
{
    /**
     * Roles and Permission view
     *
     * @return void
     */
    public function index()
    {
        return view('role-perm.index');
    }

    /**
     * Get permissions by the given roles
     *
     * @param App\Role $role
     * @return json
     */
    public function getPermissions()
    {
        $permissions = Permission::orderBy('id','ASC')
                            ->with('roles')->get();
        return $permissions;
    }

    /**
     * Get all roles
     *
     * @return json
     */
    public function getRoles()
    {
       $roles = Role::orderBy('id','ASC')->with('permissions')->get();
        return $roles;
    }

    /**
     * Store Permissions
     *
     * @param Request $request
     * @return void
     */
    public function storePermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
            'slug' => 'required|unique:permissions,slug',
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description')
        ]);

        $role = Role::find($request->input('role_list'));
        $role->attachPermission($permission);

        return $permission;
    }

    public function attachOrDetach(Request $request, Role $role)
    {
        if(!empty($request->input('attached_id'))) {
            $role->attachPermission($request->input('attached_id'));
        }
        if(!empty($request->input('dettached_id'))) {
            $role->detachPermission($request->input('dettached_id'));
        }
        $role->save();
    }

    /**
     * Store New Roles
     *
     * @param Request $request
     * @return void
     */
    public function storeRoles(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'level' => 'required|unique:roles,level',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'slug' => strtoupper(str_replace(' ','-', $request->input('name'))),
            'description' => $request->input('description'),
            'level' => $request->input('level'),
        ]);

        $getRole = Role::where('id', $role->id)->with('permissions')->first();

        return $getRole;
    }

    public function removeRole(Request $request, Role $role)
    {
        if($role->id != 1) {
            $role->delete();
            return $role;
        } else {
            return Response::json(['message' => 'Cannot delete admin role'], 500);
        }
    }

}
