<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Alert;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('profile.index', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $profile->update([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone
        ]);

        Alert::success('Data Profile Berhasil Diubah');
        return redirect()->route('profile.index');
    }
}
