<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function update_specialist(Request $request): RedirectResponse
    {
        if (Auth::check() && Auth::user()->role == 'dokter') {
            $request->validate([
                'specialist' => 'required|string|max:255',
            ], [
                'specialist.required' => 'Mohon tidak mengosongkan spesialis anda',
                'specialist.string' => 'Input spesialis tidak boleh angka',
                'specialist.max' => 'Batas maksimal input spesialis adalah 255 karakter',
            ]);

            User::where('id', Auth::user()->id)->update([
                'specialist' => $request->specialist,
            ]);

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
    }
}
