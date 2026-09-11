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
        // 1. Ensure Modules exist
        $mDashboard = Module::firstOrCreate(
            ['name' => 'Dashboard'],
            ['name_kh' => 'ផ្ទាំងគ្រប់គ្រង', 'icon' => 'fa-home', 'sort_order' => 1, 'status' => 'active']
        );

        $mGuest = Module::firstOrCreate(
            ['name' => 'Guest Management'],
            ['name_kh' => 'គ្រប់គ្រងភ្ញៀវ', 'icon' => 'fa-address-book', 'sort_order' => 2, 'status' => 'active']
        );

        $mUser = Module::firstOrCreate(
            ['name' => 'User Management'],
            ['name_kh' => 'គ្រប់គ្រងអ្នកប្រើប្រាស់', 'icon' => 'fa-users-cog', 'sort_order' => 3, 'status' => 'active']
        );

        $mRoleMenu = Module::firstOrCreate(
            ['name' => 'Role & Menu Settings'],
            ['name_kh' => 'តួនាទី & ម៉ូឌុល', 'icon' => 'fa-sliders-h', 'sort_order' => 4, 'status' => 'active']
        );

        $mPlans = Module::firstOrCreate(
            ['name' => 'Plans & Subscriptions'],
            ['name_kh' => 'កញ្ចប់សេវា & ការជាវ', 'icon' => 'fa-tags', 'sort_order' => 5, 'status' => 'active']
        );

        $mCustomer = Module::firstOrCreate(
            ['name' => 'Customer Portal'],
            ['name_kh' => 'ផ្ទាំងគ្រប់គ្រងអតិថិជន', 'icon' => 'fa-user-circle', 'sort_order' => 6, 'status' => 'active']
        );

        // 2. Map Pages and Actions
        $pagesData = [
            [
                'module_id' => $mGuest->id,
                'name' => 'Guest List',
                'name_kh' => 'បញ្ជីភ្ញៀវ',
                'route_name' => 'admin.guests.index',
                'url_path' => '/admin/guests',
                'icon' => 'fa-address-book',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.guests.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.guests.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mUser->id,
                'name' => 'Users List',
                'name_kh' => 'បញ្ជីអ្នកប្រើប្រាស់',
                'route_name' => 'admin.users.index',
                'url_path' => '/admin/users',
                'icon' => 'fa-users-cog',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.users.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.users.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'User Roles',
                'name_kh' => 'តួនាទី',
                'route_name' => 'admin.roles.index',
                'url_path' => '/admin/roles',
                'icon' => 'fa-user-shield',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.roles.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.roles.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Modules Setup',
                'name_kh' => 'ការកំណត់ម៉ូឌុល',
                'route_name' => 'admin.menu-settings.modules.index',
                'url_path' => '/admin/menu-settings/modules',
                'icon' => 'fa-cubes',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.menu-settings.modules.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.menu-settings.modules.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Pages Setup',
                'name_kh' => 'ការកំណត់ទំព័រ',
                'route_name' => 'admin.menu-settings.pages.index',
                'url_path' => '/admin/menu-settings/pages',
                'icon' => 'fa-file-contract',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.menu-settings.pages.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.menu-settings.pages.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mRoleMenu->id,
                'name' => 'Role & Menu Settings',
                'name_kh' => 'ការកំណត់សិទ្ធិ & ម៉ូឌុល',
                'route_name' => 'admin.menu-settings.roles.index',
                'url_path' => '/admin/menu-settings/roles',
                'icon' => 'fa-shield-alt',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.roles.edit', 'type' => 'edit', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.roles.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mPlans->id,
                'name' => 'Subscription Plans',
                'name_kh' => 'កញ្ចប់សេវាកម្ម',
                'route_name' => 'admin.plans.index',
                'url_path' => '/admin/plans',
                'icon' => 'fa-tags',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'admin.plans.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'admin.plans.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
            [
                'module_id' => $mCustomer->id,
                'name' => 'Customer Guest List',
                'name_kh' => 'បញ្ជីភ្ញៀវអតិថិជន',
                'route_name' => 'customer.guests.index',
                'url_path' => '/customer/guests',
                'icon' => 'fa-address-book',
                'actions' => [
                    ['name' => 'Edit', 'name_kh' => 'កែប្រែ', 'route_name' => 'customer.guests.update', 'type' => 'edit_modal', 'position' => 'action', 'icon' => 'fas fa-pen-nib', 'order' => 1],
                    ['name' => 'Delete', 'name_kh' => 'លុប', 'route_name' => 'customer.guests.destroy', 'type' => 'destroy', 'position' => 'action', 'icon' => 'far fa-trash-alt', 'order' => 2],
                ],
            ],
        ];

        foreach ($pagesData as $pData) {
            $actions = $pData['actions'] ?? [];
            unset($pData['actions']);

            $page = Page::updateOrCreate(
                ['route_name' => $pData['route_name']],
                $pData
            );

            foreach ($actions as $actData) {
                PageAction::updateOrCreate(
                    ['page_id' => $page->id, 'type' => $actData['type'], 'name' => $actData['name']],
                    array_merge($actData, ['page_id' => $page->id])
                );
            }
        }
    }
}
