<?php

namespace Database\Seeders;

use App\Models\profileModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class profileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas=([
            [
                'user_id'=>1
            ],
            [
                'user_id'=>2
            ],
            [
                'user_id'=>3
            ],
            [
                'user_id'=>4
            ],
        ]);
        foreach($datas as $data){
          profileModel::create($data);
        }
    }
}
