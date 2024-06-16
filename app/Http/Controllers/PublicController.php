<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /* HANDLE INVITATION URL */
    public function invitation(Request $request, $uri_string)
    {
        // Handle parameters
        $uri_string = explode('/', $uri_string);
        $prefix = isset($uri_string[0]) ? $uri_string[0] : null;
        $guest = isset($uri_string[1]) ? urldecode($uri_string[1]) : null;

        // Get invitation data
        $invitation = Invitation::with('theme', 'invoice', 'wedding_data', 'music')->where('prefix_route', $prefix)->first();

        // Return not found if prefix not used by invitation
        if (!$invitation) {
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
