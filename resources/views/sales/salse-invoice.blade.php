@extends('layout.app')

@section('title', 'Sale Invoice - #' . ($order->order_number ?? $order->id))

@section('content')
<style>
    .invoice-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 40px;
        margin-bottom: 30px;
        border: 1px solid #eef2f6;
    }
    .pill-btn {
        border-radius: 50px !important;
        font-weight: 600;
        padding: 8px 24px;
    }
    .btn-clinic-primary {
        background-color: #f89884 !important;
        border-color: #f89884 !important;
        color: #fff !important;
    }
    .btn-clinic-secondary {
        background-color: #cfece0 !important;
        border-color: #cfece0 !important;
        color: #1f513f !important;
    }
    .invoice-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 13px;
        padding: 12px 14px;
        border-bottom: 2px solid #e2e8f0;
    }
    .invoice-table td {
        padding: 12px 14px;
        font-size: 13px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #printableArea, #printableArea * {
            visibility: visible;
        }
        #printableArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="page-wrapper" style="padding: 25px 30px;">
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap gap-2">
        <div>
            <h4 class="mb-0" style="font-weight: 700; color: #1e293b;">
                Sale Invoice <span style="color: #f89884;">#{{ $order->order_number ?? $order->id }}</span>
            </h4>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('sales.list') }}" class="btn btn-outline-secondary pill-btn">
                <i class="fa fa-arrow-left me-1"></i> Back to Bills
            </a>
            <button onclick="window.print()" class="btn btn-clinic-primary pill-btn">
                <i class="fa fa-print me-1"></i> Print Invoice
            </button>
        </div>
    </div>

    <!-- Printable Invoice Container -->
    <div id="printableArea" class="invoice-card">
        @php
            $patient = $order->patients->first();
            $patientName = $patient ? $patient->name : ($order->patient_name ?? 'Walk-in Patient');
            $patientPhone = $patient ? ($patient->phone_number ?? $patient->phone) : ($order->patient_phone ?? '-');
            $patientAge = $patient ? ($patient->age ?? '-') : ($order->patient_age ?? '-');
            $patientSex = $patient ? ($patient->gender ?? '-') : ($order->patient_sex ?? '-');
        @endphp

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4 flex-wrap gap-3">
            <div>
                <h3 style="color: #f89884; font-weight: 800; margin-bottom: 4px;">{{ $setting->name ?? 'CLINIC & PHARMACY' }}</h3>
                <p class="text-muted mb-1" style="font-size: 13px;">{{ $setting->address ?? 'Healthcare & Pharmacy Services' }}</p>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    <i class="fa fa-phone me-1"></i> {{ $setting->phone ?? '+91 98765 43210' }} | 
                    <i class="fa fa-envelope ms-2 me-1"></i> {{ $setting->email ?? 'info@clinicpharmacy.com' }}
                </p>
            </div>
            <div class="text-end">
                <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 6px;">TAX INVOICE</h4>
                <div style="font-size: 13px;">
                    <strong>Bill No:</strong> <span style="color: #f89884; font-weight: 700;">#{{ $order->order_number ?? $order->id }}</span>
                </div>
                <div style="font-size: 13px;">
                    <strong>Date:</strong> {{ date('d-M-Y', strtotime($order->order_date ?? $order->created_at)) }}
                </div>
                <div style="font-size: 13px;">
                    <strong>GST Option:</strong> {{ strtoupper($order->gst_option ?? 'GST') }}
                </div>
            </div>
        </div>

        <!-- Patient & Clinical Details -->
        <div class="row mb-4 p-3 rounded" style="background: #fbfcfe; border: 1px solid #edf2f7; border-radius: 14px !important;">
            <div class="col-md-6 mb-2">
                <h6 style="color: #f89884; font-weight: 700; margin-bottom: 8px;">Patient Information</h6>
                <div style="font-size: 13px; line-height: 1.6;">
                    <strong>Name:</strong> {{ $patientName }}<br>
                    <strong>Phone:</strong> {{ $patientPhone }}<br>
                    <strong>Age / Gender:</strong> {{ $patientAge }} yrs / {{ ucfirst($patientSex) }}
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <h6 style="color: #f89884; font-weight: 700; margin-bottom: 8px;">Clinical Vitals</h6>
                <div style="font-size: 13px; line-height: 1.6;">
                    <strong>B.P:</strong> {{ $order->bp ?? ($patient->bp ?? '-') }} | 
                    <strong>Temp:</strong> {{ $order->temperature ?? ($patient->temperature ?? '-') }} | 
                    <strong>Pulse:</strong> {{ $order->pulse ?? ($patient->pulse ?? '-') }}<br>
                    @if($order->patient_complaint || ($patient && $patient->patient_complaint))
                        <strong>Complaint:</strong> {{ $order->patient_complaint ?? $patient->patient_complaint }}<br>
                    @endif
                    @if($order->advice_for_lab_tests || ($patient && $patient->advice_for_lab_tests))
                        <strong>Advice / Lab:</strong> {{ $order->advice_for_lab_tests ?? $patient->advice_for_lab_tests }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-responsive mb-4">
            <table class="table invoice-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Medicine / Product</th>
                        <th>Batch</th>
                        <th>Expiry</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Price (₹)</th>
                        <th class="text-end">MRP (₹)</th>
                        <th class="text-center">GST %</th>
                        <th class="text-end">Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sr = 1; @endphp
                    @forelse($order->order_items as $item)
                        <tr>
                            <td>{{ $sr++ }}</td>
                            <td>
                                <strong>{{ $item->product ? $item->product->name : ($item->custom_product_name ?? 'Item') }}</strong>
                            </td>
                            <td>{{ $item->batch_no ?? '-' }}</td>
                            <td>{{ $item->expiry_date ?? '-' }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">{{ number_format($item->mrp ?? $item->unit_price, 2) }}</td>
                            <td class="text-center">{{ $item->tax_rate ?? 0 }}%</td>
                            <td class="text-end font-weight-bold">{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-3 text-muted">No items found in this order</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary Totals -->
        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px !important;">
                    <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                        <span>Subtotal:</span>
                        <strong>₹{{ number_format($order->subtotal ?? ($order->total_amount - ($order->shipping ?? 0) - ($order->misc_charges ?? 0) + ($order->discount_rate ?? 0)), 2) }}</strong>
                    </div>
                    @if(($order->shipping ?? 0) > 0)
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                            <span>Shipping Charges:</span>
                            <span>₹{{ number_format($order->shipping, 2) }}</span>
                        </div>
                    @endif
                    @if(($order->misc_charges ?? 0) > 0)
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                            <span>Misc Charges:</span>
                            <span>₹{{ number_format($order->misc_charges, 2) }}</span>
                        </div>
                    @endif
                    @if(($order->discount_rate ?? 0) > 0)
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13px; color: #155724;">
                            <span>Discount:</span>
                            <span>-₹{{ number_format($order->discount_rate, 2) }}</span>
                        </div>
                    @endif
                    <hr style="margin: 8px 0; border-color: #cbd5e1;">
                    <div class="d-flex justify-content-between mb-2" style="font-size: 16px; font-weight: 700; color: #f89884;">
                        <span>Grand Total:</span>
                        <span>₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size: 13px; color: #155724; font-weight: 600;">
                        <span>Paid Amount:</span>
                        <span>₹{{ number_format($order->paid_amount ?? ($order->payment_status == 'paid' ? $order->total_amount : 0), 2) }}</span>
                    </div>
                    @if(($order->remaining_amount ?? 0) > 0)
                        <div class="d-flex justify-content-between" style="font-size: 14px; color: #e11d48; font-weight: 700;">
                            <span>Remaining Due:</span>
                            <span>₹{{ number_format($order->remaining_amount, 2) }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-3 text-end text-muted" style="font-size: 12px;">
                    Payment Mode: <strong>{{ ucfirst($order->payment_method ?? 'Cash') }}</strong> | Status: <strong>{{ strtoupper($order->payment_status ?? 'PAID') }}</strong>
                </div>
            </div>
        </div>

        <!-- Footer Notes -->
        <div class="border-top pt-4 mt-5 text-center text-muted" style="font-size: 12px;">
            <p class="mb-1">Thank you for visiting! Wishing you good health and a speedy recovery.</p>
            <p class="mb-0">This is a computer-generated invoice and requires no physical signature.</p>
        </div>
    </div>
</div>
@endsection

