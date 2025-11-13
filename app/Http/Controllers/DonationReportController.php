<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationReportCreateRequest;
use App\Http\Requests\DonationReportUpdateRequest;
use App\Models\DonationCampaign;
use App\Models\DonationReport;
use App\Models\DonationReportImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DonationReportController extends Controller
{
    /**
     * Display a listing of the donation reports.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reports = DonationReport::with(['donationCampaign', 'creator', 'verifier'])->latest();

            return DataTables::of($reports)
                ->addIndexColumn()
                ->addColumn('campaign_title', function ($report) {
                    return $report->donationCampaign ? e($report->donationCampaign->title) : '-';
                })
                ->addColumn('report_title', function ($report) {
                    return 'Report #' . $report->id;
                })
                ->addColumn('formatted_distributed_amount', function ($report) {
                    return 'Rp.' . $report->formatted_distributed_amount;
                })
                ->addColumn('formatted_distribution_date', function ($report) {
                    return $report->formatted_distribution_date;
                })
                ->addColumn('status_badge', function ($report) {
                    return $report->status_badge;
                })
                ->addColumn('creator_name', function ($report) {
                    return $report->creator ? e($report->creator->name) : '-';
                })
                ->addColumn('actions', function ($report) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.donation-reports.show', $report) . '" class="btn btn-info btn-sm" title="' . __('common.view') . '">' . __('common.view') . '</a>';
                    
                    if ($report->canBeEdited()) {
                        $actions .= '<a href="' . route('admin.donation-reports.edit', $report) . '" class="btn btn-warning btn-sm" title="' . __('common.edit') . '">' . __('common.edit') . '</a>';
                    }
                    
                    if ($report->canBeVerified()) {
                        $actions .= '<button type="button" class="btn btn-success btn-sm verify-btn" data-id="' . $report->id . '" title="Verify">Verify</button>';
                        $actions .= '<button type="button" class="btn btn-secondary btn-sm reject-btn" data-id="' . $report->id . '" title="Reject">Reject</button>';
                    }
                    
                    $actions .= '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $report->id . '" data-name="Report #' . $report->id . '" title="' . __('common.delete') . '">' . __('common.delete') . '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('created_at', function ($report) {
                    return $report->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }

        return view('admin.donation-reports.index');
    }

    /**
     * Show the form for creating a new donation report.
     */
    public function create(Request $request)
    {
        $campaigns = DonationCampaign::where('status', 'active')->orderBy('title')->get();
        $selectedCampaign = null;
        
        if ($request->has('campaign_id')) {
            $selectedCampaign = DonationCampaign::find($request->campaign_id);
        }
        
        return view('admin.donation-reports.create', compact('campaigns', 'selectedCampaign'));
    }

    /**
     * Store a newly created donation report in storage.
     */
    public function store(DonationReportCreateRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $data) {
            // Handle evidence file upload
            if ($request->hasFile('evidence_file')) {
                $data['evidence_file'] = $request->file('evidence_file')->store('donation-reports', 'public');
            }

            DonationReport::create($data);
        });

        return redirect()->route('admin.donation-reports.index')
            ->with('success', __('donation_reports.created_successfully'));
    }

    /**
     * Display the specified donation report.
     */
    public function show(DonationReport $donationReport)
    {
        $donationReport->load(['donationCampaign', 'creator', 'verifier', 'images']);
        return view('admin.donation-reports.show', compact('donationReport'));
    }

    /**
     * Show the form for editing the specified donation report.
     */
    public function edit(DonationReport $donationReport)
    {
        if (!$donationReport->canBeEdited()) {
            return redirect()->route('admin.donation-reports.show', $donationReport)
                ->with('error', __('donation_reports.cannot_edit_verified'));
        }

        $campaigns = DonationCampaign::where('status', 'active')->orderBy('title')->get();
        return view('admin.donation-reports.edit', compact('donationReport', 'campaigns'));
    }

    /**
     * Update the specified donation report in storage.
     */
    public function update(DonationReportUpdateRequest $request, DonationReport $donationReport)
    {
        if (!$donationReport->canBeEdited()) {
            return redirect()->route('admin.donation-reports.show', $donationReport)
                ->with('error', __('donation_reports.cannot_edit_verified'));
        }

        $data = $request->validated();

        DB::transaction(function () use ($request, $data, $donationReport) {
            // Handle evidence file upload
            if ($request->hasFile('evidence_file')) {
                // Delete old file if exists
                if ($donationReport->evidence_file) {
                    Storage::disk('public')->delete($donationReport->evidence_file);
                }
                $data['evidence_file'] = $request->file('evidence_file')->store('donation-reports', 'public');
            }

            $donationReport->update($data);
        });

        return redirect()->route('admin.donation-reports.index')
            ->with('success', __('donation_reports.updated_successfully'));
    }

    /**
     * Remove the specified donation report from storage.
     */
    public function destroy(DonationReport $donationReport)
    {
        DB::transaction(function () use ($donationReport) {
            // Delete evidence file if exists
            if ($donationReport->evidence_file) {
                Storage::disk('public')->delete($donationReport->evidence_file);
            }

            $donationReport->delete();
        });

        return response()->json([
            'success' => true,
            'message' => __('donation_reports.deleted_successfully')
        ]);
    }

    /**
     * Verify a donation report.
     */
    public function verify(Request $request, DonationReport $donationReport)
    {
        if (!$donationReport->canBeVerified()) {
            return response()->json([
                'success' => false,
                'message' => __('donation_reports.cannot_verify')
            ], 400);
        }

        $donationReport->verify();

        return response()->json([
            'success' => true,
            'message' => __('donation_reports.verified_successfully')
        ]);
    }

    /**
     * Reject a donation report.
     */
    public function reject(Request $request, DonationReport $donationReport)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        if (!$donationReport->canBeVerified()) {
            return response()->json([
                'success' => false,
                'message' => __('donation_reports.cannot_reject')
            ], 400);
        }

        $donationReport->update(['notes' => $request->notes]);
        $donationReport->reject();

        return response()->json([
            'success' => true,
            'message' => __('donation_reports.rejected_successfully')
        ]);
    }

    /**
     * Search donation reports for Select2.
     */
    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = 10;

        $reports = DonationReport::with('donationCampaign')
            ->where('institution_name', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->orWhereHas('donationCampaign', function ($query) use ($term) {
                $query->where('title', 'like', "%{$term}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $results = $reports->map(function ($report) {
            return [
                'id' => $report->id,
                'text' => $report->institution_name . ' - ' . ($report->donationCampaign->title ?? 'N/A') . ' (' . $report->status . ')',
            ];
        });

        $total = $reports->total();

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }

    /**
     * Upload images for a donation report.
     */
    public function uploadImages(Request $request, DonationReport $donationReport)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max per image
        ]);

        $uploadedImages = [];
        $maxSortOrder = $donationReport->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('donation-reports/' . $donationReport->id, 'public');
            
            $donationReportImage = $donationReport->images()->create([
                'image_url' => $path,
                'alt_text' => $request->input('alt_text.' . $index, ''),
                'is_primary' => $donationReport->images()->count() === 0 && $index === 0, // First image is primary if no images exist
                'sort_order' => $maxSortOrder + $index + 1,
            ]);

            $uploadedImages[] = [
                'id' => $donationReportImage->id,
                'url' => asset('storage/' . $path),
                'alt_text' => $donationReportImage->alt_text,
                'is_primary' => $donationReportImage->is_primary,
                'sort_order' => $donationReportImage->sort_order,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => __('donation_reports.images_uploaded_successfully'),
            'images' => $uploadedImages
        ]);
    }

    /**
     * Delete an image from a donation report.
     */
    public function deleteImage(DonationReport $donationReport, DonationReportImage $image)
    {
        // Ensure the image belongs to this report
        if ($image->donation_report_id !== $donationReport->id) {
            return response()->json([
                'success' => false,
                'message' => __('common.unauthorized')
            ], 403);
        }

        // If this is the primary image, set another image as primary
        if ($image->is_primary) {
            $nextPrimaryImage = $donationReport->images()
                ->where('id', '!=', $image->id)
                ->orderBy('sort_order')
                ->first();
            
            if ($nextPrimaryImage) {
                $nextPrimaryImage->update(['is_primary' => true]);
            }
        }

        // Delete the image file from storage
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        // Delete the database record
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => __('donation_reports.image_deleted_successfully')
        ]);
    }

    /**
     * Set an image as primary for a donation report.
     */
    public function setPrimaryImage(DonationReport $donationReport, DonationReportImage $image)
    {
        // Ensure the image belongs to this report
        if ($image->donation_report_id !== $donationReport->id) {
            return response()->json([
                'success' => false,
                'message' => __('common.unauthorized')
            ], 403);
        }

        // Remove primary status from all images of this report
        $donationReport->images()->update(['is_primary' => false]);

        // Set this image as primary
        $image->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => __('donation_reports.primary_image_set_successfully')
        ]);
    }
}
