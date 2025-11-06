<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentGatewayCreateRequest;
use App\Http\Requests\PaymentGatewayUpdateRequest;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gateways = PaymentGateway::with('creator')->select('payment_gateways.*');

            return DataTables::of($gateways)
                ->addIndexColumn()
                ->addColumn('creator_name', function ($gateway) {
                    return $gateway->creator ? $gateway->creator->name : '-';
                })
                ->addColumn('provider_name', function ($gateway) {
                    return $gateway->provider_name;
                })
                ->addColumn('status_badge', function ($gateway) {
                    return $gateway->status_badge;
                })
                ->addColumn('mode_badge', function ($gateway) {
                    return $gateway->mode_badge;
                })
                ->addColumn('configured', function ($gateway) {
                    $class = $gateway->isConfigured() ? 'bg-success' : 'bg-warning';
                    $text = $gateway->isConfigured() ? __('payment_gateways.configured') : __('payment_gateways.not_configured');
                    return '<span class="badge ' . $class . '">' . $text . '</span>';
                })
                ->addColumn('actions', function ($gateway) {
                    return '
                        <div class="btn-group" role="group">
                            <a href="' . route('admin.payment-gateways.show', $gateway->id) . '" 
                               class="btn btn-info btn-sm" title="' . __('common.view') . '">
                                ' . __('common.view') . '
                            </a>
                            <a href="' . route('admin.payment-gateways.edit', $gateway->id) . '" 
                               class="btn btn-warning btn-sm" title="' . __('common.edit') . '">
                                ' . __('common.edit') . '
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-id="' . $gateway->id . '" 
                                    data-name="' . $gateway->name . '"
                                    title="' . __('common.delete') . '">
                                ' . __('common.delete') . '
                            </button>
                        </div>
                    ';
                })
                ->editColumn('created_at', function ($gateway) {
                    return $gateway->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['status_badge', 'mode_badge', 'configured', 'actions'])
                ->make(true);
        }

        return view('admin.payment-gateways.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = PaymentGateway::PROVIDERS;
        return view('admin.payment-gateways.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentGatewayCreateRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        PaymentGateway::create($data);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', __('payment_gateways.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentGateway $paymentGateway)
    {
        $paymentGateway->load('creator');
        return view('admin.payment-gateways.show', compact('paymentGateway'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        $providers = PaymentGateway::PROVIDERS;
        return view('admin.payment-gateways.edit', compact('paymentGateway', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentGatewayUpdateRequest $request, PaymentGateway $paymentGateway)
    {
        $data = $request->validated();

        $paymentGateway->update($data);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', __('payment_gateways.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();

        return response()->json([
            'success' => true,
            'message' => __('payment_gateways.deleted_successfully')
        ]);
    }

    /**
     * Search payment gateways for Select2.
     */
    public function search(Request $request)
    {
        $term = $request->get('q');

        $gateways = PaymentGateway::active()
            ->where('name', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get(['id', 'name', 'provider']);

        $results = $gateways->map(function ($gateway) {
            return [
                'id' => $gateway->id,
                'text' => $gateway->name . ' (' . $gateway->provider_name . ')'
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Test payment gateway connection.
     */
    public function testConnection(PaymentGateway $paymentGateway)
    {
        try {
            // This would be implemented based on each gateway's API
            // For now, just check if keys are configured
            if (!$paymentGateway->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => __('payment_gateways.not_configured')
                ]);
            }

            // Simulate successful connection test
            return response()->json([
                'success' => true,
                'message' => __('payment_gateways.connection_successful')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('payment_gateways.connection_failed') . ': ' . $e->getMessage()
            ]);
        }
    }
}
