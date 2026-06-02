<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Campus;
use App\Models\Student;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Document;
use App\Models\Ticket;
use App\Models\SidebarSection;
use Faker\Factory as FakerFactory;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('en_GB');

        // Permission tables are already created via migration.
        if (!Permission::where('name', 'dashboard.view')->exists()) {
            $modules = ['dashboard','students','leads','finance','documents','tickets','messages','campuses','reports','settings','users'];
            $actions = ['view','create','edit','delete'];

            foreach ($modules as $module) {
                foreach ($actions as $action) {
                    Permission::firstOrCreate([
                        'name' => "{$module}.{$action}",
                        'guard_name' => 'web',
                    ]);
                }
            }
        }

        // Guarantee key roles exist
        $roles = ['super_admin','campuses'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        if (!Campus::exists()) {
            foreach (range(1, 6) as $idx) {
                Campus::create([
                    'name'           => "Demo Campus $idx",
                    'code'           => "DC{$idx}",
                    'address'        => $faker->address(),
                    'phone'          => $faker->phoneNumber(),
                    'email'          => "campus{$idx}@ilap.com",
                    'is_active'      => true,
                    'color_primary'  => '#1e40af',
                    'color_secondary'=> '#3b82f6',
                ]);
            }
        }

        if (!User::where('email', 'super_admin@test.com')->exists()) {
            $user = User::create([
                'name'      => 'super_admin',
                'email'     => 'super_admin@test.com',
                'password'  => Hash::make('123456'),
                'role'      => 'super_admin',
                'is_active' => true,
                'campus_id' => Campus::inRandomOrder()->first()?->id,
            ]);
            $user->syncRoles(['super_admin']);
        }

        if (!User::where('email', 'campuses@test.com')->exists()) {
            $user = User::create([
                'name'      => 'Campuses',
                'email'     => 'campuses@test.com',
                'password'  => Hash::make('123456'),
                'role'      => 'campuses',
                'is_active' => true,
                'campus_id' => Campus::inRandomOrder()->first()?->id,
            ]);
            $user->syncRoles(['campuses']);
        }

        $this->seedMessages($faker);
    }

    private function seedMessages($faker): void
    {
        $users = User::all();
        if ($users->count() < 2) {
            return;
        }

        if (!\App\Models\Message::exists()) {
            foreach (range(1, 40) as $idx) {
                $sender = $users->random();
                $receiver = $users->random();

                while ($receiver->id === $sender->id) {
                    $receiver = $users->random();
                }

                \App\Models\Message::create([
                    'sender_id'   => $sender->id,
                    'receiver_id' => $receiver->id,
                    'subject'     => $faker->sentence(4),
                    'body'        => $faker->paragraph(2),
                    'type'        => collect(['email','internal'])->random(),
                    'is_read'     => (bool) rand(0, 1),
                    'sent_at'     => now()->subDays(rand(0, 14)),
                ]);
            }
        }
    }
}
