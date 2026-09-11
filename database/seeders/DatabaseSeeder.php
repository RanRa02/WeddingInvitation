<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Guest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Super Admin',
                'description' => 'មានសិទ្ធិគ្រប់គ្រងប្រព័ន្ធទាំងមូល (Full System Access)',
                'permissions' => ['manage-users', 'manage-roles', 'manage-guests', 'view-reports'],
            ]
        );

        $managerRole = Role::updateOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Manager',
                'description' => 'គ្រប់គ្រងបញ្ជីភ្ញៀវ និងរបាយការណ៍ (Guest & Reports Access)',
                'permissions' => ['manage-guests', 'view-reports'],
            ]
        );

        $editorRole = Role::updateOrCreate(
            ['slug' => 'editor'],
            [
                'name' => 'Editor',
                'description' => 'គ្រប់គ្រងបញ្ជីភ្ញៀវ (Guest Access)',
                'permissions' => ['manage-guests'],
            ]
        );

        $customerRole = Role::updateOrCreate(
            ['slug' => 'customer'],
            [
                'name' => 'Customer / Couple',
                'description' => 'អតិថិជនបង្កើតធៀបការ និងគ្រប់គ្រងភ្ញៀវ (Customer Access)',
                'permissions' => ['manage-own-wedding', 'manage-own-guests'],
            ]
        );

        // 2. Seed Subscription Plans
        $plans = [
            [
                'name' => 'Free Trial (កញ្ចប់សាកល្បង)',
                'slug' => 'free-trial',
                'price' => 0.00,
                'guest_limit' => 50,
                'duration_days' => 14,
                'description' => 'សាកល្បងបង្កើតធៀបការ និងភ្ញៀវ ៥០នាក់',
                'features' => ['កព្ចប់សាកល្បង ១៤ថ្ងៃ', 'ចំនួនភ្ញៀវអតិបរមា ៥០ នាក់', 'ជ្រើសរើសបាន 1 Template', 'Export របាយការណ៍'],
            ],
            [
                'name' => 'Silver Plan (កញ្ចប់ប្រាក់)',
                'slug' => 'silver',
                'price' => 29.00,
                'guest_limit' => 250,
                'duration_days' => 60,
                'description' => 'ស័ក្តិសមសម្រាប់អាពាហ៍ពិពាហ៍ខ្នាតមធ្យម',
                'features' => ['រយៈពេលប្រើប្រាស់ ៦០ថ្ងៃ', 'ចំនួនភ្ញៀវអតិបរមា ២៥០ នាក់', 'គ្រប់ Template ទាំងអស់ (Married, Sapphire, Ruby)', 'Telegram & WhatsApp Link Share', 'QR Code Generator'],
            ],
            [
                'name' => 'Gold Premium (កញ្ចប់មាស)',
                'slug' => 'gold-premium',
                'price' => 59.00,
                'guest_limit' => 600,
                'duration_days' => 180,
                'description' => 'ស័ក្តិសមសម្រាប់អាពាហ៍ពិពាហ៍ខ្នាតធំ',
                'features' => ['រយៈពេលប្រើប្រាស់ ១៨០ថ្ងៃ', 'ចំនួនភ្ញៀវអតិបរមា ៦០០ នាក់', 'គ្រប់ Template + Custom Domain/Slug', 'គ្រប់គ្រងតុ និងកៅអី', 'Export Excel & PDF Report'],
            ],
            [
                'name' => 'Diamond VIP (កញ្ចប់ពេជ្រ)',
                'slug' => 'diamond-vip',
                'price' => 99.00,
                'guest_limit' => 2000,
                'duration_days' => 365,
                'description' => 'សម្រាប់ពិធីមង្គលការធំដុំ និង VIP Support',
                'features' => ['រយៈពេលប្រើប្រាស់ ១ ឆ្នាំ', 'ចំនួនភ្ញៀវអតិបរមា ២០០០ នាក់', 'Custom Theme & Personal Background', 'VIP Support 24/7', 'សំបុត្រអញ្ជើញ VIP មិនកំណត់'],
            ],
        ];

        foreach ($plans as $p) {
            \App\Models\SubscriptionPlan::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 3. Seed Default Admin & Customer Users
        User::updateOrCreate(
            ['email' => 'admin@wedding.com'],
            [
                'name' => 'Super Admin',
                'password' => md5('password123'),
                'role_id' => $adminRole->id,
                'status' => 'active',
                'guest_limit' => 10000,
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@wedding.com'],
            [
                'name' => 'លោក ហេង សម្បត្តិ (Manager)',
                'password' => md5('password123'),
                'role_id' => $managerRole->id,
                'status' => 'active',
            ]
        );

        $customerUser = User::updateOrCreate(
            ['email' => 'customer@wedding.com'],
            [
                'name' => 'ជា រដ្ឋា & សុខ ស្រីនាង (Couple)',
                'password' => md5('password123'),
                'role_id' => $customerRole->id,
                'status' => 'active',
                'guest_limit' => 250,
            ]
        );

        // Seed Active Subscription for Customer
        $silverPlan = \App\Models\SubscriptionPlan::where('slug', 'silver')->first();
        if ($silverPlan) {
            \App\Models\Subscription::updateOrCreate(
                ['user_id' => $customerUser->id],
                [
                    'plan_id' => $silverPlan->id,
                    'amount' => $silverPlan->price,
                    'status' => 'active',
                    'payment_method' => 'khqr',
                    'transaction_id' => 'TXN-' . rand(10000, 99999),
                    'starts_at' => now(),
                    'expires_at' => now()->addDays(60),
                ]
            );
        }

        // Seed Customer Wedding
        \App\Models\Wedding::updateOrCreate(
            ['user_id' => $customerUser->id],
            [
                'slug' => 'rath-sreyneang-wedding',
                'groom_name' => 'ជា រដ្ឋា (Ratha)',
                'bride_name' => 'សុខ ស្រីនាង (Sreyneang)',
                'groom_parents' => 'លោក ជា ធារ៉ា & លោកស្រី អ៊ុក សុផល',
                'bride_parents' => 'លោក សុខ ចាន់ & លោកស្រី មាស គឹមស៊ាង',
                'event_date' => now()->addDays(30),
                'venue_name' => 'មជ្ឈមណ្ឌលសិរីមង្គល អាគារ B',
                'venue_address' => 'មហាវិថីព្រះនរោត្តម រាជធានីភ្នំពេញ',
                'venue_location_url' => 'https://maps.google.com',
                'theme_template' => 'married',
                'is_published' => true,
            ]
        );

        // 3. Seed Sample Wedding Guests
        $sampleGuests = [
            [
                'name' => 'សម្លាញ់ ធាសុធី',
                'phone' => '012 345 678',
                'side' => 'groom',
                'table_number' => '01',
                'attendance' => 'attending',
                'companions' => 2,
                'wishes' => 'សូមជូនពរឱ្យស្រឡាញ់គ្នាដល់ចាស់ព្រឹទ្ធចាស់ព្រេង មានសុភមង្គលរហូត!',
                'gift_amount' => '$100',
                'invitation_code' => 'INV-G001',
                'note' => 'មិត្តភក្តិកូនប្រុស',
            ],
            [
                'name' => 'លោក ហេង សម្បត្តិ & ភរិយា',
                'phone' => '015 888 999',
                'side' => 'groom',
                'table_number' => '02',
                'attendance' => 'attending',
                'companions' => 2,
                'wishes' => 'សូមឱ្យអាពាហ៍ពិពាហ៍នេះពោរពេញដោយស្នាមញញឹម និងសិរីសួស្តី!',
                'gift_amount' => '$50',
                'invitation_code' => 'INV-G002',
                'note' => 'ភ្ញៀវកិត្តិយសខាងប្រុស',
            ],
            [
                'name' => 'លោកស្រី ចាន់ ធារី',
                'phone' => '097 777 666',
                'side' => 'bride',
                'table_number' => '05',
                'attendance' => 'attending',
                'companions' => 1,
                'wishes' => 'សូមជូនពរកូនប្រុសកូនស្រីជួបតែសេចក្តីសុខ និងសំណាងល្អ!',
                'gift_amount' => '$80',
                'invitation_code' => 'INV-B001',
                'note' => 'ភ្ញៀវកិត្តិយសខាងស្រី',
            ],
            [
                'name' => 'អ្នកនាង សុខ ស្រីពេជ្រ',
                'phone' => '088 123 444',
                'side' => 'bride',
                'table_number' => '06',
                'attendance' => 'pending',
                'companions' => 1,
                'wishes' => null,
                'gift_amount' => null,
                'invitation_code' => 'INV-B002',
                'note' => 'មិត្តភក្តិកូនស្រី',
            ],
            [
                'name' => 'លោក គឹម សុផល',
                'phone' => '077 999 111',
                'side' => 'both',
                'table_number' => '08',
                'attendance' => 'declined',
                'companions' => 1,
                'wishes' => null,
                'gift_amount' => null,
                'invitation_code' => 'INV-C001',
                'note' => 'រវល់ធុរៈមិនបានចូលរួម',
            ],
        ];

        foreach ($sampleGuests as $guestData) {
            Guest::updateOrCreate(
                ['invitation_code' => $guestData['invitation_code']],
                $guestData
            );
        }

        // 4. Seed Modules & Pages
        $dashModule = \App\Models\Module::updateOrCreate(
            ['name' => 'Dashboard'],
            ['name_kh' => 'ផ្ទាំងគ្រប់គ្រង', 'icon' => 'fa-home', 'sort_order' => 1, 'status' => 'active']
        );
        \App\Models\Page::updateOrCreate(
            ['route_name' => 'admin.dashboard'],
            [
                'module_id' => $dashModule->id,
                'name' => 'Dashboard Page',
                'name_kh' => 'ទំព័រដើម',
                'url_path' => '/admin/dashboard',
                'icon' => 'fa-home',
                'sort_order' => 1,
                'status' => 'active'
            ]
        );

        $guestModule = \App\Models\Module::updateOrCreate(
            ['name' => 'Guest Management'],
            ['name_kh' => 'គ្រប់គ្រងភ្ញៀវ', 'icon' => 'fa-address-book', 'sort_order' => 2, 'status' => 'active']
        );
        \App\Models\Page::updateOrCreate(
            ['route_name' => 'admin.guests.index'],
            [
                'module_id' => $guestModule->id,
                'name' => 'Guest List',
                'name_kh' => 'បញ្ជីភ្ញៀវ',
                'url_path' => '/admin/guests',
                'icon' => 'fa-address-book',
                'sort_order' => 1,
                'status' => 'active'
            ]
        );

        $userModule = \App\Models\Module::updateOrCreate(
            ['name' => 'User Management'],
            ['name_kh' => 'គ្រប់គ្រងអ្នកប្រើប្រាស់', 'icon' => 'fa-users-cog', 'sort_order' => 3, 'status' => 'active']
        );
        \App\Models\Page::updateOrCreate(
            ['route_name' => 'admin.users.index'],
            [
                'module_id' => $userModule->id,
                'name' => 'Users List',
                'name_kh' => 'បញ្ជីអ្នកប្រើប្រាស់',
                'url_path' => '/admin/users',
                'icon' => 'fa-users-cog',
                'sort_order' => 1,
                'status' => 'active'
            ]
        );

        $systemModule = \App\Models\Module::updateOrCreate(
            ['name' => 'Role & Menu Settings'],
            ['name_kh' => 'ការកំណត់ម៉ឺនុយ និងសិទ្ធិ', 'icon' => 'fa-sliders-h', 'sort_order' => 4, 'status' => 'active']
        );
        $rolePage = \App\Models\Page::updateOrCreate(
            ['route_name' => 'admin.roles.index'],
            [
                'module_id' => $systemModule->id,
                'name' => 'User Roles',
                'name_kh' => 'តួនាទីអ្នកប្រើប្រាស់',
                'url_path' => '/admin/roles',
                'icon' => 'fa-user-shield',
                'sort_order' => 1,
                'status' => 'active'
            ]
        );
        $menuSettingPage = \App\Models\Page::updateOrCreate(
            ['route_name' => 'admin.menu-settings.index'],
            [
                'module_id' => $systemModule->id,
                'name' => 'Role & Menu Setting',
                'name_kh' => 'ការកំណត់ម៉ឺនុយ និងសិទ្ធិ',
                'url_path' => '/admin/menu-settings',
                'icon' => 'fa-sliders-h',
                'sort_order' => 2,
                'status' => 'active'
            ]
        );

        // 5. Seed Role Page Access
        $allPages = \App\Models\Page::all();
        foreach ($allPages as $p) {
            \App\Models\RolePageAccess::updateOrCreate(
                ['role_id' => $adminRole->id, 'page_id' => $p->id],
                ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true]
            );
            \App\Models\RolePageAccess::updateOrCreate(
                ['role_id' => $managerRole->id, 'page_id' => $p->id],
                ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false]
            );
        }

        $this->call(PageActionSeeder::class);
    }
}
