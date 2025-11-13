<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationCampaignCreateRequest;
use App\Http\Requests\DonationCampaignUpdateRequest;
use App\Models\DonationCampaign;
use App\Models\DonationCampaignImage;
use App\Models\DonationTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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
        $tags = DonationTag::active()->ordered()->get();
        return view('admin.donation-campaigns.create', compact('tags'));
    }

    /**
     * Store a newly created donation campaign in storage.
     */
    public function store(DonationCampaignCreateRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        DB::transaction(function () use ($request, $data) {
            // Create the campaign
            $campaign = DonationCampaign::create($data);

            // Handle multiple image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('donation-campaigns', 'public');
                    
                    DonationCampaignImage::create([
                        'donation_campaign_id' => $campaign->id,
                        'image_url' => $imagePath,
                        'alt_text' => $request->input("image_alt.{$index}"),
                        'sort_order' => $index,
                        'is_primary' => $index === 0, // First image is primary
                    ]);
                }
            }

            // Handle tags
            if ($request->has('tags')) {
                $campaign->tags()->sync($request->input('tags', []));
            }
        });

        return redirect()->route('admin.donation-campaigns.index')
            ->with('success', __('donation_campaigns.created_successfully'));
    }

    /**
     * Display the specified donation campaign.
     */
    public function show(DonationCampaign $donationCampaign)
    {
        $donationCampaign->load(['creator', 'images', 'tags']);
        return view('admin.donation-campaigns.show', compact('donationCampaign'));
    }

    /**
     * Show the form for editing the specified donation campaign.
     */
    public function edit(DonationCampaign $donationCampaign)
    {
        $donationCampaign->load(['images', 'tags']);
        $tags = DonationTag::active()->ordered()->get();
        return view('admin.donation-campaigns.edit', compact('donationCampaign', 'tags'));
    }

    /**
     * Update the specified donation campaign in storage.
     */
    public function update(DonationCampaignUpdateRequest $request, DonationCampaign $donationCampaign)
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $data, $donationCampaign) {
            // Update campaign data
            $donationCampaign->update($data);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('donation-campaigns', 'public');
                    
                    DonationCampaignImage::create([
                        'donation_campaign_id' => $donationCampaign->id,
                        'image_url' => $imagePath,
                        'alt_text' => $request->input("image_alt.{$index}"),
                        'sort_order' => $donationCampaign->images()->count() + $index,
                        'is_primary' => $donationCampaign->images()->count() === 0 && $index === 0,
                    ]);
                }
            }

            // Handle image deletions
            if ($request->has('delete_images')) {
                $deleteIds = $request->input('delete_images', []);
                $imagesToDelete = $donationCampaign->images()->whereIn('id', $deleteIds)->get();
                
                foreach ($imagesToDelete as $image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }
            }

            // Handle tags
            if ($request->has('tags')) {
                $donationCampaign->tags()->sync($request->input('tags', []));
            }
        });

        return redirect()->route('admin.donation-campaigns.index')
            ->with('success', __('donation_campaigns.updated_successfully'));
    }

    /**
     * Remove the specified donation campaign from storage.
     */
    public function destroy(DonationCampaign $donationCampaign)
    {
        DB::transaction(function () use ($donationCampaign) {
            // Delete associated images
            foreach ($donationCampaign->images as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }

            // Delete old single image if exists (backward compatibility)
            if ($donationCampaign->image_url) {
                Storage::disk('public')->delete($donationCampaign->image_url);
            }

            // Delete the campaign (tags will be automatically detached due to cascade)
            $donationCampaign->delete();
        });

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

    /**
     * Upload new images for a campaign.
     */
    public function uploadImages(Request $request, DonationCampaign $donationCampaign)
    {
        $request->validate([
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $uploadedImages = collect();
        
        DB::transaction(function () use ($request, $donationCampaign, &$uploadedImages) {
            $currentImageCount = $donationCampaign->images()->count();
            
            foreach ($request->file('images') as $index => $file) {
                $imagePath = $file->store('donation-campaigns', 'public');
                
                $image = $donationCampaign->images()->create([
                    'image_url' => $imagePath,
                    'alt_text' => $request->input("image_alt.{$index}"),
                    'sort_order' => $currentImageCount + $index,
                    'is_primary' => $currentImageCount === 0 && $index === 0,
                ]);
                
                $uploadedImages->push($image);
            }
        });

        return response()->json([
            'success' => true,
            'message' => __('donation_campaigns.images_uploaded_successfully'),
            'images' => $uploadedImages->map(function($image) {
                return [
                    'id' => $image->id,
                    'image_url' => $image->image_url,
                    'alt_text' => $image->alt_text,
                    'is_primary' => $image->is_primary
                ];
            })
        ]);
    }

    /**
     * Delete a campaign image.
     */
    public function deleteImage(Request $request, DonationCampaign $donationCampaign)
    {
        $request->validate([
            'image_id' => 'required|exists:donation_campaign_images,id',
        ]);

        $image = $donationCampaign->images()->findOrFail($request->image_id);
        
        // Delete the file
        Storage::disk('public')->delete($image->image_url);
        
        // Delete the record
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => __('donation_campaigns.image_deleted_successfully')
        ]);
    }

    /**
     * Set primary image for a campaign.
     */
    public function setPrimaryImage(Request $request, DonationCampaign $donationCampaign)
    {
        $request->validate([
            'image_id' => 'required|exists:donation_campaign_images,id',
        ]);

        DB::transaction(function () use ($request, $donationCampaign) {
            // Remove primary flag from all images
            $donationCampaign->images()->update(['is_primary' => false]);
            
            // Set new primary image
            $donationCampaign->images()
                ->where('id', $request->image_id)
                ->update(['is_primary' => true]);
        });

        return response()->json([
            'success' => true,
            'message' => __('donation_campaigns.primary_image_updated')
        ]);
    }

    /**
     * Update campaign tags.
     */
    public function updateTags(Request $request, DonationCampaign $donationCampaign)
    {
        $request->validate([
            'tags' => 'nullable|array',
            'tags.*' => 'exists:donation_tags,id',
        ]);

        $donationCampaign->tags()->sync($request->input('tags', []));

        return response()->json([
            'success' => true,
            'message' => __('donation_campaigns.tags_updated_successfully')
        ]);
    }

    /**
     * Remove a single tag from campaign.
     */
    public function removeTag(Request $request, DonationCampaign $donationCampaign)
    {
        $request->validate([
            'tag_id' => 'required|exists:donation_tags,id',
        ]);

        $donationCampaign->tags()->detach($request->tag_id);

        return response()->json([
            'success' => true,
            'message' => __('donation_campaigns.tag_removed_successfully')
        ]);
    }
}
