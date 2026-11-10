<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pelanggan.profile.index');
    }
}
