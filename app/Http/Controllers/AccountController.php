<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Show the account settings page.
     */
    public function edit(Request $request): View
    {
        return view('account.edit', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the administrator's profile picture.
     */
    public function updateProfileImage(
        Request $request
    ): RedirectResponse {
        $user = $request->user();

        abort_unless(
            $user->role === 'admin',
            403
        );

        $request->validate([
            'profile_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        if ($user->profile_image) {
            Storage::disk('public')->delete(
                $user->profile_image
            );
        }


        $profileImagePath = $request
            ->file('profile_image')
            ->store(
                'profile-images',
                'public'
            );


        $user->update([
            'profile_image' => $profileImagePath,
        ]);


        return back()->with(
            'success',
            'Profile picture updated successfully.'
        );
    }


    /**
     * Update the user's email address.
     */
    public function updateEmail(
        Request $request
    ): RedirectResponse {
        $user = $request->user();

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'email_current_password' => [
                'required',
                'string',
            ],
        ]);


        if (
            ! Hash::check(
                $validated['email_current_password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'email_current_password' =>
                        'The current password is incorrect.',
                ])
                ->withInput();
        }


        $user->email = $validated['email'];
        $user->save();


        return back()->with(
            'success',
            'Email address updated successfully.'
        );
    }


    /**
     * Update the user's password.
     */
    public function updatePassword(
        Request $request
    ): RedirectResponse {
        $user = $request->user();

        $validated = $request->validate([
            'password_current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
            ],
        ]);


        if (
            ! Hash::check(
                $validated['password_current_password'],
                $user->password
            )
        ) {
            return back()->withErrors([
                'password_current_password' =>
                    'The current password is incorrect.',
            ]);
        }


        $user->password = $validated['password'];
        $user->save();


        return back()->with(
            'success',
            'Password changed successfully.'
        );
    }
}