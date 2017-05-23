<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     //填充用户信息类
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->toArray());
        //指定第一个用户;
        $user = User::find(1);
        $user->name = 'Apple';
        $user->email = 'apple_mgg@sina.com';
        $user->password =  bcrypt('mgg123');
        $user->is_admin = true;
        $user->save();

    }
}
