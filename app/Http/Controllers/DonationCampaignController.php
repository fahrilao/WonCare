<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationCampaignCreateRequest;
use App\Http\Requests\DonationCampaignUpdateRequest;
use App\Models\DonationCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DonationCampaignController extends Controller
{
    /**
     * Display a listing of the donation campaigns.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $campaigns = DonationCampaign::with('creator')->latest();

            return DataTables::of($campaigns)
                ->addIndexColumn()
                ->addColumn('creator_name', function ($campaign) {
                    return $campaign->creator ? $campaign->creator->name : '-';
                })
                ->addColumn('formatted_goal_amount', function ($campaign) {
                    return 'Rp.' . $campaign->formatted_goal_amount;
                })
                ->addColumn('formatted_collected_amount', function ($campaign) {
                    return 'Rp.' . $campaign->formatted_collected_amount;
                })
                ->addColumn('progress_percentage', function ($campaign) {
                    return $campaign->progress_percentage . '%';
                })
                ->addColumn('status_badge', function ($campaign) {
                    $badgeClass = match ($campaign->status) {
                        'draft' => 'bg-secondary',
                        'active' => 'bg-success',
                        'completed' => 'bg-primary',
                        'cancelled' => 'bg-danger',
                        default => 'bg-secondary',
                    };
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($campaign->status) . '</span>';
                })
                ->addColumn('actions', function ($campaign) {
                    return '
                        <div class="btn-group" role="group">
                            <a href="' . route('admin.donation-campaigns.show', $campaign->id) . '" 
                               class="btn btn-info btn-sm" title="' . __('common.view') . '">
                                ' . __('common.view') . '
                            </a>
                            <a href="' . route('admin.donation-campaigns.edit', $campaign->id) . '" 
                               class="btn btn-warning btn-sm" title="' . __('common.edit') . '">
                                ' . __('common.edit') . '
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-id="' . $campaign->id . '" 
                                    data-name="' . htmlspecialchars($campaign->title) . '"
                                    title="' . __('common.delete') . '">
                                ' . __('common.delete') . '
                            </button>
                        </div>
                    ';
                })
                ->editColumn('created_at', function ($class) {
                    return $class->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }

        return view('admin.donation-campaigns.index');
    }

    /**
     * Show the form for creating a new donation campaign.
     */
    public function create()
    {
        return view('admin.donation-campaigns.create');
    }

    /**
     * Store a newly created donation campaign in storage.
     */
    public function store(DonationCampaignCreateRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('donation-campaigns', 'public');
            $data['image_url'] = $imagePath;
        }

        DonationCampaign::create($data);

        return redirect()->route('admin.donation-campaigns.index')
            ->with('success', __('donation_campaigns.created_successfully'));
    }

    /**
     * Display the specified donation campaign.
     */
    public function show(DonationCampaign $donationCampaign)
    {
        $donationCampaign->load('creator');
        return view('admin.donation-campaigns.show', compact('donationCampaign'));
    }

    /**
     * Show the form for editing the specified donation campaign.
     */
    public function edit(DonationCampaign $donationCampaign)
    {
        return view('admin.donation-campaigns.edit', compact('donationCampaign'));
    }

    /**
     * Update the specified donation campaign in storage.
     */
    public function update(DonationCampaignUpdateRequest $request, DonationCampaign $donationCampaign)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($donationCampaign->image_url) {
                Storage::disk('public')->delete($donationCampaign->image_url);
            }

            $imagePath = $request->file('image')->store('donation-campaigns', 'public');
            $data['image_url'] = $imagePath;
        }

        $donationCampaign->update($data);

        return redirect()->route('admin.donation-campaigns.index')
            ->with('success', __('donation_campaigns.updated_successfully'));
    }

    /**
     * Remove the specified donation campaign from storage.
     */
    public function destroy(DonationCampaign $donationCampaign)
    {
        // Delete associated image if exists
        if ($donationCampaign->image_url) {
            Storage::disk('public')->delete($donationCampaign->image_url);
        }

        $donationCampaign->delete();

        return response()->json([
            'success' => true,
            'message' => __('donation_campaigns.deleted_successfully')
        ]);
    }

    /**
     * Search donation campaigns for Select2.
     */
    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = 10;

        $campaigns = DonationCampaign::where('title', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->orderBy('title')
            ->paginate($perPage, ['*'], 'page', $page);

        $results = $campaigns->map(function ($campaign) {
            return [
                'id' => $campaign->id,
                'text' => $campaign->title . ' (' . $campaign->status . ')',
            ];
        });

        $total = $campaigns->total();

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}
