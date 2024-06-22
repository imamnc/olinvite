<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PublicController extends Controller
{
    /* HANDLE INVITATION URL */
    public function invitation(Request $request, $uri_string)
    {
        // Handle parameters
        $uri_string = explode('/', $uri_string);
        $prefix = isset($uri_string[0]) ? $uri_string[0] : null;
        $guest_link_name = isset($uri_string[1]) ? urldecode($uri_string[1]) : null;

        // Get invitation data
        $invitation = Invitation::with('theme', 'invoice', 'wedding_data', 'music', 'wishes')
            ->where('prefix_route', $prefix)->first();

        // Return not found if guest doesn't exists
        $guest = null;
        if ($invitation) {
            $guest = $invitation->guests->where('link_name', strtolower($guest_link_name))->first();
        }

        // Return not found when prefix not used by invitation or guest not found
        if (!$invitation || !$guest) {
            abort(404);
        }

        // Generate response
        if ($request->wantsJson()) {
            return $this->successResponse('Berhasil mengambil data invitation', compact('guest', 'invitation'));
        } else {
            return view('themes.theme1.index');
        }
    }
}
