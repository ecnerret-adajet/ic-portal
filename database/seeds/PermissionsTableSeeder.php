<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	    /**
	     * Add Permissions
	     *
	     */
        if (Permission::where('name', '=', 'Can View Users')->first() === null) {
			Permission::create([
			    'name' => 'Can View Users',
			    'slug' => 'view.users',
			    'description' => 'Can view users',
			    'model' => 'Permission',
			]);
        }

        if (Permission::where('name', '=', 'Can Create Users')->first() === null) {
			Permission::create([
			    'name' => 'Can Create Users',
			    'slug' => 'create.users',
			    'description' => 'Can create new users',
			    'model' => 'Permission',
			]);
        }

        if (Permission::where('name', '=', 'Can Edit Users')->first() === null) {
			Permission::create([
			    'name' => 'Can Edit Users',
			    'slug' => 'edit.users',
			    'description' => 'Can edit users',
			    'model' => 'Permission',
			]);
        }

        if (Permission::where('name', '=', 'Can Delete Users')->first() === null) {
			Permission::create([
			    'name' => 'Can Delete Users',
			    'slug' => 'delete.users',
			    'description' => 'Can delete users',
			    'model' => 'Permission',
			]);
		}

		DB::table('permissions')->insert([
			[
				'name' => 'Add Permission',
				'slug' => 'add.permission',
				'description' => 'Can add new permission',
				'model' => 'Permission'
			],
			[
				'name' => 'Update Permission',
				'slug' => 'update.permission',
				'description' => 'Can update permission to role',
				'model' => 'Permission'
			],
			[
				'name' => 'Add Role',
				'slug' => 'add.role',
				'description' => 'Can add new role',
				'model' => 'Permission'
			],
			[
				'name' => 'Delete Role',
				'slug' => 'delete.role',
				'description' => 'Can delete a role',
				'model' => 'Permission'
			],
			[
				'name' => 'View Providers',
				'slug' => 'view.providers',
				'description' => 'Can view all providers',
				'model' => 'Permission'
			],
			[
				'name' => 'Add Providers',
				'slug' => 'add.providers',
				'description' => 'Can add providers',
				'model' => 'Permission'
			],
			[
				'name' => 'View Assigned',
				'slug' => 'view.assigned',
				'description' => 'Can view all assigned members',
				'model' => 'Permission'
			],
			[
				'name' => 'Assign Member',
				'slug' => 'assign.member',
				'description' => 'Can assigned a members',
				'model' => 'Permission'
			],
			[
				'name' => 'View Members',
				'slug' => 'view.members',
				'description' => 'Can view all members',
				'model' => 'Permission'
			],
			[
				'name' => 'Add Member',
				'slug' => 'add.member',
				'description' => 'Can add a member',
				'model' => 'Permission'
			],
			[
				'name' => 'Update Member',
				'slug' => 'update.member',
				'description' => 'Can update a member',
				'model' => 'Permission'
			],
			[
				'name' => 'Marked Member',
				'slug' => 'marked.member',
				'description' => 'Can marked member as active or inactive',
				'model' => 'Permission'
			],
		]);

    }
}
