<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;

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

        // Checking invitation and guest availability
        $guest = null;
        if ($invitation) {
            $guest = $invitation->guests->where('link_name', strtolower($guest_link_name))->first();
        }

        // Return not found when prefix not used by invitation or guest not found
        if (!$invitation || !$guest) {
            abort(404);
        }

        // Create qrcode payload
        $guest->qrcode = $this->encrypt($guest->id);

        // Sorting messages
        $wishes = $invitation->wishes->sortByDesc('id')->values()->all();
        $invitation = (object) $invitation->toArray();
        $invitation->wishes = $wishes;

        // Generate response
        if ($request->wantsJson()) {
            return $this->successResponse('Berhasil mengambil data invitation', compact('guest', 'invitation'));
        } else {
            return view('themes.theme1.index');
        }
    }
}
