<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\OrganizationProfile;
use App\Models\PaymentMethod;
use App\Models\Project;
use App\Models\SocialLink;
use App\Models\VolunteerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(): View
    {
        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $projects = Project::active()
            ->orderBy('display_order')
            ->get(['id', 'title_ar', 'type', 'target_amount', 'raised_amount']);

        $org        = OrganizationProfile::instance();
        $socialLinks = SocialLink::active()->get();

        return view('pages.donate', compact(
            'paymentMethods',
            'projects',
            'org',
            'socialLinks',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name'            => 'nullable|string|max:120',
            'email'                 => 'nullable|email|max:180',
            'phone'                 => 'nullable|string|max:30',
            'amount'                => 'required|numeric|min:1',
            'payment_method'        => 'required|in:bankak,fawri,mycash,bank_transfer',
            'donation_type'         => 'required|in:one_time,recurring',
            'project_id'            => 'nullable|exists:projects,id',
            'transaction_reference' => 'nullable|string|max:120',
        ]);

        Donation::create([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()->route('donate')
            ->with('donation_success', true);
    }

    public function volunteerStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'         => 'required|string|max:120',
            'email'             => 'required|email|max:180',
            'phone'             => 'required|string|max:30',
            'volunteer_type'    => 'required|in:professional,digital',
            'specialization'    => 'nullable|string|max:120',
            'message_or_skills' => 'required|string|max:1000',
        ]);

        VolunteerApplication::create($validated);

        return redirect()->route('donate', '#volunteer')
            ->with('volunteer_success', true);
    }
}
