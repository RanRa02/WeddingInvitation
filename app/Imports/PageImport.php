<?php

namespace App\Imports;

use App\Models\Module;
use App\Models\SubModule;
use App\Models\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class PageImport implements ToCollection
{
    private $status;
    private $message;

    public function collection(Collection $rows)
    {
        if (isset($rows[0]) && !$this->validateHeader($rows[0])) {
            return;
        }

        try {
            DB::transaction(function () use ($rows) {
                $modules = Module::pluck('id', 'name')->toArray();
                $subModules = SubModule::pluck('id', 'name')->toArray();

                foreach ($rows as $key => $row) {
                    if ($key > 0) {
                        $pageName = trim($row[1] ?? '');
                        if (empty($pageName)) continue;

                        $moduleName = trim($row[3] ?? '');
                        $subModuleName = trim($row[4] ?? '');

                        $moduleId = !empty($moduleName) ? ($modules[$moduleName] ?? null) : null;
                        $subModuleId = !empty($subModuleName) ? ($subModules[$subModuleName] ?? null) : null;

                        if (!empty($moduleName) && !$moduleId) {
                            $mod = Module::create(['name' => $moduleName, 'icon' => 'fa-folder']);
                            $moduleId = $mod->id;
                            $modules[$moduleName] = $moduleId;
                        }

                        Page::updateOrCreate(
                            ['name' => $pageName],
                            [
                                'name_kh' => trim($row[2] ?? ''),
                                'module_id' => $moduleId,
                                'sub_module_id' => $subModuleId,
                                'route_name' => trim($row[5] ?? ''),
                                'url_path' => trim($row[6] ?? ''),
                                'icon' => trim($row[7] ?? 'fa-file-alt'),
                                'sort_order' => (int)($row[8] ?? 0),
                                'status' => strtolower(trim($row[9] ?? 'active')) === 'inactive' ? 'inactive' : 'active',
                            ]
                        );
                    }
                }
            });
            $this->status = 200;
            $this->message = 'Pages imported successfully!';
        } catch (\Throwable $th) {
            $this->status = 500;
            $this->message = $th->getMessage();
        }
    }

    private function validateHeader($key)
    {
        $key = array_map(fn($v) => strtolower(trim($v)), $key->toArray());
        $templateKey = ['no', 'name', 'name_kh', 'module_name', 'sub_module_name', 'route_name', 'url_path', 'icon', 'sort_order', 'status'];

        if (array_slice($key, 0, 10) !== $templateKey) {
            $this->status = 500;
            $this->message = 'Incorrect Excel template format. Expected header: no, name, name_kh, module_name, sub_module_name, route_name, url_path, icon, sort_order, status';
            return false;
        }
        return true;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
