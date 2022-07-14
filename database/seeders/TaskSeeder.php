<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $initialValues = [
            'Сходить погулять',
            'Вкусно покушать',
            'Сладко поспать',
        ];
        array_walk($initialValues, function ($item) {
            DB::table('tasks')->insert([
                'name' => $item,
                'created_at' => now()
            ]);
        });
    }
}
