<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([

            'name' =>'Nurnabi Islam',
            'email' =>'nur@web.com',
            'company' =>'Nur Agency',
            'phone' =>'+8801746485745',
            'country' =>'Bangladesh',
            'password' =>bcrypt('123'),
            'thumbnail' =>'https://picsum.photos/300'

        ]);
        // User::create([

        //             'name' =>'Sn',
        //             'email' =>'sn@web.com',
        //             'company' =>'Nur ITAgency',
        //             'phone' =>'+8801746485745',
        //             'country' =>'Bangladesh',
        //             'password' =>bcrypt('123'),
        //             'thumbnail' =>'https://picsum.photos/300'

        //         ]);

        Client::factory(5)->create();

         Task::factory(10)->create();

         Invoice::factory(10)->create();
    }
}
