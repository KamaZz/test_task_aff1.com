<?php

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
        $regions = [
            'Africa' => DateTimeZone::AFRICA,
            'America' => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Asia' => DateTimeZone::ASIA,
            'Atlantic' => DateTimeZone::ATLANTIC,
            'Europe' => DateTimeZone::EUROPE,
            'Indian' => DateTimeZone::INDIAN,
            'Pacific' => DateTimeZone::PACIFIC
        ];
        foreach ($regions as $name => $mask) {
            \App\Models\Timezone::insert(
                array_map(function($z) {
                    return ['name' => $z];
                }, DateTimeZone::listIdentifiers($mask))
            );
        }

        factory(\App\Models\User::class, 1000000)->create();
        factory(\App\Models\Mail::class, 10000)->create();
    }
}
