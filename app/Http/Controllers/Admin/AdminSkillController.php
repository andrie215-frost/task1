<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminSkillController extends Controller
{
    /**
     * Display all skills.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:255',
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        $search = trim(
            $validated['search'] ?? ''
        );

        $selectedCategory = trim(
            $validated['category'] ?? ''
        );


        $skills = Skill::query()

            ->withCount([
                'users',
                'jobPosts',
            ])

            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        function ($query) use ($search) {
                            $query
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'category',
                                    'like',
                                    '%' . $search . '%'
                                );
                        }
                    );
                }
            )

            ->when(
                $selectedCategory !== '',
                function ($query) use ($selectedCategory) {
                    $query->where(
                        'category',
                        $selectedCategory
                    );
                }
            )

            ->orderByRaw(
                'CASE WHEN category IS NULL OR category = "" THEN 1 ELSE 0 END'
            )

            ->orderBy('category')

            ->orderBy('name')

            ->paginate(15)

            ->withQueryString();


        $categories = Skill::query()

            ->whereNotNull('category')

            ->where('category', '!=', '')

            ->select('category')

            ->distinct()

            ->orderBy('category')

            ->pluck('category');


        return view(
            'admin.skills.index',
            [
                'skills' => $skills,
                'categories' => $categories,
                'search' => $search,
                'selectedCategory' => $selectedCategory,
            ]
        );
    }


    /**
     * Create a new skill.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        $request->merge([
            'name' => trim(
                (string) $request->input('name')
            ),

            'category' => trim(
                (string) $request->input('category')
            ),
        ]);


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('skills', 'name'),
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        Skill::create([
            'name' => $validated['name'],

            'category' => filled(
                $validated['category'] ?? null
            )
                ? $validated['category']
                : null,
        ]);


        return redirect()
            ->route('admin.skills.index')
            ->with(
                'success',
                'Skill created successfully.'
            );
    }


    /**
     * Update an existing skill.
     */
    public function update(
        Request $request,
        Skill $skill
    ): RedirectResponse {
        $request->merge([
            'name' => trim(
                (string) $request->input('name')
            ),

            'category' => trim(
                (string) $request->input('category')
            ),
        ]);


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'skills',
                    'name'
                )->ignore($skill->id),
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        $skill->update([
            'name' => $validated['name'],

            'category' => filled(
                $validated['category'] ?? null
            )
                ? $validated['category']
                : null,
        ]);


        return redirect()
            ->route('admin.skills.index')
            ->with(
                'success',
                'Skill updated successfully.'
            );
    }


    /**
     * Delete a skill.
     */
    public function destroy(
        Skill $skill
    ): RedirectResponse {
        $skillName = $skill->name;


        DB::transaction(
            function () use ($skill) {
                /*
                 * Remove pivot relationships first so deleting
                 * a skill does not leave user/job associations.
                 */
                $skill->users()->detach();
                $skill->jobPosts()->detach();

                $skill->delete();
            }
        );


        return redirect()
            ->route('admin.skills.index')
            ->with(
                'success',
                $skillName . ' was deleted successfully.'
            );
    }
}