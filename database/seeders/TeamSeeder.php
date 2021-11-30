<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    protected string $tableName = 'teams';

    protected array $teams = [
        'Chelsea',
        'Manchester City',
        'Liverpool',
        'Arsenal',
        'West Ham United',
        'Wolverhampton Wanderers',
        'Tottenham Hotspur',
        'Manchester United',
        'Brighton and Hove Albion',
        'Crystal Palace',
        'Everton',
        'Leicester City',
        'Southampton',
        'Brentford',
        'Aston Villa',
        'Watford',
        'Leeds United',
        'Burnley',
        'Norwich City',
        'Newcastle United',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //added it to truncate table in the PostgresSQL
        DB::statement("TRUNCATE TABLE {$this->tableName} RESTART IDENTITY CASCADE");
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        DB::table($this->tableName)->truncate();
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table($this->tableName)->insert($this->prepareData());
    }

    protected function prepareData(): array
    {
        $data = [];
        $index = 1;

        foreach ($this->teams as $team) {
            $data[] = [
                'id' => $index++,
                'name' => $team,
            ];
        }

        return $data;
    }
}
