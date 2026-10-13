<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(
        Request $request
    ): View|RedirectResponse
    {
        $user = $request->user()->load([
            'skilledProfile',
            'companyProfile',
            'skills',
        ]);

        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.dashboard');
        }

        abort_unless(
            in_array(
                $user->role,
                [
                    'skilled_person',
                    'company'
                ],
                true
            ),
            403
        );


        if ($user->role === 'company') {

            return view(
                'dashboards.company',
                [
                    'user' => $user,
                    'profile' => $user->companyProfile,
                ]
            );

        }


        return view(
            'dashboards.skilled-person',
            [
                'user' => $user,
                'profile' => $user->skilledProfile,
            ]
        );
    }
}