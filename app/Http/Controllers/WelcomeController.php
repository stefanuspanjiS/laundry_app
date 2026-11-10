<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Setting;

class WelcomeController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $packages = Package::where('status', true)
            ->orderBy('id')
            ->get();

        return view('welcome', compact(
            'setting',
            'packages'
        ));
    }
}
