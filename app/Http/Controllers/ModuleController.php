<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleCreateRequest;
use App\Http\Requests\ModuleUpdateRequest;
use App\Models\Module;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ModuleController extends Controller
{
    /**
     * Display a listing of the modules.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $modules = Module::with('class')->select(['id', 'class_id', 'title', 'position', 'created_at']);

            return DataTables::of($modules)
                ->addIndexColumn()
                ->addColumn('class_title', function ($module) {
                    return $module->class ? $module->class->title : '-';
                })
                ->addColumn('action', function ($module) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.modules.show', $module->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
                    $actions .= '<a href="' . route('admin.modules.edit', $module->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
                    $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('datatable.modules.delete_title') . '" data-item="' . $module->title . '" data-url="' . route('admin.modules.destroy', $module->id) . '">' . __('common.delete') . '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('created_at', function ($module) {
                    return $module->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.modules.index');
    }

    /**
     * Show the form for creating a new module.
     */
    public function create()
    {
        $classes = ClassModel::orderBy('title')->get();
        return view('admin.modules.create', compact('classes'));
    }

    /**
     * Store a newly created module in storage.
     */
    public function store(ModuleCreateRequest $request)
    {
        $validated = $request->validated();
        
        // Auto-set position if not provided
        if (empty($validated['position'])) {
            $maxPosition = Module::where('class_id', $validated['class_id'])->max('position');
            $validated['position'] = ($maxPosition ?? 0) + 1;
        } else {
            // If position is specified, shift existing modules at or after this position
            Module::where('class_id', $validated['class_id'])
                ->where('position', '>=', $validated['position'])
                ->increment('position');
        }

        Module::create($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified module.
     */
    public function show(Module $module)
    {
        $module->load('class');
        return view('admin.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified module.
     */
    public function edit(Module $module)
    {
        $classes = ClassModel::orderBy('title')->get();
        $module->load('class');
        return view('admin.modules.edit', compact('module', 'classes'));
    }

    /**
     * Update the specified module in storage.
     */
    public function update(ModuleUpdateRequest $request, Module $module)
    {
        $validated = $request->validated();
        
        $oldPosition = $module->position;
        $oldClassId = $module->class_id;
        $newPosition = $validated['position'];
        $newClassId = $validated['class_id'];
        
        // Auto-set position if not provided
        if (empty($newPosition)) {
            $maxPosition = Module::where('class_id', $newClassId)->max('position');
            $newPosition = ($maxPosition ?? 0) + 1;
            $validated['position'] = $newPosition;
        }

        // Handle position updates within the same class
        if ($oldClassId == $newClassId && $oldPosition != $newPosition) {
            if ($newPosition < $oldPosition) {
                // Moving up: shift modules down that are between new and old position
                Module::where('class_id', $newClassId)
                    ->where('position', '>=', $newPosition)
                    ->where('position', '<', $oldPosition)
                    ->where('id', '!=', $module->id)
                    ->increment('position');
            } else {
                // Moving down: shift modules up that are between old and new position
                Module::where('class_id', $newClassId)
                    ->where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->where('id', '!=', $module->id)
                    ->decrement('position');
            }
        }
        // Handle moving to different class
        else if ($oldClassId != $newClassId) {
            // Shift modules up in old class that are after the old position
            Module::where('class_id', $oldClassId)
                ->where('position', '>', $oldPosition)
                ->decrement('position');
            
            // Shift modules down in new class that are at or after the new position
            Module::where('class_id', $newClassId)
                ->where('position', '>=', $newPosition)
                ->increment('position');
        }

        $module->update($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified module from storage.
     */
    public function destroy(Module $module)
    {
        $classId = $module->class_id;
        $position = $module->position;
        
        $module->delete();

        // Shift remaining modules up to fill the gap
        Module::where('class_id', $classId)
            ->where('position', '>', $position)
            ->decrement('position');

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module deleted successfully.');
    }

    /**
     * Search modules for Select2 API
     */
    public function search(Request $request)
    {
        $term = $request->get('q');
        $classId = $request->get('class_id');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Module::with('class')->select(['id', 'class_id', 'title', 'position'])
            ->when($term, function ($query, $term) {
                return $query->where('title', 'LIKE', "%{$term}%");
            })
            ->when($classId, function ($query, $classId) {
                return $query->where('class_id', $classId);
            })
            ->orderBy('position');

        $total = $query->count();
        $modules = $query->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $results = $modules->map(function ($module) {
            return [
                'id' => $module->id,
                'text' => $module->title . ' (' . ($module->class ? $module->class->title : 'No Class') . ')',
                'title' => $module->title,
                'position' => $module->position,
                'class_id' => $module->class_id,
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}
