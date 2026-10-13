<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FindingOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminFindingOptionController extends Controller
{
    /**
     * Show all finding form options.
     */
    public function index(Request $request): View
    {
        $selectedType = $request->query('type', '');

        $options = FindingOption::query()
            ->when(
                in_array(
                    $selectedType,
                    [
                        'position',
                        'location',
                        'job_type',
                    ],
                    true
                ),
                fn ($query) =>
                    $query->where(
                        'type',
                        $selectedType
                    )
            )
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view(
            'admin.finding-options.index',
            [
                'options' => $options,
                'selectedType' => $selectedType,
            ]
        );
    }


    /**
     * Add a new option.
     */
    public function store(
        Request $request
    ): RedirectResponse {

        /*
         * Normalize the option name before validation
         * so duplicate checks use the trimmed value.
         */
        $request->merge([
            'name' => trim(
                (string) $request->input('name', '')
            ),
        ]);


        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in([
                    'position',
                    'location',
                    'job_type',
                ]),
            ],

            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'finding_options',
                    'name'
                )->where(
                    fn ($query) =>
                        $query->where(
                            'type',
                            $request->input('type')
                        )
                ),
            ],
        ]);


        FindingOption::create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'is_active' => true,
        ]);


        return redirect()
            ->route('admin.finding-options.index')
            ->with(
                'success',
                'Finding option added successfully.'
            );
    }


    /**
     * Update an existing option.
     */
    public function update(
        Request $request,
        FindingOption $findingOption
    ): RedirectResponse {

        /*
         * Normalize the option name before validation
         * so duplicate checks use the trimmed value.
         */
        $request->merge([
            'name' => trim(
                (string) $request->input('name', '')
            ),
        ]);


        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in([
                    'position',
                    'location',
                    'job_type',
                ]),
            ],

            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'finding_options',
                    'name'
                )
                    ->where(
                        fn ($query) =>
                            $query->where(
                                'type',
                                $request->input('type')
                            )
                    )
                    ->ignore(
                        $findingOption->id
                    ),
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);


        $findingOption->update([
            'type' => $validated['type'],

            'name' => $validated['name'],

            'is_active' =>
                $request->boolean('is_active'),
        ]);


        return redirect()
            ->route('admin.finding-options.index')
            ->with(
                'success',
                'Finding option updated successfully.'
            );
    }


    /**
     * Delete an option.
     */
    public function destroy(
        FindingOption $findingOption
    ): RedirectResponse {

        $findingOption->delete();


        return redirect()
            ->route('admin.finding-options.index')
            ->with(
                'success',
                'Finding option deleted successfully.'
            );
    }
}