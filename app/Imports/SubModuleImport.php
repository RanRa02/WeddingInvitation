<?php

namespace App\Imports;

use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class SubModuleImport implements ToCollection
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

                foreach ($rows as $key => $row) {
                    if ($key > 0) {
                        $moduleName = trim($row[1] ?? '');
                        $subModuleName = trim($row[2] ?? '');
                        if (empty($subModuleName)) continue;

                        $moduleId = $modules[$moduleName] ?? null;
                        if (!$moduleId) {
                            $mod = Module::create(['name' => $moduleName, 'icon' => 'fa-folder']);
                            $moduleId = $mod->id;
                            $modules[$moduleName] = $moduleId;
                        }

                        SubModule::updateOrCreate(
                            ['module_id' => $moduleId, 'name' => $subModuleName],
                            [
                                'name_kh' => trim($row[3] ?? ''),
                                'icon' => trim($row[4] ?? 'fa-folder-open'),
                                'sort_order' => (int)($row[5] ?? 0),
                                'status' => strtolower(trim($row[6] ?? 'active')) === 'inactive' ? 'inactive' : 'active',
                            ]
                        );
                    }
                }
            });
            $this->status = 200;
            $this->message = 'Sub-Modules imported successfully!';
        } catch (\Throwable $th) {
            $this->status = 500;
            $this->message = $th->getMessage();
        }
    }

    private function validateHeader($key)
    {
        $key = array_map(fn($v) => strtolower(trim($v)), $key->toArray());
        $templateKey = ['no', 'module_name', 'name', 'name_kh', 'icon', 'sort_order', 'status'];

        if (array_slice($key, 0, 7) !== $templateKey) {
            $this->status = 500;
            $this->message = 'Incorrect Excel template format. Expected header: no, module_name, name, name_kh, icon, sort_order, status';
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
