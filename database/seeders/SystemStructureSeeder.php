<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\SubModule;
use App\Models\Page;
use App\Models\PageAction;
use App\Models\Role;
use App\Models\RolePageAccess;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemStructureSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Modules
            $settingModule = Module::updateOrCreate(
                ['name' => 'Role & Menu Settings'],
                ['name_kh' => 'ការកំណត់ម៉ឺនុយ និងសិទ្ធិ', 'icon' => 'fa-cog', 'sort_order' => 1, 'status' => 'active']
            );

            // Sub-Modules
            $userMgmtSub = SubModule::updateOrCreate(
                ['module_id' => $settingModule->id, 'name' => 'User Management'],
                ['name_kh' => 'កំណត់ការប្រើប្រាស់', 'icon' => 'fa-user-shield', 'sort_order' => 1, 'status' => 'active']
            );

            $menuSetupSub = SubModule::updateOrCreate(
                ['module_id' => $settingModule->id, 'name' => 'Menu & Structure Setup'],
                ['name_kh' => 'កំណត់រចនាសម្ព័ន្ធមឺនុយ', 'icon' => 'fa-sitemap', 'sort_order' => 2, 'status' => 'active']
            );

            // Pages
            $rolesPage = Page::updateOrCreate(
                ['name' => 'Roles Setup'],
                [
                    'module_id' => $settingModule->id,
                    'sub_module_id' => $userMgmtSub->id,
                    'name_kh' => 'កំណត់ក្រុមអ្នកប្រើប្រាស់',
                    'route_name' => 'admin.roles.index',
                    'url_path' => '/admin/roles',
                    'icon' => 'fa-user-tag',
                    'sort_order' => 1,
                    'status' => 'active'
                ]
            );

            $usersPage = Page::updateOrCreate(
                ['name' => 'Users Setup'],
                [
                    'module_id' => $settingModule->id,
                    'sub_module_id' => $userMgmtSub->id,
                    'name_kh' => 'កំណត់អ្នកប្រើប្រាស់',
                    'route_name' => 'admin.users.index',
                    'url_path' => '/admin/users',
                    'icon' => 'fa-user',
                    'sort_order' => 2,
                    'status' => 'active'
                ]
            );

            $modulesPage = Page::updateOrCreate(
                ['name' => 'Modules Setup'],
                [
                    'module_id' => $settingModule->id,
                    'sub_module_id' => $menuSetupSub->id,
                    'name_kh' => 'កំណត់ម៉ូដ្យួល',
                    'route_name' => 'admin.menu-settings.modules.index',
                    'url_path' => '/admin/menu-settings/modules',
                    'icon' => 'fa-cubes',
                    'sort_order' => 1,
                    'status' => 'active'
                ]
            );

            $subModulesPage = Page::updateOrCreate(
                ['name' => 'Sub-Modules Setup'],
                [
                    'module_id' => $settingModule->id,
                    'sub_module_id' => $menuSetupSub->id,
                    'name_kh' => 'កំណត់ម៉ូដ្យួលបន្ទាប់',
                    'route_name' => 'admin.menu-settings.sub-modules.index',
                    'url_path' => '/admin/menu-settings/sub-modules',
                    'icon' => 'fa-folder-open',
                    'sort_order' => 2,
                    'status' => 'active'
                ]
            );

            $pagesPage = Page::updateOrCreate(
                ['name' => 'Pages Setup'],
                [
                    'module_id' => $settingModule->id,
                    'sub_module_id' => $menuSetupSub->id,
                    'name_kh' => 'កំណត់ទំព័រ',
                    'route_name' => 'admin.menu-settings.pages.index',
                    'url_path' => '/admin/menu-settings/pages',
                    'icon' => 'fa-file-alt',
                    'sort_order' => 3,
                    'status' => 'active'
                ]
            );

            $pageActionsPage = Page::updateOrCreate(
                ['name' => 'Page Actions Setup'],
                [
                    'module_id' => $settingModule->id,
                    'sub_module_id' => $menuSetupSub->id,
                    'name_kh' => 'កំណត់សកម្មភាពទំព័រ',
                    'route_name' => 'admin.menu-settings.page-actions.index',
                    'url_path' => '/admin/menu-settings/page-actions',
                    'icon' => 'fa-bolt',
                    'sort_order' => 4,
                    'status' => 'active'
                ]
            );

            $guestModule = Module::updateOrCreate(
                ['name' => 'Guest Management'],
                ['name_kh' => 'គ្រប់គ្រងភ្ញៀវ', 'icon' => 'fa-id-card', 'sort_order' => 2, 'status' => 'active']
            );

            $guestsPage = Page::updateOrCreate(
                ['name' => 'Guest List'],
                [
                    'module_id' => $guestModule->id,
                    'sub_module_id' => null,
                    'name_kh' => 'បញ្ជីភ្ញៀវ',
                    'route_name' => 'admin.guests.index',
                    'url_path' => '/admin/guests',
                    'icon' => 'fa-id-card',
                    'sort_order' => 1,
                    'status' => 'active'
                ]
            );

            // Default Page Actions for all pages
            $pagesList = Page::all();
            $standardActions = [
                ['name' => 'Index', 'name_kh' => 'បញ្ជី', 'type' => 'index', 'position' => 'action', 'icon' => 'fa-list'],
                ['name' => 'Create', 'name_kh' => 'បង្កើត', 'type' => 'create', 'position' => 'top', 'icon' => 'fa-plus'],
                ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'type' => 'edit', 'position' => 'action', 'icon' => 'fa-edit'],
                ['name' => 'Delete', 'name_kh' => 'លុប', 'type' => 'destroy', 'position' => 'action', 'icon' => 'fa-trash'],
                ['name' => 'Export', 'name_kh' => 'នាំចេញ', 'type' => 'export', 'position' => 'other', 'icon' => 'fa-download'],
                ['name' => 'Import', 'name_kh' => 'នាំចូល', 'type' => 'import', 'position' => 'import', 'icon' => 'fa-upload'],
            ];

            foreach ($pagesList as $p) {
                foreach ($standardActions as $act) {
                    PageAction::updateOrCreate(
                        ['page_id' => $p->id, 'type' => $act['type']],
                        [
                            'name' => $act['name'],
                            'name_kh' => $act['name_kh'],
                            'route_name' => $p->route_name ? str_replace('.index', '.' . $act['type'], $p->route_name) : null,
                            'position' => $act['position'],
                            'icon' => $act['icon'],
                            'order' => 1,
                        ]
                    );
                }
            }

            // Ensure Admin role has full access
            $adminRole = Role::where('slug', 'admin')->first();
            if ($adminRole) {
                foreach ($pagesList as $p) {
                    RolePageAccess::updateOrCreate(
                        ['role_id' => $adminRole->id, 'page_id' => $p->id],
                        ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true]
                    );
                }
            }
        });
    }
}
