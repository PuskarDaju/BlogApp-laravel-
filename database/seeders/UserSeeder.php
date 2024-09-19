<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userDatas=([[
            'name'=>'Albert',
            'email'=>'albert@gmail.com',
            'password'=>'password',
            'userType'=>'user'

        ],
        [
            'name'=> 'Newton',
            'email'=>'newton@gmail.com',
            'password'=>'password',
            'userType'=>'admin'
        ],
        [
            'name'=> 'Thomas',
            'email'=>'thomas@gmail.com',
            'password'=>'password',
            'userType'=>'user'
        ],
        [
            'name'=> 'Stephen',
            'email'=>'stephen@gmail.com',
            'password'=>'password',
            'userType'=>'admin'
        ]
    ]);
    foreach($userDatas as $data){
        User::create($data);
    }
    }

   
}
