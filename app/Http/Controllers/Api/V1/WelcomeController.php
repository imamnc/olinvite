<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $api_title = env('APP_NAME') . " - version 1";
            return $this->successResponse("Welcome to $api_title", [
                'title' => $api_title,
                'route' => url('/api/v1')
            ]);
        } else {
            return view('welcome');
        }
    }
}
