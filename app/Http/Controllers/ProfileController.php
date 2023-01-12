<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
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
        if(isset($request->id)){
            $id = $request->id;
        }else{
            $id = $request->user()->id;
        }

        $data = User::find($id);
        $data->fill($request->validated());

        if ($data->isDirty('email')) {
            $data->email_verified_at = null;
        }

        $data->save();

        if(isset($request->id)){
            return Redirect::to('/');
        }else{
            return Redirect::route('profile.edit');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if(isset($request->id)){
            $user = User::find($request->id);
        }else{
            $request->validate([
                'password' => ['required', 'current-password'],
            ]);
            $user = $request->user();
            Auth::logout();
        }

        $user->delete();

        if(!isset($request->id)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return Redirect::to('/');
    }
}
