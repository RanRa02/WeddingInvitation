<?php

namespace App\Http\Middleware;

use App\Helpers\GlobalHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SideMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() == 'POST') {
            return $next($request);
        }

        $helper = new GlobalHelper;
        if (Session::has('user_school') && !Session::get('user_school')) {
            Auth::logout();
            return redirect()->route('login');
        }

        if (!$helper->userInCampus()) {
            Auth::logout();
            if (function_exists('flash')) {
                flash(['type' => 'danger', 'title' => 'danger', 'text' => 'Danger']);
            }
            return redirect()->route('login');
        }

        if (!$helper->hasPageAccess()) {
            return redirect()->back();
        }

        // GET ALL MENU FOR USER ROLE
        $roleId = Auth::check() ? (Auth::user()->role_id ?? null) : null;
        $sideMenu = $helper->sideMenus($roleId);
        $data = [
            'sideMenus' => $sideMenu,
            'pageActions' => isset($sideMenu['active_page_actions']) ? $sideMenu['active_page_actions'] : null,
            'breadcrumbs' => isset($sideMenu['breadcrumbs']) ? $sideMenu['breadcrumbs'] : null,
            'restore'       => isset($sideMenu['restore']) ? $sideMenu['restore'] : null,
            'locale'       => App::getLocale() == 'en' ? '' : '_' . App::getLocale(),
        ];
        View::share($data);
        return $next($request);
    }
}
