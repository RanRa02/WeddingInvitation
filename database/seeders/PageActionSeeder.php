<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Page;
use App\Models\PageAction;
use Illuminate\Database\Seeder;

class PageActionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clean up obsolete module records if any
        Module::whereNotIn('name', ['Role & Menu Settings'])->delete();

        // 2. Ensure sole primary Module exists
        $mRoleMenu = Module::updateOrCreate(
            ['name' => 'Role & Menu Settings'],
            ['name_kh' => 'ការកំណត់ម៉ឺនុយ និងសិទ្ធិ', 'icon' => 'fa-cog', 'sort_order' => 1, 'status' => 'active']
        );

        // 3. Active Pages and Page Actions mapping
        $pagesData = [
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Dashboard',
                'name_kh' => 'ផ្ទាំងគ្រប់គ្រង',
                'route_name' => 'admin.dashboard',
                'url_path' => '/admin/dashboard',
                'icon' => 'fa-th-large',
                'sort_order' => 1,
                'status' => 'active',
                'actions' => [],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Guest Management',
                'name_kh' => 'គ្រប់គ្រងភ្ញៀវ',
                'route_name' => 'admin.guests.index',
                'url_path' => '/admin/guests',
                'icon' => 'fa-folder-open',
                'sort_order' => 2,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.guests.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.guests.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'User Management',
                'name_kh' => 'គ្រប់គ្រងអ្នកប្រើប្រាស់',
                'route_name' => 'admin.users.index',
                'url_path' => '/admin/users',
                'icon' => 'fa-user',
                'sort_order' => 3,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.users.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.users.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Plans & Subscriptions',
                'name_kh' => 'គ្រប់គ្រងកញ្ចប់សេវា',
                'route_name' => 'admin.plans.index',
                'url_path' => '/admin/plans',
                'icon' => 'fa-tags',
                'sort_order' => 4,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.plans.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.plans.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Modules Setup',
                'name_kh' => 'កំណត់ម៉ូដ្យួល',
                'route_name' => 'admin.menu-settings.modules.index',
                'url_path' => '/admin/menu-settings/modules',
                'icon' => 'fa-folder-plus',
                'sort_order' => 5,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.menu-settings.modules.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.menu-settings.modules.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Pages Setup',
                'name_kh' => 'កំណត់ទំព័រ',
                'route_name' => 'admin.menu-settings.pages.index',
                'url_path' => '/admin/menu-settings/pages',
                'icon' => 'fa-file-contract',
                'sort_order' => 6,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.menu-settings.pages.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.menu-settings.pages.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Roles Setup',
                'name_kh' => 'កំណត់តួនាទី',
                'route_name' => 'admin.menu-settings.roles.index',
                'url_path' => '/admin/menu-settings/roles',
                'icon' => 'fa-user-shield',
                'sort_order' => 7,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.roles.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.roles.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Customer Guest List',
                'name_kh' => 'បញ្ជីភ្ញៀវអតិថិជន',
                'route_name' => 'customer.guests.index',
                'url_path' => '/customer/guests',
                'icon' => 'fa-address-book',
                'sort_order' => 8,
                'status' => 'active',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'customer.guests.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'customer.guests.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
        ];

        // Delete pages that are not in active pages list
        $activeRoutes = array_column($pagesData, 'route_name');
        Page::whereNotIn('route_name', $activeRoutes)->delete();

        foreach ($pagesData as $pData) {
            $actions = $pData['actions'] ?? [];
            unset($pData['actions']);

            $page = Page::updateOrCreate(
                ['route_name' => $pData['route_name']],
                $pData
            );

            // Clean up actions not in list for this page
            $activeTypes = array_column($actions, 'type');
            PageAction::where('page_id', $page->id)->whereNotIn('type', $activeTypes)->delete();

            foreach ($actions as $actData) {
                PageAction::updateOrCreate(
                    ['page_id' => $page->id, 'type' => $actData['type']],
                    array_merge($actData, ['page_id' => $page->id])
                );
            }
        }
    }
}
