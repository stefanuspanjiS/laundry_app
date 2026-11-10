<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_laundry'  => 'required|string|max:255',
            'owner'         => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:20',
            'alamat'        => 'required|string',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->nama_laundry = $request->nama_laundry;
        $setting->owner = $request->owner;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->alamat = $request->alamat;

        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');

            $namaLogo = time() . '_' . $logo->getClientOriginalName();

            $logo->move(
                public_path('uploads/logo'),
                $namaLogo
            );

            $setting->logo = $namaLogo;
        }

        $setting->save();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
