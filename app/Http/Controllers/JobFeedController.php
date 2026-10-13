<?php

namespace App\Http\Controllers;

use App\Models\FindingOption;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobFeedController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'skilled_person',
            403
        );


        /*
         * Admin-managed active Job Types.
         */
        $jobTypeOptions = FindingOption::query()
            ->where('type', 'job_type')
            ->where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->values();


        $search = trim(
            (string) $request->query('search', '')
        );

        $location = trim(
            (string) $request->query('location', '')
        );

        $jobType = trim(
            (string) $request->query('job_type', '')
        );


        /*
         * Ignore a Job Type that is no longer active
         * or was manually entered in the URL.
         */
        if (
            $jobType !== ''
            && ! $jobTypeOptions->contains($jobType)
        ) {
            $jobType = '';
        }


        $jobPosts = JobPost::query()
            ->where('status', 'open')

            ->with([
                'company.companyProfile',
                'skills',
            ])

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
                                    'description',
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

            ->when(
                $location !== '',
                fn ($query) =>
                    $query->where(
                        'location',
                        'like',
                        "%{$location}%"
                    )
            )

            ->when(
                $jobType !== '',
                fn ($query) =>
                    $query->where(
                        'job_type',
                        $jobType
                    )
            )

            ->latest()

            ->paginate(9)

            ->withQueryString();


        return view('job-feed.index', [
            'jobPosts' => $jobPosts,

            'search' => $search,

            'location' => $location,

            'jobType' => $jobType,

            'jobTypeOptions' => $jobTypeOptions,
        ]);
    }


    public function show(
        Request $request,
        JobPost $jobPost
    ): View {
        abort_unless(
            $request->user()->role === 'skilled_person',
            403
        );


        abort_unless(
            $jobPost->status === 'open',
            404
        );


        $jobPost->load([
            'company.companyProfile',
            'skills',
        ]);


        return view('job-feed.show', [
            'jobPost' => $jobPost,
        ]);
    }
}