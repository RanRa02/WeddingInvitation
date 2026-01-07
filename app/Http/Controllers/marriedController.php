<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class marriedController extends Controller
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('API_BASE_URL'), '/');
    }

    public function index($uuid)
    {
        if(empty($uuid)) {
            return view('wedding-invitation.index');
        }else{
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get("{$this->baseUrl}", [
                'uuid' => $uuid
            ]);
            return view('wedding-invitation.index', [
                'data' => $response->json()['data'] ?? null,
            ]);
        }
    }
}
