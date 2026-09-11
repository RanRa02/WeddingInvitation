<?php

if (!function_exists('getPageActions')) {
    /**
     * Get shared page actions.
     *
     * @param string|int|null $routeNameOrPageId
     * @param int|null $roleId
     * @return array
     */
    function getPageActions($routeNameOrPageId = null, $roleId = null)
    {
        return (new \App\Helpers\GlobalHelper())->getPageActions($routeNameOrPageId, $roleId);
    }
}
