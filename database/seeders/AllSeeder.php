<?php

use App\Models\User;
use App\Models\Campus;
use App\Models\Student;
use App\Models\Lead;
use App\Models\Finance;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\Document;
use App\Models\Enrollment;
use App\Models\ClassRoom;
use App\Models\Module;
use App\Models\ModuleAffiliate;
use App\Models\ClassRecord;
use App\Models\Payment;
use App\Models\DocumentApproval;
use App\Models\Message;
use App\Models\ReportLog;
use App\Models\EmailTemplate;
use App\Models\SystemDocumentTemplate;
use App\Models\Handler;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

return new class extends Seeder
{
    public function run(): void
    {
        // Clear existing
        \Illuminate\Support\Facades\DB::statement('SET foreign_key_checks = 0');
        ReportLog::truncate();
        EmailTemplate::truncate();
        SystemDocumentTemplate::truncate();
        Message::truncate();
        DocumentApproval::truncate();
        Payment::truncate();
        ClassRecord::truncate();
        ModuleAffiliate::truncate();
        Module::truncate();
        ClassRoom::truncate();
        Enrollment::truncate();
        Document::truncate();
        TicketMessage::truncate();
        Ticket::truncate();
        Finance::truncate();
        Lead::truncate();
        Student::truncate();
        Handler::truncate();
        \App\Models\User::truncate();
        Role::truncate();
        Campus::truncate();
        \Illuminate\Support\Facades\DB::statement('SET foreign_key_checks = 1');

        $this->seedCampuses();
        $this->seedRoles();
        $this->seedUsers();
        $this->seedModules();
        $this->seedStudentsAndLeads();
        $this->seedFinance();
        $this->seedTickets();
        $this->seedDocuments();
        $this->seedMessages();
        $this->seedSettings();

        // Symlink storage
        $this->command->info('Demo seed completed.');
    }

    private function seedCampuses()
    {
        $campuses = [
            ['name' => 'Global HQ',              'code' => 'HQ',  'master_campus' => '0'],
            ['name' => 'Manchester Campus',      'code' => 'MAN', 'master_campus' => '1'],
            ['name' => 'Leeds Campus',           'code' => 'LDS', 'master_campus' => '1'],
            ['name' => 'Liverpool Campus',       'code' => 'LVP', 'master_campus' => '1'],
            ['name' => 'London Campus',          'code' => 'LDN', 'master_campus' => '1'],
            ['name' => 'Birmingham Campus',      'code' => 'BRM', 'master_campus' => '1'],
        ];

        foreach ($campuses as $c) {
            Campus::create($c);
        }
    }

    private function seedRoles()
    {
        $roles = ['super_admin','hq_admin','campus_admin','campus_manager','handler','student','counsellor','parent','external_agent','corporate','respondent','instructor'];
        foreach ($roles as $role) {
            Role::create(['name'=>$role,'guard_name'=>'web']);
        }
    }

    private function seedUsers()
    {
        $roles = Role::pluck('name', 'name');

        $users = [
            [
                'name'       => 'Super Admin',
                'email'      => 'superadmin@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['super_admin'],
                'is_active'  => true,
                'unique_id'  => 'USRSUPER001',
                'phone'      => '+44 7000 000000',
            ],
            [
                'name'       => 'HQ Admin',
                'email'      => 'hqadmin@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['hq_admin'],
                'is_active'  => true,
                'unique_id'  => 'USRHQ001',
                'phone'      => '+44 7000 000001',
            ],
            [
                'name'       => 'Manchester Admin',
                'email'      => 'man.admin@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['campus_admin'],
                'is_active'  => true,
                'campus_id'  => Campus::where('code','MAN')->first()?->id,
                'unique_id'  => 'USRMAN001',
                'phone'      => '+44 7000 000002',
            ],
            [
                'name'       => 'Handler One',
                'email'      => 'handler1@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['handler'],
                'is_active'  => true,
                'campus_id'  => Campus::where('code','MAN')->first()?->id,
                'unique_id'  => 'USRHNDL001',
                'phone'      => '+44 7000 000003',
            ],
            [
                'name'       => 'Handler Two',
                'email'      => 'handler2@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['handler'],
                'is_active'  => true,
                'campus_id'  => Campus::where('code','LDS')->first()?->id,
                'unique_id'  => 'USRHNDL002',
                'phone'      => '+44 7000 000004',
            ],
            [
                'name'       => 'Demo Student',
                'email'      => 'student@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['student'],
                'is_active'  => true,
                'campus_id'  => Campus::where('code','MAN')->first()?->id,
                'unique_id'  => 'USRSTU001',
                'phone'      => '+44 7000 000005',
                'ielts_score'=> 6.5,
            ],
            [
                'name'       => 'Manager Manchester',
                'email'      => 'man.manager@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['campus_manager'],
                'is_active'  => true,
                'campus_id'  => Campus::where('code','MAN')->first()?->id,
                'unique_id'  => 'USRMNG001',
                'phone'      => '+44 7000 000006',
            ],
            [
                'name'       => 'Demo Parent',
                'email'      => 'parent@ilap.com',
                'password'   => Hash::make('Password@123'),
                'role'       => $roles['parent'],
                'is_active'  => true,
                'unique_id'  => 'USRPAR001',
                'phone'      => '+44 7000 000007',
            ],
        ];

        foreach ($users as $u) {
            $user = User::create($u);
            $user->syncRoles([$u['role']]);
        }
    }

    private function seedModules()
    {
        $modules = [
            ['name'=>'English Foundation','code'=>'ENG-FND','description'=>'Foundation level English course'],
            ['name'=>'IELTS Intensive','code'=>'IELTS','description'=>'IELTS exam preparation'],
            ['name'=>'Academic Writing','code'=>'ACAD-WRT','description'=>'University academic writing'],
            ['name'=>'Business English','code'=>'BIZ-ENG','description'=>'Business communication English'],
            ['name'=>'Spoken & Presentation','code'=>'SPKN-PRE','description'=>'Public speaking and presentations'],
            ['name'=>'PTE Academic','code'=>'PTE-ACAD','description'=>'Pearson Test of English prep'],
        ];

        foreach ($modules as $m) {
            $exists = Module::where('code',$m['code'])->exists();
            if (!$exists) Module::create($m);
        }
    }

    private function seedStudentsAndLeads()
    {
        $campusIds   = Campus::pluck('id')->toArray();
        $handlerIds  = Handler::pluck('id')->toArray();
        $steps       = ['registered','payment_pending','enrolled','documents_verified','completed'];

        foreach (range(1,30) as $i) {
            $student = Student::create([
                'name'          => "Test Student $i",
                'email'         => "student$i@test.com",
                'phone'         => '+44 '.rand(700,799).' '.rand(100000,999999),
                'passport_number'=> 'P'.rand(100000,999999),
                'ielts_score'   => rand(5,8) + rand(0,9)/10,
                'qualification' => 'Bachelor',
                'address'       => "Address $i",
                'date_of_birth' => Carbon::now()->subYears(rand(18,30))->format('Y-m-d'),
                'parent_phone'  => '+44 7990 000'.str_pad($i,4,'0',STR_PAD_LEFT),
                'parent_email'  => "parent$i@parent.com",
                'campus_id'     => $campusIds[array_rand($campusIds)],
                'status'        => 'active',
            ]);

            Lead::firstOrCreate(
                ['name' => $student->name],
                ['name'=>$student->name,'email'=>$student->email,'phone'=>$student->phone,
                 'campus_id'=>$student->campus_id,'source'=>'demo','status'=>'new']
            );

            // Assign handler
            $handlerId = Handler::inRandomOrder()->first()?->id;
            if ($handlerId) {
                $student->update(['handler_id'=>$handlerId]);
            }
        }

        // Students in enrollment flow
        $enrolled = Student::where('status','active')->take(15)->get();
        foreach ($enrolled as $student) {
            $step = $steps[array_rand($steps)];
            $student->update(['current_step'=>$step]);
        }
        foreach ($enrolled as $student) {
            Campus::findOrFail($student->campus_id);
        }
    }

    private function seedFinance()
    {
        $students = Student::take(10)->get();
        $amounts  = [1200, 2400, 1800, 3000, 1500];
        $types    = ['installation','partial','one_time','tution','refund'];

        foreach ($students as $student) {
            for ($j=0; $j < rand(1,3); $j++) {
                Finance::create([
                    'payer_id'      => $student->id,
                    'campus_id'     => $student->campus_id,
                    'amount'        => $amounts[array_rand($amounts)],
                    'type'          => $types[array_rand($types)],
                    'status'        => collect(['pending','completed','rejected'])->random(),
                    'payment_method'=> collect(['bank_transfer','cash','card','online'])->random(),
                    'account_name'  => 'Demo Account',
                    'initiated_by'  => rand(1,3),
                    'transaction_ref'=> 'TXN'.Str::upper(Str::random(10)),
                    'notes'         => 'Demo payment',
                ]);
            }
        }
    }

    private function seedTickets()
    {
        $types    = ['academic','finance','student','technical','other'];
        $priority = ['low','medium','high','critical'];
        $statuses = ['open','in_progress','resolved','closed'];

        for ($i=1; $i<=20; $i++) {
            $ticket = Ticket::create([
                'title'       => "Demo Ticket $i - ".collect($types)->random(),
                'description' => "Description for ticket $i",
                'type'        => $types[array_rand($types)],
                'priority'    => $priority[array_rand($priority)],
                'status'      => $statuses[array_rand($statuses)],
                'created_by'  => rand(1,5),
                'handler_id'  => rand(1,2) ?: null,
                'campus_id'   => rand(1,3)+1,
                'assigned_to' => rand(1,3) ?: null,
                'ticket_number' => 'TKT-'.Str::upper(Str::random(8)),
            ]);

            for ($m=0; $m<rand(1,4); $m++) {
                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id'   => rand(1,5),
                    'message'   => "Message $m for ticket $i",
                    'is_internal' => rand(0,1),
                ]);
            }
        }
    }

    private function seedDocuments()
    {
        $fillable = ['title','collection','mime','filename',
                     'uploaded_by','campus_id','student_id',
                     'is_guide_document','description'];
        $docs = [
            ['title'=>'Student Guide','collection'=>'guide_pack','mime'=>'PDF'],
            ['title'=>'IELTS Handbook','collection'=>'handbook','mime'=>'PDF'],
            ['title'=>'Enrollment Pack','collection'=>'enrollment','mime'=>'DOC'],
            ['title'=>'Finance Form','collection'=>'finance','mime'=>'PDF'],
            ['title'=>'Campus Rules','collection'=>'content','mime'=>'PDF'],
            ['title'=>'PTE Practice','collection'=>'content','mime'=>'PDF'],
        ];
        foreach (array_merge($docs, $docs) as $data) {
            Document::firstOrCreate(['title'=>$data['title']], array_merge($data, [
                'filename'              => 'demo-'.Str::random(8).'.pdf',
                'uploaded_by'           => 1,
                'campus_id'             => Campus::first()->id,
                'is_guide_document'     => true,
                'description'           => 'Demo document',
            ]));
        }
    }

    private function seedMessages()
    {
        $users = User::all();
        foreach ($users as $sender) {
            $recipients = $users->where('id','!=',$sender->id)->random(rand(2,5));
            foreach ($recipients as $recipient) {
                Message::create([
                    'sender_id'   => $sender->id,
                    'receiver_id' => $recipient->id,
                    'subject'     => "Demo: {$sender->name} → {$recipient->name}",
                    'body'        => "Demo message between {$sender->name} and {$recipient->name}.",
                    'type'        => collect(['email','internal'])->random(),
                    'is_read'     => rand(0,1),
                    'sent_at'     => now()->subDays(rand(0,30)),
                ]);
            }
        }
    }

    private function seedSettings()
    {
        $templates = [
            ['name'=>'welcome-student','subject'=>'Welcome to iLAP!','type'=>'student','body_html'=>'<p>Welcome to iLAP, {{name}}!</p>'],
            ['name'=>'payment-reminder','subject'=>'Payment Due Reminder','type'=>'finance','body_html'=>'<p>Dear {{name}}, your payment of {{amount}} is due.</p>'],
            ['name'=>'enrollment-approved','subject'=>'Enrollment Approved','type'=>'enrollment','body_html'=>'<p>Your enrollment has been approved!</p>'],
        ];
        foreach ($templates as $t) {
            EmailTemplate::updateOrCreate(['name'=>$t['name']], $t);
        }

        SystemDocumentTemplate::create([
            'name'        => 'Default Invoice',
            'type'        => 'form',
            'file_path'   => 'system/templates/invoice.pdf',
            'uploaded_by' => 1,
            'is_active'   => true,
        ]);
    }
};
