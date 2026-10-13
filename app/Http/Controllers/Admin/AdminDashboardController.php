<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        /*
         * Members only:
         * skilled people + companies.
         *
         * Admin accounts are NOT included.
         */
        $totalMembers = User::query()
            ->whereIn(
                'role',
                [
                    'skilled_person',
                    'company',
                ]
            )
            ->count();


        $totalSkilledPeople = User::query()
            ->where(
                'role',
                'skilled_person'
            )
            ->count();


        $totalCompanies = User::query()
            ->where(
                'role',
                'company'
            )
            ->count();


        /*
         * Job statistics.
         */
        $totalJobPosts = JobPost::query()
            ->count();


        $openJobPosts = JobPost::query()
            ->where(
                'status',
                'open'
            )
            ->count();


        $closedJobPosts = JobPost::query()
            ->where(
                'status',
                'closed'
            )
            ->count();


        /*
         * Latest registered members.
         */
        $latestUsers = User::query()
            ->whereIn(
                'role',
                [
                    'skilled_person',
                    'company',
                ]
            )
            ->with([
                'skilledProfile',
                'companyProfile',
            ])
            ->latest()
            ->take(6)
            ->get();


        /*
         * Latest job posts.
         */
        $latestJobPosts = JobPost::query()
            ->with([
                'company.companyProfile',
            ])
            ->latest()
            ->take(6)
            ->get();


        return view(
            'admin.dashboard',
            [
                'totalMembers' =>
                    $totalMembers,

                'totalSkilledPeople' =>
                    $totalSkilledPeople,

                'totalCompanies' =>
                    $totalCompanies,

                'totalJobPosts' =>
                    $totalJobPosts,

                'openJobPosts' =>
                    $openJobPosts,

                'closedJobPosts' =>
                    $closedJobPosts,

                'latestUsers' =>
                    $latestUsers,

                'latestJobPosts' =>
                    $latestJobPosts,
            ]
        );
    }
}