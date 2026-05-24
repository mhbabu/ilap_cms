<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Campus;
use App\Models\Lead;
use App\Models\Handler;
use Faker\Factory as FakerFactory;

return new class extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('en_GB');

        // repeat-safe checks for seeded id
        if (\Illuminate\Support\Facades\Schema::hasTable('users')) {

            // Campus:
            foreach (range(1, 5) as $idx) {
                $campus = Campus::create([
                    'name'          => "Demo Campus $idx",
                    'code'          => "DC$idx",
                    'address'       => $faker->address(),
                    'phone'         => $faker->phoneNumber(),
                ]);
            }

            // User: super_admin, hq_admin, campus_admin, campus_manager, handler, student
            $userTypes = ['super_admin', 'hq_admin', 'campus_admin', 'campus_manager', 'handler', 'student'];
            foreach ($userTypes as $type) {
                $user = User::firstOrCreate(
                    ['email' => "$type@test.com"],
                    [
                        'name'       => ucfirst(str_replace('_',' ',$type)),
                        'password'   => Hash::make('Password@123'),
                        'role'       => $type,
                        'is_active'  => true,
                    ]
                );
                $user->syncRoles([$type]);
            }

            // ++ 2 extra handlers
            foreach(range(1,2) as $i) {
                $handler = Handler::create([
                    'user_id'  => User::where('role','handler')->skip($i - 1)->first()->id,
                    'name'     => "Handler $i",
                    'email'    => "handler$i@test.com",
                    'phone'    => $faker->phoneNumber(),
                    'is_active'=> true,
                ]);
            }

            // ++ 15 students
            for($i=1; $i<=15; $i++) User::create([
                'name'       => "Demo Student $i",
                'email'      => "student$i@ilap.com",
                'password'   => Hash::make('Password@123'),
                'role'       => 'student',
                'phone'      => $faker->phoneNumber(),
                'is_active'  => true,
                'campus_id'  => Campus::inRandomOrder()->first()->id,
            ]);

            // Leads:
            for ($s=1; $s<=12; $s++) {
                Lead::create([
                    'name'    => "Demo Lead $s",
                    'email'   => "lead$s@test.com",
                    'phone'   => $faker->phoneNumber(),
                    'status'  => collect(['new','contacted','disqualified','converted'])->random(),
                    'source'  => collect(['Website','Referral','Facebook','Walking','Phone'])->random(),
                ]);
            }
        }
    }
};
