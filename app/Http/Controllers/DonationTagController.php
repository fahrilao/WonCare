<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonationTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DonationTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tags = DonationTag::with('creator')->select('donation_tags.*');

            return DataTables::of($tags)
                ->addIndexColumn()
                ->addColumn('name_display', function ($tag) {
                    return '<div class="d-flex align-items-center gap-2">' .
                        '<span>' . e($tag->name) . '</span>' .
                        '</div>';
                })
                ->addColumn('status', function ($tag) {
                    return $tag->status_badge;
                })
                ->addColumn('created_at', function ($tag) {
                    return $tag->created_at->format('Y-m-d, H:i:s');
                })
                ->addColumn('creator_name', function ($tag) {
                    return $tag->creator ? e($tag->creator->name) : '-';
                })
                ->addColumn('action', function ($tag) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.donation-tags.show', $tag) . '" class="btn btn-sm btn-info" title="View">' . __('common.view') . '</a>';
                    $actions .= '<a href="' . route('admin.donation-tags.edit', $tag) . '" class="btn btn-sm btn-warning" title="Edit">' . __('common.edit') . '</a>';
                    $actions .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $tag->id . '" title="Delete">' . __('common.delete') . '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['name_display', 'status', 'action'])
                ->make(true);
        }

        return view('admin.donation-tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.donation-tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:donation_tags,slug',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (DonationTag::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['created_by'] = auth()->id();
        $tag = DonationTag::create($validated);

        return redirect()
            ->route('admin.donation-tags.index')
            ->with('success', __('donation_tags.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(DonationTag $donationTag)
    {
        $donationTag->load('creator');
        return view('admin.donation-tags.show', compact('donationTag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DonationTag $donationTag)
    {
        return view('admin.donation-tags.edit', compact('donationTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DonationTag $donationTag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:donation_tags,slug,' . $donationTag->id,
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure unique slug
        if ($validated['slug'] !== $donationTag->slug) {
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (DonationTag::where('slug', $validated['slug'])->where('id', '!=', $donationTag->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $donationTag->update($validated);

        return redirect()
            ->route('admin.donation-tags.index')
            ->with('success', __('donation_tags.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DonationTag $donationTag)
    {
        try {
            $donationTag->delete();

            return response()->json([
                'success' => true,
                'message' => __('donation_tags.deleted_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('common.error')
            ], 500);
        }
    }

    /**
     * Search tags for Select2
     */
    public function search(Request $request)
    {
        $search = $request->get('q');

        $tags = DonationTag::active()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->ordered()
            ->limit(20)
            ->get(['id', 'name', 'color']);

        return response()->json([
            'results' => $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name,
                    'color' => $tag->color,
                ];
            })
        ]);
    }
}
