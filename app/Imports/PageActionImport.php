<?php

namespace App\Imports;

use App\Models\Page;
use App\Models\PageAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class PageActionImport implements ToCollection
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
                $pages = Page::pluck('id', 'name')->toArray();

                foreach ($rows as $key => $row) {
                    if ($key > 0) {
                        $pageName = trim($row[1] ?? '');
                        $actionName = trim($row[2] ?? '');
                        if (empty($actionName) || empty($pageName)) continue;

                        $pageId = $pages[$pageName] ?? null;
                        if (!$pageId) continue;

                        PageAction::updateOrCreate(
                            ['page_id' => $pageId, 'name' => $actionName],
                            [
                                'name_kh' => trim($row[3] ?? ''),
                                'name_ch' => trim($row[4] ?? ''),
                                'route_name' => trim($row[5] ?? ''),
                                'type' => trim($row[6] ?? 'action'),
                                'position' => trim($row[7] ?? 'action'),
                                'icon' => trim($row[8] ?? 'fa-bolt'),
                                'order' => (int)($row[9] ?? 0),
                            ]
                        );
                    }
                }
            });
            $this->status = 200;
            $this->message = 'Page Actions imported successfully!';
        } catch (\Throwable $th) {
            $this->status = 500;
            $this->message = $th->getMessage();
        }
    }

    private function validateHeader($key)
    {
        $key = array_map(fn($v) => strtolower(trim($v)), $key->toArray());
        $templateKey = ['no', 'page_name', 'name', 'name_kh', 'name_ch', 'route_name', 'type', 'position', 'icon', 'order'];

        if (array_slice($key, 0, 10) !== $templateKey) {
            $this->status = 500;
            $this->message = 'Incorrect Excel template format. Expected header: no, page_name, name, name_kh, name_ch, route_name, type, position, icon, order';
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
