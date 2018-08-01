<?php

namespace Tests\Feature;

use Tests\TestCase;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesPermissionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testGetPermissions()
    {
        $permissions = Permission::with('roles')->get();
        echo json_encode($permissions,JSON_PRETTY_PRINT);
    }

    public function testGetRoles()
    {
        $roles = Role::orderBy('id','desc')->with('permissions')->get();
        echo json_encode($roles,JSON_PRETTY_PRINT);
    }

}
