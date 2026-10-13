<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminJobPostController extends Controller
{
    /**
     * Display all job posts.
     */
    public function index(Request $request): View
    {
        $search = trim(
            (string) $request->query('search', '')
        );

        $status = trim(
            (string) $request->query('status', '')
        );


        $jobPosts = JobPost::query()

            ->with([
                'company.companyProfile',
                'skills',
            ])

            /*
             * Search by:
             * - job title
             * - location
             * - company name
             */
            ->when(
                $search !== '',
                function ($query) use ($search) {

                    $query->where(
                        function ($subQuery) use ($search) {

                            $subQuery
                                ->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'location',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhereHas(
                                    'company.companyProfile',
                                    function ($companyQuery) use ($search) {

                                        $companyQuery->where(
                                            'company_name',
                                            'like',
                                            "%{$search}%"
                                        );

                                    }
                                );
                        }
                    );
                }
            )

            /*
             * Filter by open / closed.
             */
            ->when(
                in_array(
                    $status,
                    ['open', 'closed'],
                    true
                ),
                fn ($query) =>
                    $query->where(
                        'status',
                        $status
                    )
            )

            ->latest()

            ->paginate(10)

            ->withQueryString();


        return view(
            'admin.job-posts.index',
            [
                'jobPosts' => $jobPosts,
                'search' => $search,
                'selectedStatus' => $status,
            ]
        );
    }


    /**
     * Show one job post.
     */
    public function show(JobPost $jobPost): View
    {
        $jobPost->load([
            'company.companyProfile',
            'skills',
        ]);


        return view(
            'admin.job-posts.show',
            [
                'jobPost' => $jobPost,
            ]
        );
    }


    /**
     * Permanently delete a job post.
     */
    public function destroy(
        JobPost $jobPost
    ): RedirectResponse {

        $jobPost->delete();


        return redirect()
            ->route('admin.job-posts.index')
            ->with(
                'success',
                'Job post deleted successfully.'
            );
    }
}