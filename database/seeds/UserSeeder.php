<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        factory(User::class, rand(10, 30))->create();

        $user = new User();
        $user->name = 'user';
        $user->email = 'user@mail.com';
        $user->password = bcrypt('user');
        $user->phone = '111-11-11';
        $user->address = 'users home';
        $user->save();

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@mail.com';
        $admin->password = bcrypt('admin');
        $user->phone = '222-22-22';
        $admin->address = 'admins home';
        $admin->save();
    }
}
