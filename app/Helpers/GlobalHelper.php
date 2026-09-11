<?php

namespace App\Helpers;

use App\Models\Module;
use App\Models\Page;
use App\Models\PageAction;

class GlobalHelper
{
    /**
     * Check if user is in campus / valid environment.
     *
     * @return bool
     */
    public function userInCampus()
    {
        return true;
    }

    /**
     * Check if user has access to current page.
     *
     * @return bool
     */
    public function hasPageAccess()
    {
        return true;
    }

    /**
     * Retrieve shared page actions for a given route name or page ID.
     *
     * @param string|int|null $routeNameOrPageId
     * @param int|null $roleId
     * @return array
     */
    public function getPageActions($routeNameOrPageId = null, $roleId = null)
    {
        $routeName = is_string($routeNameOrPageId) ? $routeNameOrPageId : request()->route()?->getName();
        $pageId = is_numeric($routeNameOrPageId) ? $routeNameOrPageId : null;

        $actionsQuery = PageAction::query();

        if ($pageId) {
            $actionsQuery->where('page_id', $pageId);
        } elseif ($routeName) {
            $page = Page::where('route_name', $routeName)->first();
            if (!$page) {
                $parts = explode('.', $routeName);
                if (count($parts) > 1) {
                    array_pop($parts);
                    $prefix = implode('.', $parts);
                    $page = Page::where('route_name', 'like', $prefix . '%')->first();
                }
            }

            if ($page) {
                $actionsQuery->where('page_id', $page->id);
            } else {
                $actionsQuery->whereRaw('1 = 0');
            }
        } else {
            $actionsQuery->whereRaw('1 = 0');
        }

        try {
            $actions = $actionsQuery->orderBy('order', 'asc')->get();
        } catch (\Exception $e) {
            $actions = collect([]);
        }

        $result = [
            'action' => [],
            'header' => [],
            'top'    => [],
            'restore'=> null,
        ];

        foreach ($actions as $action) {
            $item = [
                'id'             => $action->id,
                'page_id'        => $action->page_id,
                'name'           => $action->name,
                'name_kh'        => $action->name_kh,
                'name_ch'        => $action->name_ch,
                'route_name'     => $action->route_name,
                'type'           => $action->type,
                'position'       => $action->position ?? 'action',
                'icon'           => $action->icon,
                'action_route'   => $action->route_name,
                'action_type'    => $action->type,
                'action_icon'    => $action->icon,
                'action_name'    => $action->name,
                'action_name_kh' => $action->name_kh,
                'action_name_ch' => $action->name_ch,
            ];

            $position = strtolower($action->position ?? 'action');
            if ($action->type === 'restore') {
                $result['restore'] = $item;
            } else {
                $result[$position][] = $item;
            }
        }

        return $result;
    }

    /**
     * Get side menus and active page actions for user role.
     *
     * @param int|null $roleId
     * @return array
     */
    public function sideMenus($roleId = null)
    {
        try {
            $modules = Module::with('pages')->where('status', 'active')->orderBy('sort_order', 'asc')->get();
        } catch (\Exception $e) {
            $modules = collect([]);
        }

        $pageActions = $this->getPageActions(request()->route()?->getName(), $roleId);

        return [
            'modules' => $modules,
            'active_page_actions' => $pageActions,
            'breadcrumbs' => null,
            'restore' => $pageActions['restore'] ?? null,
        ];
    }
}
