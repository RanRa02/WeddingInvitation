<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class marriedController extends Controller
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.base_url'), '/');
    }

    public function index()
    {
        return view('wedding-invitation.index', [
            'key' => 'notepeople',
        ]);
    }

    public function people(string $uuid)
    {
        $response = Http::acceptJson()
            ->timeout(10)
            ->get($this->baseUrl, [
                'uuid' => $uuid
            ]);

        if (! $response->successful()) {
            abort(404, 'Invitation not found');
        }

        return view('wedding-invitation.index', [
            'key' => 'people',
            'data' => $response->json(),
        ]);
    }
}

