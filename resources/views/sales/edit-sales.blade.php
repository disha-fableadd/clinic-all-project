@extends('layout.app')

@section('title', 'Edit Sale #' . ($order->order_number ?? $order->id))

@section('content')
<style>
    .single-sale-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        background: #ffffff;
        margin-bottom: 20px;
    }
    .single-sale-card .card-body {
        padding: 20px 24px;
    }
    .form-group-compact {
        margin-bottom: 10px !important;
    }
    .form-group-compact label {
        font-size: 12px;
        font-weight: 600;
        color: #212b36;
        margin-bottom: 4px;
        display: block;
        white-space: nowrap;
    }
    .form-control, .form-select {
        height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 6px 16px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        background-color: #ffffff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 3px rgba(248, 152, 132, 0.25) !important;
        outline: none;
    }
    .btn-submit-main {
        background-color: #f89884 !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 13.5px;
        padding: 10px 24px !important;
        border-radius: 50px !important;
        box-shadow: 0 2px 6px rgba(248, 152, 132, 0.35);
        cursor: pointer;
    }
    .btn-back-main {
        background-color: #cfece0 !important;
        border: 1px solid #b5e4d2 !important;
        color: #1e293b !important;
        border-radius: 50px !important;
        font-weight: 600;
        font-size: 13px;
        padding: 6px 18px !important;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .pay-mode-btn {
        flex: 1;
        min-height: 44px;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 14px;
    }
    .pay-mode-btn.active {
        background-color: #cfece0 !important;
        border-color: #f89884 !important;
        color: #1e293b !important;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <!-- Top Toolbar Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h4 class="page-title mb-0" style="font-weight: 700; font-size: 21px; color: #1e293b;">
                    Sale Bill <span style="color: #f89884;">#{{ $order->order_number ?? $order->id }}</span>
                </h4>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('sales.invoice', $order->id) }}" class="btn btn-submit-main" style="padding: 6px 18px !important; font-size: 13px;">
                    <i class="fas fa-print me-1"></i> Print Invoice
                </a>
                <a href="{{ route('sales.list') }}" class="btn-back-main">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        @php
            $patient = $order->patients->first();
            $patientName = $patient ? $patient->name : ($order->patient_name ?? 'Walk-in Patient');
            $patientPhone = $patient ? ($patient->phone_number ?? $patient->phone) : ($order->patient_phone ?? '-');
        @endphp

        <!-- SINGLE UNIFIED CARD (Same Compact Layout) -->
        <div class="card single-sale-card">
            <div class="card-body">
                <!-- Row 1: Patient details -->
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-user-injured text-muted me-1"></i> Patient Name</label>
                            <input type="text" class="form-control" value="{{ $patientName }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-phone text-muted me-1"></i> Patient Phone</label>
                            <input type="text" class="form-control" value="{{ $patientPhone }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-6">
                        <div class="form-group-compact">
                            <label><i class="fas fa-calendar-alt text-muted me-1"></i> Age</label>
                            <input type="text" class="form-control" value="{{ $patient->age ?? ($order->patient_age ?? '-') }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-6">
                        <div class="form-group-compact">
                            <label><i class="fas fa-venus-mars text-muted me-1"></i> Sex</label>
                            <input type="text" class="form-control" value="{{ ucfirst($patient->gender ?? ($order->patient_sex ?? 'Male')) }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-1 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-heartbeat text-danger me-1"></i> B.P</label>
                            <input type="text" class="form-control" value="{{ $order->bp ?? ($patient->bp ?? '-') }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Vitals & Bill Date -->
                <div class="row mt-1 mb-2">
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="form-group-compact">
                            <label><i class="fas fa-thermometer-half text-warning me-1"></i> Temperature</label>
                            <input type="text" class="form-control" value="{{ $order->temperature ?? ($patient->temperature ?? '-') }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="form-group-compact">
                            <label><i class="fas fa-wave-square text-success me-1"></i> Pulse</label>
                            <input type="text" class="form-control" value="{{ $order->pulse ?? ($patient->pulse ?? '-') }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-file-medical-alt text-muted me-1"></i> Patient History</label>
                            <input type="text" class="form-control" value="{{ $order->patient_history ?? ($patient->patient_history ?? '-') }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-stethoscope text-muted me-1"></i> Patient Complaint</label>
                            <input type="text" class="form-control" value="{{ $order->patient_complaint ?? ($patient->patient_complaint ?? '-') }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-vial text-muted me-1"></i> Advice for Lab tests</label>
                            <input type="text" class="form-control" value="{{ $order->advice_for_lab_tests ?? ($patient->advice_for_lab_tests ?? '-') }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group-compact">
                            <label><i class="fas fa-calendar-day text-muted me-1"></i> Bill Date</label>
                            <input type="text" class="form-control" value="{{ date('d-M-Y', strtotime($order->order_date ?? $order->created_at)) }}" readonly>
                        </div>
                    </div>
                </div>

                <hr style="margin: 14px 0; border-color: #e2e8f0;">

                <!-- Items Table -->
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle mb-0">
                        <thead style="background-color: #cfece0; color: #1e293b; font-size: 12.5px;">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Medicine / Product</th>
                                <th>Batch</th>
                                <th>Expiry</th>
                                <th style="width: 80px;" class="text-center">Qty</th>
                                <th style="width: 100px;" class="text-end">Price (₹)</th>
                                <th style="width: 80px;" class="text-center">GST %</th>
                                <th style="width: 110px;" class="text-end">Total (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @forelse($order->order_items as $item)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td><strong>{{ $item->product ? $item->product->name : ($item->custom_product_name ?? 'Medicine') }}</strong></td>
                                    <td>{{ $item->batch_no ?? '-' }}</td>
                                    <td>{{ $item->expiry_date ?? '-' }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-center">{{ $item->tax_rate ?? 0 }}%</td>
                                    <td class="text-end fw-bold">₹{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-3 text-muted">No items in this order</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Charges & Summary -->
                <div class="row align-items-center mb-2">
                    <div class="col-lg-3 col-6">
                        <div class="form-group-compact">
                            <label>Shipping Charges</label>
                            <input type="text" class="form-control" value="₹{{ number_format($order->shipping ?? 0, 2) }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="form-group-compact">
                            <label>Misc Charges</label>
                            <input type="text" class="form-control" value="₹{{ number_format($order->misc_charges ?? 0, 2) }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="form-group-compact">
                            <label>Discount</label>
                            <input type="text" class="form-control" value="₹{{ number_format($order->discount_rate ?? 0, 2) }}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="form-group-compact">
                            <label>Remarks</label>
                            <input type="text" class="form-control" value="{{ $order->remarks ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="d-flex justify-content-between align-items-center py-2 px-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div>
                        <span class="text-muted" style="font-size: 13.5px;">Subtotal:</span>
                        <strong style="color: #1e293b; font-size: 14px;" class="ms-1">₹{{ number_format($order->subtotal ?? $order->total_amount, 2) }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 14.5px; font-weight: 700; color: #1e293b;">Grand Total:</span>
                        <span style="font-size: 18px; font-weight: 800; color: #f89884;" class="ms-1">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <!-- Payment Status Bar -->
                <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background: #cfece0; border: 1px solid #b5e4d2;">
                    <div>
                        <strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'Cash') }} | 
                        <strong>Status:</strong> <span class="badge" style="background: #155724; color: #fff;">{{ strtoupper($order->payment_status ?? 'PAID') }}</span>
                    </div>
                    <div>
                        <strong>Paid Amount:</strong> ₹{{ number_format($order->paid_amount ?? ($order->payment_status == 'paid' ? $order->total_amount : 0), 2) }}
                        @if(($order->remaining_amount ?? 0) > 0)
                            | <strong class="text-danger">Due:</strong> ₹{{ number_format($order->remaining_amount, 2) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
