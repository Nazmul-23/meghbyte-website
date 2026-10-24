<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $counts = QuoteRequest::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'statuses' => LeadStatus::cases(),
            'counts' => $counts,
            'newThisWeek' => QuoteRequest::where('created_at', '>=', now()->subDays(7))->count(),
            'latest' => QuoteRequest::with('service')->latest()->take(8)->get(),
            'contentCounts' => [
                'Services' => Service::count(),
                'Projects' => Project::count(),
                'Posts' => Post::count(),
            ],
        ]);
    }
}
