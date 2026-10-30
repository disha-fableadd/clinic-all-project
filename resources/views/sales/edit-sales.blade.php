@extends('layout.app')

@section('title', 'Sale Bill Details')

@section('content')
<style>
    .single-sale-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        background: #ffffff;
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
    .form-control, .form-select,
    .form-control[readonly], .form-control:disabled {
        height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 6px 16px !important;
        font-size: 13px !important;
        color: #000000 !important;
        background-color: #f8fafc;
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
        color: #000000 !important;
        border-radius: 50px !important;
        font-weight: 600;
        font-size: 13px;
        padding: 6px 18px !important;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    /* ITEM CARD FORMAT (Matching Image 1) */
    .sale-item-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 14px;
        margin-bottom: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .item-card-thumb {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        /* margin-right: 14px; */
    }
    .item-card-info-col {
        min-width: 170px;
        flex: 2;
        /* margin-right: 14px; */
    }
    .item-card-field {
        /* margin-right: 12px; */
    }
    .item-card-field:last-child {
        margin-right: 0;
    }
    .card-input-label {
        font-size: 10.5px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .pill-input {
        border-radius: 50px !important;
        height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        font-size: 13px !important;
        color: #000000 !important;
        background: #f8fafc;
        padding: 6px 14px !important;
    }
    .item-card-total {
        font-size: 20px;
        font-weight: 800;
        color: #f89884;
        letter-spacing: -0.5px;
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

        <!-- SINGLE UNIFIED CARD -->
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

                <!-- Total items bar -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge" style="background-color: #f8fafc; border: 1.5px solid #e2e8f0; color: #1e293b; font-size: 13.5px; font-weight: 700; border-radius: 50px; padding: 6px 16px;">
                        Total items : {{ count($order->order_items ?? []) }}
                    </span>
                </div>

                <!-- ITEMS LIST (CARD FORMAT - Clean Single Row) -->
                <div class="mb-3">
                    @forelse($order->order_items as $item)
                        @php
                            $prodName = $item->product ? $item->product->name : ($item->custom_product_name ?? 'Medicine');
                            $lineTot = $item->subtotal ?? ($item->quantity * $item->unit_price);
                            $discPercent = $item->discount_percent ?? 0;
                            $discRate = ($item->quantity * $item->unit_price) * ($discPercent / 100);
                            $rawImg = $item->product ? ($item->product->image ?? null) : null;
                            $imgSrc = null;
                            if (!empty($rawImg)) {
                                $trimmed = trim($rawImg);
                                if (str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://') || str_starts_with($trimmed, 'data:')) {
                                    $imgSrc = $trimmed;
                                } else {
                                    $imgSrc = url(ltrim($trimmed, '/'));
                                }
                            }
                        @endphp
                        <div class="sale-item-card">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                <!-- Thumbnail -->
                                <div class="item-card-thumb">
                                    @if($imgSrc)
                                        <img src="{{ $imgSrc }}" alt="{{ $prodName }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
                                        <div style="display:none; width:100%; height:100%; align-items:center; justify-content:center;">
                                            <i class="fas fa-pills text-muted" style="font-size: 22px;"></i>
                                        </div>
                                    @else
                                        <i class="fas fa-pills text-muted" style="font-size: 22px;"></i>
                                    @endif
                                </div>

                                <!-- Medicine Name -->
                                <div class="item-card-info-col">
                                    <strong style="font-size: 14.5px; color: #1e293b; display: block; line-height: 1.3;" class="mb-1">{{ $prodName }}</strong>
                                    @if($item->tax_rate)
                                        <span class="badge" style="background-color: #f1f5f9; color: #64748b; font-weight: 600; border-radius: 50px; font-size: 11px; padding: 3px 8px;">GST: {{ $item->tax_rate }}%</span>
                                    @endif
                                </div>

                                <!-- Single Row Inputs with explicit margins -->
                                <div class="item-card-field" style="min-width: 115px; flex: 1;">
                                    <label class="card-input-label">BATCH NO</label>
                                    <input type="text" class="form-control form-control-sm pill-input" value="{{ $item->batch_no ?? '-' }}" readonly>
                                </div>
                                <div class="item-card-field" style="min-width: 125px; flex: 1;">
                                    <label class="card-input-label">EXP</label>
                                    <input type="text" class="form-control form-control-sm pill-input" value="{{ $item->expiry_date ?? '-' }}" readonly>
                                </div>
                                <div class="item-card-field" style="width: 85px; flex-shrink: 0;">
                                    <label class="card-input-label text-center">QTY</label>
                                    <input type="text" class="form-control form-control-sm pill-input text-center" value="{{ $item->quantity }}" readonly>
                                </div>
                                <div class="item-card-field" style="min-width: 95px; flex: 1;">
                                    <label class="card-input-label text-center">MRP</label>
                                    <input type="text" class="form-control form-control-sm pill-input text-center" value="₹{{ number_format($item->unit_price, 2) }}" readonly>
                                </div>
                                <div class="item-card-field" style="width: 80px; flex-shrink: 0;">
                                    <label class="card-input-label text-center">DISC %</label>
                                    <input type="text" class="form-control form-control-sm pill-input text-center" value="{{ $discPercent }}%" readonly>
                                </div>
                                <div class="item-card-field" style="min-width: 95px; flex: 1;">
                                    <label class="card-input-label text-center">DISC RATE</label>
                                    <input type="text" class="form-control form-control-sm pill-input text-center" value="₹{{ number_format($discRate, 2) }}" readonly>
                                </div>
                                <div class="item-card-field text-end" style="min-width: 90px; flex-shrink: 0;">
                                    <label class="card-input-label text-end">TOTAL</label>
                                    <div class="item-card-total" style="font-size: 19px; line-height: 38px;">₹{{ number_format($lineTot, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted bg-light rounded-4">
                            No items found in this order
                        </div>
                    @endforelse
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

                <!-- Subtotal & Grand Total -->
                <div class="d-flex justify-content-between align-items-center py-2 px-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div>
                        <span class="text-muted" style="font-size: 13.5px;">Subtotal:</span>
                        <strong style="color: #1e293b; font-size: 14px;" class="ms-1">₹{{ number_format($order->subtotal ?? 0, 2) }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 14.5px; font-weight: 700; color: #1e293b;">Grand Total:</span>
                        <span style="font-size: 18px; font-weight: 800; color: #f89884;" class="ms-1">₹{{ number_format($order->total_amount ?? 0, 2) }}</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-1 mb-2">
                        <i class="far fa-folder-open text-warning"></i>
                        <span style="font-size: 13px; font-weight: 700; color: #1e293b;">Payment Mode</span>
                    </div>
                    <span class="badge" style="background-color: #cfece0; color: #000000; font-size: 13px; font-weight: 600; border-radius: 50px; padding: 8px 18px;">
                        <i class="fas fa-check-circle text-success me-1"></i> {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'Cash')) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection