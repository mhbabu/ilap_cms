<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Campus;
use App\Models\Handler;
use App\Models\Lead;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('en_GB');

        // Create roles first if they don't exist
        $userTypes = ['super_admin', 'hq_admin', 'campus_admin', 'campus_manager', 'handler', 'student'];
        foreach ($userTypes as $type) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => $type, 'guard_name' => 'web']);
        }

        // Campuses - check if exists first
        if (!Campus::exists()) {
            foreach (range(1, 5) as $idx) {
                Campus::create([
                    'name'    => "Demo Campus $idx",
                    'code'    => "DC$idx",
                    'address' => $faker->address,
                    'phone'   => $faker->phoneNumber,
                ]);
            }
        }

        foreach ($userTypes as $type) {
            $existing = User::where('email', "$type@test.com")->first();
            if (!$existing) {
                $user = new User([
                    'name'      => ucfirst(str_replace('_', ' ', $type)),
                    'email'     => "$type@test.com",
                    'password'  => Hash::make('123456'),
                    'role'      => $type,
                    'is_active' => true,
                ]);
                $user->save();
                $user->syncRoles([$type]);
            }
        }

        $handlerUser = User::where('role', 'handler')->first();
        if ($handlerUser && !Handler::where('user_id', $handlerUser->id)->exists()) {
            Handler::create([
                'user_id'   => $handlerUser->id,
                'name'      => "Demo Handler",
                'email'     => "handler@test.com",
                'phone'     => $faker->phoneNumber,
                'is_active' => true,
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            $existing = User::where('email', "student$i@ilap.com")->first();
            if (!$existing) {
                User::create([
                    'name'      => "Demo Student $i",
                    'email'     => "student$i@ilap.com",
                    'password'  => Hash::make('123456'),
                    'role'      => 'student',
                    'phone'     => $faker->phoneNumber,
                    'is_active' => true,
                    'campus_id' => Campus::inRandomOrder()->first()?->id,
                ]);
            }
        }

        for ($s = 1; $s <= 12; $s++) {
            $existing = Lead::where('name', "Demo Lead $s")->first();
            if (!$existing) {
                Lead::create([
                    'name'    => "Demo Lead $s",
                    'email'   => "lead$s@test.com",
                    'phone'   => $faker->phoneNumber,
                    'status'  => collect(['new', 'contacted', 'disqualified', 'converted'])->random(),
                    'source'  => collect(['Website', 'Referral', 'Facebook', 'Walking', 'Phone'])->random(),
                ]);
            }
        }
    }
}