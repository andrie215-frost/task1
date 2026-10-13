<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Skilled Person sends an email to a Company
     * regarding a specific Job Post.
     */
    public function sendToCompany(
        Request $request,
        JobPost $jobPost
    ): RedirectResponse {
        $sender = $request->user();

        abort_unless(
            $sender->role === 'skilled_person',
            403
        );

        $jobPost->load([
            'company.companyProfile',
        ]);

        $company = $jobPost->company;

        abort_unless(
            $company !== null,
            404
        );

        $validated = $request->validate([
            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        $companyName =
            $company->companyProfile?->company_name
            ?? $company->name;

        $profileUrl =
            route(
                'people.show',
                $sender
            );


        Mail::send(
            'emails.contact',
            [
                'recipientName' => $companyName,
                'senderName' => $sender->name,
                'senderEmail' => $sender->email,
                'messageBody' => $validated['message'],
                'contextLabel' => 'Job',
                'contextValue' => $jobPost->title,
                'profileUrl' => $profileUrl,
            ],
            function ($mail) use (
                $company,
                $sender,
                $validated
            ) {
                $mail->to(
                    $company->email
                );

                $mail->replyTo(
                    $sender->email,
                    $sender->name
                );

                $mail->subject(
                    $validated['subject']
                );
            }
        );


        return redirect()
            ->route(
                'jobs.show',
                $jobPost
            )
            ->with(
                'success',
                'Your message was sent to the company through SkillMatch.'
            );
    }


    /**
     * Company sends an email to a Skilled Person.
     */
    public function sendToSkilledPerson(
        Request $request,
        User $user
    ): RedirectResponse {
        $sender = $request->user();

        abort_unless(
            $sender->role === 'company',
            403
        );

        abort_unless(
            $user->role === 'skilled_person',
            404
        );

        $user->load('skilledProfile');

        abort_unless(
            $user->skilledProfile !== null,
            404
        );


        $validated = $request->validate([
            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        $companyName =
            $sender->companyProfile?->company_name
            ?? $sender->name;


        Mail::send(
            'emails.contact',
            [
                'recipientName' => $user->name,
                'senderName' => $companyName,
                'senderEmail' => $sender->email,
                'messageBody' => $validated['message'],
                'contextLabel' => 'Company',
                'contextValue' => $companyName,
                'profileUrl' => null,
            ],
            function ($mail) use (
                $user,
                $sender,
                $companyName,
                $validated
            ) {
                $mail->to(
                    $user->email
                );

                $mail->replyTo(
                    $sender->email,
                    $companyName
                );

                $mail->subject(
                    $validated['subject']
                );
            }
        );


        return redirect()
            ->route(
                'people.show',
                $user
            )
            ->with(
                'success',
                'Your message was sent to the Skilled Person through SkillMatch.'
            );
    }
}