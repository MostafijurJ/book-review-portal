<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $pendingReports = Report::where('status', 'pending')
            ->with(['user', 'reportable', 'resolver'])
            ->latest()
            ->paginate(20);

        // Calculate rating distribution
        $ratingDistribution = Review::where('is_approved', true)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating')
            ->toArray();

        // Ensure all ratings 1-5 are represented
        $ratingData = [];
        $totalReviews = Review::where('is_approved', true)->count();
        for ($i = 5; $i >= 1; $i--) {
            $count = $ratingDistribution[$i] ?? 0;
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;
            $ratingData[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        $stats = [
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'resolved_reports' => Report::where('status', 'resolved')->count(),
            'total_books' => \App\Models\Book::count(),
            'total_reviews' => Review::where('is_approved', true)->count(),
            'total_users' => \App\Models\User::where('role', 'member')->count(),
        ];

        return view('admin.dashboard', compact('pendingReports', 'stats', 'ratingData', 'totalReviews'));
    }

    /**
     * Show reported content queue
     */
    public function reports()
    {
        $reports = Report::with(['user', 'reportable', 'resolver'])
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    /**
     * Resolve a report (delete the content)
     */
    public function resolveReport(Request $request, Report $report)
    {
        $report->load('reportable');

        if ($report->reportable instanceof Review) {
            $report->reportable->delete();
        }

        $report->markAsResolved(Auth::user());

        return back()->with('success', 'Report resolved and content removed.');
    }

    /**
     * Dismiss a report
     */
    public function dismissReport(Report $report)
    {
        $report->dismiss(Auth::user());

        return back()->with('success', 'Report dismissed.');
    }
}

