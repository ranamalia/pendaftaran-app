<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $last = $user->applications()
            ->latest('id')
            ->with('opd')
            ->first();

        return view('pemohon.pages.dashboard', compact('user', 'last'));
    }
}
