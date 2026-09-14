<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\SubModule;
use App\Models\Page;
use App\Models\PageAction;
use App\Models\Role;
use App\Models\RolePageAccess;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ModuleImport;
use App\Imports\SubModuleImport;
use App\Imports\PageImport;
use App\Imports\PageActionImport;

use App\DataTables\Setup\ModuleDatatable;
use App\DataTables\Setup\SubModuleDatatable;
use App\DataTables\Setup\PageDatatable;
use App\DataTables\Setup\PageActionDatatable;
use App\DataTables\Setup\RoleDatatable;

class MenuSettingController extends Controller
{
    /**
     * Default redirect to Modules setup page
     */
    public function index()
    {
        return redirect()->route('admin.menu-settings.modules.index');
    }

    /**
     * Dedicated Modules Setup Page
     */
    public function modulesIndex(ModuleDatatable $dataTable)
    {
        $modules = Module::with(['subModules', 'pages'])->orderBy('sort_order', 'asc')->get();
        $subModulesCount = SubModule::count();
        $pagesCount = Page::count();
        $pageActionsCount = PageAction::count();
        $rolesCount = Role::count();

        return $dataTable->render('admin.menu_settings.modules', compact('modules', 'subModulesCount', 'pagesCount', 'pageActionsCount', 'rolesCount'));
    }

    /**
     * Dedicated Sub-Modules Setup Page
     */
    public function subModulesIndex(SubModuleDatatable $dataTable)
    {
        $modules = Module::orderBy('sort_order', 'asc')->get();
        $subModules = SubModule::with('module')->orderBy('module_id', 'asc')->orderBy('sort_order', 'asc')->get();
        $pagesCount = Page::count();
        $rolesCount = Role::count();

        return $dataTable->render('admin.menu_settings.sub_modules', compact('modules', 'subModules', 'pagesCount', 'rolesCount'));
    }

    /**
     * Dedicated Pages Setup Page
     */
    public function pagesIndex(PageDatatable $dataTable)
    {
        $modules = Module::orderBy('sort_order', 'asc')->get();
        $subModules = SubModule::orderBy('sort_order', 'asc')->get();
        $pages = Page::with(['module', 'subModule'])->orderBy('module_id', 'asc')->orderBy('sort_order', 'asc')->get();
        $rolesCount = Role::count();

        return $dataTable->render('admin.menu_settings.pages', compact('modules', 'subModules', 'pages', 'rolesCount'));
    }

    /**
     * Dedicated Page Actions Setup Page
     */
    public function pageActionsIndex(PageActionDatatable $dataTable)
    {
        $pages = Page::orderBy('sort_order', 'asc')->get();
        $pageActions = PageAction::with('page')->orderBy('page_id', 'asc')->orderBy('order', 'asc')->get();
        $rolesCount = Role::count();

        return $dataTable->render('admin.menu_settings.page_actions', compact('pages', 'pageActions', 'rolesCount'));
    }

    /**
     * Dedicated Roles Setup Page (Permissions Matrix)
     */
    public function rolesIndex(RoleDatatable $dataTable)
    {
        $modules = Module::with(['subModules.pages', 'pages'])->orderBy('sort_order', 'asc')->get();
        $pages = Page::with(['module', 'subModule'])->orderBy('module_id', 'asc')->orderBy('sort_order', 'asc')->get();
        $roles = Role::withCount('users')->orderBy('id', 'asc')->get();
        $roleAccess = RolePageAccess::all()->groupBy('role_id');
        $pagesCount = Page::count();

        return $dataTable->render('admin.menu_settings.roles', compact('modules', 'pages', 'roles', 'roleAccess', 'pagesCount'));
    }

    /**
     * Store a newly created Module
     */
    public function storeModule(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? Module::max('sort_order') + 1;

        Module::create($validated);

        return redirect()->route('admin.menu-settings.modules.index')->with('success', __('app.module_created_successfully'));
    }

    /**
     * Update specified Module
     */
    public function updateModule(Request $request, Module $module)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $module->update($validated);

