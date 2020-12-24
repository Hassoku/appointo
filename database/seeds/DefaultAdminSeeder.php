<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\User;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'M.S.Dhoni';
        $user->email = 'admin@example.com';
        $user->mobile = '1919191919';
        $user->password = '123456';

        $user->save();

        $user->attachRole(Role::where('name', 'administrator')->first()->id);
    }
}
