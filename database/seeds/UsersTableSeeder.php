<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $userRole 			= Role::where('name', '=', 'User')->first();
        $adminRole 			= Role::where('name', '=', 'Admin')->first();
        $representativeRole = Role::where('name', '=', 'Representative')->first();
		$permissions 		= Permission::all();

	    /**
	     * Add Users
	     *
	     */
        if (User::where('email', '=', 'admin@admin.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Admin',
	            'email' => 'admin@admin.com',
				'password' => bcrypt('password'),
				'company_id' => 1,
	        ]);

	        $newUser->attachRole($adminRole);
			foreach ($permissions as $permission) {
				$newUser->attachPermission($permission);
			}

        }

        if (User::where('email', '=', 'user@user.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'User',
	            'email' => 'user@user.com',
				'password' => bcrypt('password'),
				'company_id' => 1,
	        ]);

	        $newUser;
	        $newUser->attachRole($userRole);

		}

		if (User::where('email', '=', 'wizman.carlosops@gmail.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Carlos Anthony Del Pilar',
	            'email' => 'wizman.carlosops@gmail.com',
				'password' => bcrypt('carlos.delpilar'),
				'company_id' => 1,
	        ]);

	        $newUser;
	        $newUser->attachRole($representativeRole);

		}

		if (User::where('email', '=', 'jcmcking2015@gmail.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'JC Maghirang',
	            'email' => 'jcmcking2015@gmail.com',
				'password' => bcrypt('jc.maghirang'),
				'company_id' => 2,
	        ]);

	        $newUser;
	        $newUser->attachRole($representativeRole);

        }
		if (User::where('email', '=', 'bertpatolot24@gmail.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Edilberto Patolot',
	            'email' => 'bertpatolot24@gmail.com',
				'password' => bcrypt('edilberto.patolot'),
				'company_id' => 2,
	        ]);

	        $newUser;
	        $newUser->attachRole($representativeRole);

        }
		if (User::where('email', '=', 'bernard.flores.ge2018@gmail.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Bernard Flores',
	            'email' => 'bernard.flores.ge2018@gmail.com',
				'password' => bcrypt('bernard.flores'),
				'company_id' => 2,
	        ]);

	        $newUser;
	        $newUser->attachRole($representativeRole);

		}

		if (User::where('email', '=', 'esparterosharyl0201@gmail.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Sheryl Espartero',
	            'email' => 'esparterosharyl0201@gmail.com',
				'password' => bcrypt('sheryl.espartero'),
				'company_id' => 3,
	        ]);

	        $newUser;
	        $newUser->attachRole($representativeRole);

		}

		if (User::where('email', '=', 'oliver.operiano@yahoo.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Oliver Operiano',
	            'email' => 'oliver.operiano@yahoo.com',
				'password' => bcrypt('oliver.operiano'),
				'company_id' => 3,
	        ]);

	        $newUser;
	        $newUser->attachRole($representativeRole);

		}

		if (User::where('email', '=', 'ryan.roncales@philippineforemost.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Ryan Roncales',
	            'email' => 'ryan.roncales@philippineforemost.com',
				'password' => bcrypt('ryan.roncales'),
				'company_id' => 1,
	        ]);

	        $newUser->attachRole($adminRole);
			foreach ($permissions as $permission) {
				$newUser->attachPermission($permission);
			}

        }

    }
}