        return redirect()->route('admin.menu-settings.modules.index')->with('success', __('app.module_updated_successfully'));
    }

    /**
     * Delete specified Module
     */
    public function destroyModule(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.menu-settings.modules.index')->with('success', __('app.module_deleted_successfully'));
    }

    /**
     * Store Sub-Module
     */
    public function storeSubModule(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? SubModule::where('module_id', $validated['module_id'])->max('sort_order') + 1;

        SubModule::create($validated);

        return redirect()->route('admin.menu-settings.sub-modules.index')->with('success', __('app.sub_module_created_successfully'));
    }

    /**
     * Update Sub-Module
     */
    public function updateSubModule(Request $request, SubModule $subModule)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $subModule->update($validated);

        return redirect()->route('admin.menu-settings.sub-modules.index')->with('success', __('app.sub_module_updated_successfully'));
    }

    /**
     * Delete Sub-Module
     */
    public function destroySubModule(SubModule $subModule)
    {
        $subModule->delete();
        return redirect()->route('admin.menu-settings.sub-modules.index')->with('success', __('app.sub_module_deleted_successfully'));
    }

    /**
     * Store Page
     */
    public function storePage(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'nullable|exists:modules,id',
            'sub_module_id' => 'nullable|exists:sub_modules,id',
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'url_path' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? Page::max('sort_order') + 1;

        $page = Page::create($validated);

        // Auto grant full permission to Admin role
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            RolePageAccess::updateOrCreate(
                ['role_id' => $adminRole->id, 'page_id' => $page->id],
                ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true]
            );
        }

        return redirect()->route('admin.menu-settings.pages.index')->with('success', __('app.page_created_successfully'));
    }

    /**
     * Update Page
     */
    public function updatePage(Request $request, Page $page)
    {
        $validated = $request->validate([
            'module_id' => 'nullable|exists:modules,id',
            'sub_module_id' => 'nullable|exists:sub_modules,id',
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'url_path' => 'nullable|string|max:255',
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $page->update($validated);

        return redirect()->route('admin.menu-settings.pages.index')->with('success', __('app.page_updated_successfully'));
    }

    /**
     * Delete Page
     */
    public function destroyPage(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.menu-settings.pages.index')->with('success', __('app.page_deleted_successfully'));
    }

    /**
     * Store Page Action
     */
    public function storePageAction(Request $request)
    {
        $validated = $request->validate([
            'page_id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'name_ch' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'type' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? PageAction::where('page_id', $validated['page_id'])->max('order') + 1;

        PageAction::create($validated);

        return redirect()->route('admin.menu-settings.page-actions.index')->with('success', __('app.page_action_created_successfully'));
    }

    /**
     * Update Page Action
     */
    public function updatePageAction(Request $request, PageAction $pageAction)
    {
        $validated = $request->validate([
            'page_id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'name_ch' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'type' => 'required|string|max:50',
            'position' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $pageAction->update($validated);

        return redirect()->route('admin.menu-settings.page-actions.index')->with('success', __('app.page_action_updated_successfully'));
    }

    /**
     * Delete Page Action
     */
    public function destroyPageAction(PageAction $pageAction)
    {
        $pageAction->delete();
        return redirect()->route('admin.menu-settings.page-actions.index')->with('success', __('app.page_action_deleted_successfully'));
    }

    /**
     * Save Role Access Matrix
     */
    public function saveRoleAccess(Request $request)
    {
        $accessData = $request->input('access', []);
        $roles = Role::all();
        $pages = Page::all();

        foreach ($roles as $role) {
            foreach ($pages as $page) {
                $roleId = $role->id;
                $pageId = $page->id;

                $canView = isset($accessData[$roleId][$pageId]['can_view']);
                $canCreate = isset($accessData[$roleId][$pageId]['can_create']);
                $canEdit = isset($accessData[$roleId][$pageId]['can_edit']);
                $canDelete = isset($accessData[$roleId][$pageId]['can_delete']);

                RolePageAccess::updateOrCreate(
                    ['role_id' => $roleId, 'page_id' => $pageId],
                    [
                        'can_view' => $canView,
                        'can_create' => $canCreate,
                        'can_edit' => $canEdit,
                        'can_delete' => $canDelete,
                    ]
                );
            }
        }

        return redirect()->route('admin.menu-settings.roles.index')->with('success', __('app.role_access_updated_successfully'));
    }

    // ==========================================
    // EXPORT & TEMPLATE DOWNLOADING METHODS
    // ==========================================

    public function downloadModuleTemplate()
    {
        $csvContent = "no,name,name_kh,icon,sort_order,status\n";
        $csvContent .= "1,User Management,កំណត់ការប្រើប្រាស់,fa-users,1,active\n";
        $csvContent .= "2,Settings,កំណត់,fa-cog,2,active\n";

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="modules_import_template.csv"',
        ]);
    }

    public function downloadSubModuleTemplate()
    {
        $csvContent = "no,module_name,name,name_kh,icon,sort_order,status\n";
        $csvContent .= "1,Settings,User Setup,កំណត់អ្នកប្រើប្រាស់,fa-user-cog,1,active\n";

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sub_modules_import_template.csv"',
        ]);
    }

    public function downloadPageTemplate()
    {
        $csvContent = "no,name,name_kh,module_name,sub_module_name,route_name,url_path,icon,sort_order,status\n";
        $csvContent .= "1,Users Setup,កំណត់អ្នកប្រើប្រាស់,Settings,User Setup,admin.users.index,/admin/users,fa-user,1,active\n";

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pages_import_template.csv"',
        ]);
    }

    public function downloadPageActionTemplate()
    {
        $csvContent = "no,page_name,name,name_kh,name_ch,route_name,type,position,icon,order\n";
        $csvContent .= "1,Users Setup,Create User,បង្កើតអ្នកប្រើប្រាស់,创建,admin.users.create,create,top,fa-plus,1\n";

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="page_actions_import_template.csv"',
        ]);
    }

    /**
     * Download Complete System Structure JSON Package
     */
    public function exportSystemJson()
    {
        $modules = Module::with(['subModules.pages.pageActions', 'pages.pageActions'])->orderBy('sort_order', 'asc')->get();

        $dataPackage = [
            'exported_at' => now()->toIso8601String(),
            'app' => config('app.name'),
            'modules' => $modules
        ];

        $jsonString = json_encode($dataPackage, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return response($jsonString, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="system_menu_structure_'.date('Ymd_His').'.json"',
        ]);
    }

    /**
     * Import System JSON Package
     */
    public function importSystemJson(Request $request)
    {
        $request->validate(['file' => 'required|file']);

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if (!$data || !isset($data['modules'])) {
            return redirect()->back()->with('error', 'Invalid JSON package file format.');
        }

        DB::transaction(function () use ($data) {
            foreach ($data['modules'] as $modData) {
                $module = Module::updateOrCreate(
                    ['name' => $modData['name']],
                    [
                        'name_kh' => $modData['name_kh'] ?? null,
                        'icon' => $modData['icon'] ?? 'fa-folder',
                        'sort_order' => $modData['sort_order'] ?? 0,
                        'status' => $modData['status'] ?? 'active',
                    ]
                );

                if (!empty($modData['sub_modules'])) {
                    foreach ($modData['sub_modules'] as $subData) {
                        $subModule = SubModule::updateOrCreate(
                            ['module_id' => $module->id, 'name' => $subData['name']],
                            [
                                'name_kh' => $subData['name_kh'] ?? null,
                                'icon' => $subData['icon'] ?? 'fa-folder-open',
                                'sort_order' => $subData['sort_order'] ?? 0,
                                'status' => $subData['status'] ?? 'active',
                            ]
                        );

                        if (!empty($subData['pages'])) {
                            foreach ($subData['pages'] as $pageData) {
                                $page = Page::updateOrCreate(
                                    ['name' => $pageData['name']],
                                    [
                                        'module_id' => $module->id,
                                        'sub_module_id' => $subModule->id,
                                        'name_kh' => $pageData['name_kh'] ?? null,
                                        'route_name' => $pageData['route_name'] ?? null,
                                        'url_path' => $pageData['url_path'] ?? null,
                                        'icon' => $pageData['icon'] ?? 'fa-file-alt',
                                        'sort_order' => $pageData['sort_order'] ?? 0,
                                        'status' => $pageData['status'] ?? 'active',
                                    ]
                                );

                                if (!empty($pageData['page_actions'])) {
                                    foreach ($pageData['page_actions'] as $actData) {
                                        PageAction::updateOrCreate(
                                            ['page_id' => $page->id, 'name' => $actData['name']],
                                            [
                                                'name_kh' => $actData['name_kh'] ?? null,
                                                'name_ch' => $actData['name_ch'] ?? null,
                                                'route_name' => $actData['route_name'] ?? null,
                                                'type' => $actData['type'] ?? 'action',
                                                'position' => $actData['position'] ?? 'action',
                                                'icon' => $actData['icon'] ?? null,
                                                'order' => $actData['order'] ?? 0,
                                            ]
                                        );
                                    }
                                }
                            }
                        }
                    }
                }

                if (!empty($modData['pages'])) {
                    foreach ($modData['pages'] as $pageData) {
                        $page = Page::updateOrCreate(
                            ['name' => $pageData['name']],
                            [
                                'module_id' => $module->id,
                                'sub_module_id' => $pageData['sub_module_id'] ?? null,
                                'name_kh' => $pageData['name_kh'] ?? null,
                                'route_name' => $pageData['route_name'] ?? null,
                                'url_path' => $pageData['url_path'] ?? null,
                                'icon' => $pageData['icon'] ?? 'fa-file-alt',
                                'sort_order' => $pageData['sort_order'] ?? 0,
                                'status' => $pageData['status'] ?? 'active',
                            ]
                        );

                        if (!empty($pageData['page_actions'])) {
                            foreach ($pageData['page_actions'] as $actData) {
                                PageAction::updateOrCreate(
                                    ['page_id' => $page->id, 'name' => $actData['name']],
                                    [
                                        'name_kh' => $actData['name_kh'] ?? null,
                                        'name_ch' => $actData['name_ch'] ?? null,
                                        'route_name' => $actData['route_name'] ?? null,
                                        'type' => $actData['type'] ?? 'action',
                                        'position' => $actData['position'] ?? 'action',
                                        'icon' => $actData['icon'] ?? null,
                                        'order' => $actData['order'] ?? 0,
                                    ]
                                );
                            }
                        }
                    }
                }
            }
        });

        return redirect()->back()->with('success', __('app.system_structure_imported_successfully'));
    }

    public function importModules(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        $import = new ModuleImport();
        Excel::import($import, $request->file('file'));

        if ($import->getStatus() == 500) {
            return redirect()->back()->with('error', $import->getMessage());
        }

        return redirect()->back()->with('success', $import->getMessage());
    }

    public function importSubModules(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        $import = new SubModuleImport();
        Excel::import($import, $request->file('file'));

        if ($import->getStatus() == 500) {
            return redirect()->back()->with('error', $import->getMessage());
        }

        return redirect()->back()->with('success', $import->getMessage());
    }

    public function importPages(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        $import = new PageImport();
        Excel::import($import, $request->file('file'));

        if ($import->getStatus() == 500) {
            return redirect()->back()->with('error', $import->getMessage());
        }

        return redirect()->back()->with('success', $import->getMessage());
    }

    public function importPageActions(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        $import = new PageActionImport();
        Excel::import($import, $request->file('file'));

        if ($import->getStatus() == 500) {
            return redirect()->back()->with('error', $import->getMessage());
        }

        return redirect()->back()->with('success', $import->getMessage());
    }

    /**
     * AJAX Getter methods following wis-hr conventions
     */
    public function getModules(Request $request)
    {
        $modules = Module::select('id', 'name as text', 'name', 'name_kh', 'icon')->orderBy('sort_order', 'asc')->get();
        return response()->json($modules);
    }

    public function getByModuleId(Request $request)
    {
        $subModules = SubModule::select('id', 'name as text', 'name', 'name_kh', 'module_id')
            ->where('module_id', $request->module_id)
            ->orderBy('sort_order', 'asc')
            ->get();
        return response()->json($subModules);
    }

    public function getPagesByModuleId(Request $request)
    {
        $query = Page::select('id', 'name as text', 'name', 'name_kh', 'module_id', 'sub_module_id');
        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }
        if ($request->filled('sub_module_id')) {
            $query->where('sub_module_id', $request->sub_module_id);
        }
        $pages = $query->orderBy('sort_order', 'asc')->get();
        return response()->json($pages);
    }

    public function getPageActionsByPageId(Request $request)
    {
        $pageActions = PageAction::select('id', 'name as text', 'name', 'name_kh', 'page_id', 'type', 'position', 'route_name')
            ->where('page_id', $request->page_id)
            ->orderBy('order', 'asc')
            ->get();
        return response()->json($pageActions);
    }
}
