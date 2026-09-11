<?php

namespace App\Imports;

use App\Models\Module;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class ModuleImport implements ToCollection
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
                foreach ($rows as $key => $row) {
                    if ($key > 0) {
                        if (empty($row[1])) continue;

                        Module::updateOrCreate(
                            ['name' => trim($row[1])],
                            [
                                'name_kh' => trim($row[2] ?? ''),
                                'icon' => trim($row[3] ?? 'fa-folder'),
                                'sort_order' => (int)($row[4] ?? 0),
                                'status' => strtolower(trim($row[5] ?? 'active')) === 'inactive' ? 'inactive' : 'active',
                            ]
                        );
                    }
                }
            });
            $this->status = 200;
            $this->message = 'Modules imported successfully!';
        } catch (\Throwable $th) {
            $this->status = 500;
            $this->message = $th->getMessage();
        }
    }

    private function validateHeader($key)
    {
        $key = array_map(fn($v) => strtolower(trim($v)), $key->toArray());
        $templateKey = ['no', 'name', 'name_kh', 'icon', 'sort_order', 'status'];

        if (array_slice($key, 0, 6) !== $templateKey) {
            $this->status = 500;
            $this->message = 'Incorrect Excel template format. Expected header: no, name, name_kh, icon, sort_order, status';
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
