<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Show all company and skilled-person accounts.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:255',
            ],

            'role' => [
                'nullable',
                Rule::in([
                    'company',
                    'skilled_person',
                ]),
            ],
        ]);


        $users = User::query()

            ->whereIn(
                'role',
                [
                    'company',
                    'skilled_person',
                ]
            )

            ->when(
                filled($validated['search'] ?? null),
                function ($query) use ($validated) {

                    $search = trim(
                        $validated['search']
                    );


                    $query->where(
                        function ($query) use ($search) {

                            $query

                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )

                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                )

                                ->orWhereHas(
                                    'companyProfile',
                                    function ($query) use ($search) {

                                        $query->where(
                                            'company_name',
                                            'like',
                                            '%' . $search . '%'
                                        );

                                    }
                                )

                                ->orWhereHas(
                                    'skilledProfile',
                                    function ($query) use ($search) {

                                        $query->where(
                                            'professional_title',
                                            'like',
                                            '%' . $search . '%'
                                        );

                                    }
                                );
                        }
                    );
                }
            )

            ->when(
                filled($validated['role'] ?? null),
                function ($query) use ($validated) {

                    $query->where(
                        'role',
                        $validated['role']
                    );

                }
            )

            ->with([
                'companyProfile',
                'skilledProfile',
            ])

            ->latest()

            ->paginate(10)

            ->withQueryString();


        return view(
            'admin.users.index',
            [
                'users' => $users,

                'search' =>
                    $validated['search'] ?? '',

                'selectedRole' =>
                    $validated['role'] ?? '',
            ]
        );
    }


    /**
     * Show one user's information.
     */
    public function show(User $user): View
    {
        abort_if(
            $user->role === 'admin',
            404
        );


        abort_unless(
            in_array(
                $user->role,
                [
                    'company',
                    'skilled_person',
                ],
                true
            ),
            404
        );


        /*
         * Skilled people need their profile and skills.
         *
         * Companies need their profile and real Job Posts.
         */
        if ($user->role === 'company') {

            $user->load([
                'companyProfile',

                'jobPosts' => function ($query) {
                    $query
                        ->with('skills')
                        ->latest();
                },
            ]);

        } else {

            $user->load([
                'skilledProfile',
                'skills',
            ]);
        }


        return view(
            'admin.users.show',
            [
                'managedUser' => $user,
            ]
        );
    }


    /**
     * Delete a worker or company account.
     */
    public function destroy(
        Request $request,
        User $user
    ): RedirectResponse {

        abort_if(
            $user->role === 'admin',
            403,
            'Administrator accounts cannot be deleted here.'
        );


        abort_if(
            $request->user()->is($user),
            403,
            'You cannot delete your own account.'
        );


        abort_unless(
            in_array(
                $user->role,
                [
                    'company',
                    'skilled_person',
                ],
                true
            ),
            403
        );


        $deletedUserName =
            $user->name;


        $user->delete();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                $deletedUserName
                . ' was deleted successfully.'
            );
    }
}