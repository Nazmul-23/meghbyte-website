<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $status = is_string($request->query('status')) ? LeadStatus::tryFrom($request->query('status')) : null;
        $search = is_string($request->query('q')) ? trim($request->query('q')) : '';

        $leads = QuoteRequest::with('service')
            ->when($status, fn ($q) => $q->where('status', $status->value))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $term = '%'.mb_strtolower($search).'%';
                    $w->whereRaw('lower(name) like ?', [$term])
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhereRaw('lower(business_name) like ?', [$term]);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.leads.index', [
            'leads' => $leads,
            'status' => $status,
            'search' => $search,
            'statuses' => LeadStatus::cases(),
        ]);
    }

    public function show(QuoteRequest $lead): View
    {
        return view('admin.leads.show', ['lead' => $lead->load('service'), 'statuses' => LeadStatus::cases()]);
    }

    public function update(Request $request, QuoteRequest $lead): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::enum(LeadStatus::class)],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $lead->status = LeadStatus::from($data['status']);
        $lead->notes = $data['notes'] ?? null;

        if ($lead->status !== LeadStatus::New && ! $lead->contacted_at) {
            $lead->contacted_at = now();
        }

        $lead->save();

        return back()->with('status', 'Lead updated.');
    }

    public function destroy(Request $request, QuoteRequest $lead): RedirectResponse
    {
        abort_unless($request->user()->isAdmin(), 403);
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('status', 'Lead deleted.');
    }
}
