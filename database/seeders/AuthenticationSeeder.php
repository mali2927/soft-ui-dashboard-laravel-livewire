<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Authentication;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthenticationSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $datetime = Carbon::now()->subMinutes(rand(0, 1440));
            Authentication::create([
                'emp_id' => rand(1000, 2000),
                'authentication_datetime' => $datetime,
                'authentication_date' => $datetime->toDateString(),
                'authentication_time' => $datetime->toTimeString(),
                'direction' => rand(0, 1) ? 'IN' : 'OUT',
                'device_name' => 'Device-' . rand(1, 10),
                'device_serial_no' => Str::random(10),
                'person_name' => 'Employee ' . $i,
                'card_no' => rand(1000000000, 9999999999),
            ]);
        }
    }
}
