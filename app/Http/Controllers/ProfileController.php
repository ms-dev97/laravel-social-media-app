<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(User $user) {
        return Inertia::render('Profile/Home', [
            'user' => $user
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
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

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Update user cover
    public function updateCover(Request $request) {
        $validation = $request->validate([
            'cover' => ['image']
        ]);
        
        $user = $request->user();

        if ($user->cover) {
            Storage::disk('public')->delete($user->cover);
        }

        $path = $request->cover->store('covers', 'public');
        $user->update(['cover' => $path]);

        return back()->with('success', 'Cover has been updated');
    }

    // Update user avatar
    public function updateAvatar(Request $request) {
        $validation = $request->validate([
            'avatar' => ['image']
        ]);
        
        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->avatar->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Your avatar has been updated');
    }
}
