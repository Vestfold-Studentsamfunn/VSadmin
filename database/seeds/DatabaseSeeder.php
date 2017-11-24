<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->command->info('Seeding....');
        DB::table('membersData')->delete();
        factory(App\Members::class, 750)->create();
        $this->command->info('Member table seeded!');

        //$this->command->info('Hemsedal table seeded!');

        Model::reguard();
    }
}