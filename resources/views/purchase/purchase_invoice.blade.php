@extends('layout.app')

@section('title', 'Purchase Invoice - #' . ($invoice->bill_no ?? $invoice->invoice_number))

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
        background: #cfece0;
        color: #1e293b;
        font-weight: 700;
        font-size: 13px;
        padding: 12px 14px;
        border-bottom: 2px solid #b5e4d2;
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

<div class="page-wrapper">
    <div class="content">
        <!-- Top Action Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap gap-2">
            <div>
                <h4 class="page-title mb-0" style="font-weight: 700; color: #1e293b;">
                    Purchase Bill <span style="color: #f89884;">#{{ $invoice->bill_no ?? $invoice->invoice_number }}</span>
                </h4>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('purchase.lists') }}" class="btn btn-outline-secondary pill-btn">
                    <i class="fa fa-arrow-left me-1"></i> Back to Bills
                </a>
                <button onclick="window.print()" class="btn btn-clinic-primary pill-btn">
                    <i class="fa fa-print me-1"></i> Print Bill
                </button>
            </div>
        </div>

        <!-- Printable Area -->
        <div id="printableArea" class="invoice-card">
            @php
                $vendor = $invoice->vendor;
                $vendorName = $vendor ? $vendor->name : ($invoice->vendor_name ?? 'Direct Supplier');
                $vendorPhone = $vendor ? $vendor->phone : ($invoice->vendor_phone ?? '-');
                $vendorAddress = $vendor ? ($vendor->address ?? '-') : '-';
                $vendorGst = $vendor ? ($vendor->gst_number ?? '-') : '-';

                $products = is_string($invoice->products) ? json_decode($invoice->products, true) : ($invoice->products ?? []);
                if (empty($products) && method_exists($invoice, 'purchases')) {
                    $products = $invoice->purchases;
                }
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
                    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 6px;">PURCHASE INVOICE</h4>
                    <div style="font-size: 13px;">
                        <strong>Bill No:</strong> <span style="color: #f89884; font-weight: 700;">{{ $invoice->bill_no ?? $invoice->invoice_number }}</span>
                    </div>
                    <div style="font-size: 13px;">
                        <strong>System Ref:</strong> #{{ $invoice->invoice_number }}
                    </div>
                    <div style="font-size: 13px;">
                        <strong>Date:</strong> {{ date('d-M-Y', strtotime($invoice->created_at)) }}
                    </div>
                    <div style="font-size: 13px;">
                        <strong>GST Option:</strong> {{ strtoupper($invoice->gst_option ?? 'GST') }}
                    </div>
                </div>
            </div>

            <!-- Supplier Details -->
            <div class="row mb-4 p-3 rounded" style="background: #fbfcfe; border: 1px solid #edf2f7; border-radius: 14px !important;">
                <div class="col-md-6 mb-2">
                    <h6 style="color: #f89884; font-weight: 700; margin-bottom: 8px;">Vendor / Supplier Information</h6>
                    <div style="font-size: 13px; line-height: 1.6;">
                        <strong>Supplier:</strong> {{ $vendorName }}<br>
                        <strong>Contact:</strong> {{ $vendorPhone }}<br>
                        <strong>Address:</strong> {{ $vendorAddress }}<br>
                        <strong>GSTIN:</strong> {{ $vendorGst }}
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <h6 style="color: #f89884; font-weight: 700; margin-bottom: 8px;">Billing & Credit Terms</h6>
                    <div style="font-size: 13px; line-height: 1.6;">
                        <strong>Due Date:</strong> {{ $invoice->due_date ? date('d-M-Y', strtotime($invoice->due_date)) : 'Immediate / N/A' }}<br>
                        <strong>Payment Due Days:</strong> {{ $invoice->payment_due_days ?? 0 }} days<br>
                        <strong>Interest Rate:</strong> {{ $invoice->interest_before_due ?? 0 }}% (Before) / {{ $invoice->interest_after_due ?? 0 }}% (After)<br>
                        <strong>Payment Mode:</strong> {{ ucfirst($invoice->payment_mode ?? 'Cash') }}
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive mb-4">
                <table class="table invoice-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Medicine / Item</th>
                            <th>Batch</th>
                            <th>Expiry</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Free</th>
                            <th class="text-end">Price (₹)</th>
                            <th class="text-end">MRP (₹)</th>
                            <th class="text-center">GST %</th>
                            <th class="text-end">Total (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sr = 1; @endphp
                        @forelse($products as $prod)
                            @php
                                $p = is_array($prod) ? (object)$prod : $prod;
                                $itemName = $p->item ?? $p->product_name ?? 'Medicine';
                                $batch = $p->batch_no ?? $p->batch ?? '-';
                                $expiry = $p->expiry ?? $p->expiry_date ?? '-';
                                $qty = $p->quantity ?? $p->qty ?? 1;
                                $freeQty = $p->free_quantity ?? $p->free_qty ?? 0;
                                $price = $p->purchase_price ?? $p->price ?? 0;
                                $mrp = $p->mrp ?? $price;
                                $gst = $p->gst ?? 0;
                                $total = $p->total ?? ($qty * $price);
                            @endphp
                            <tr>
                                <td>{{ $sr++ }}</td>
                                <td><strong>{{ $itemName }}</strong></td>
                                <td>{{ $batch }}</td>
                                <td>{{ $expiry }}</td>
                                <td class="text-center">{{ $qty }}</td>
                                <td class="text-center">{{ $freeQty }}</td>
                                <td class="text-end">{{ number_format($price, 2) }}</td>
                                <td class="text-end">{{ number_format($mrp, 2) }}</td>
                                <td class="text-center">{{ $gst }}%</td>
                                <td class="text-end font-weight-bold">{{ number_format($total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-3 text-muted">No items found for this purchase invoice</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary Totals -->
            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px !important;">
                        @if(($invoice->shipping ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                                <span>Shipping / Freight:</span>
                                <span>₹{{ number_format($invoice->shipping, 2) }}</span>
                            </div>
                        @endif
                        @if(($invoice->discount ?? 0) > 0)
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13px; color: #155724;">
                                <span>Discount:</span>
                                <span>-₹{{ number_format($invoice->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2" style="font-size: 16px; font-weight: 700; color: #f89884;">
                            <span>Grand Total:</span>
                            <span>₹{{ number_format($invoice->grand_total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13px; color: #155724; font-weight: 600;">
                            <span>Paid Amount:</span>
                            <span>₹{{ number_format($invoice->paid ?? 0, 2) }}</span>
                        </div>
                        @php $rem = $invoice->remaining_amount ?? max(0, $invoice->grand_total - ($invoice->paid ?? 0)); @endphp
                        @if($rem > 0)
                            <div class="d-flex justify-content-between" style="font-size: 14px; color: #e11d48; font-weight: 700;">
                                <span>Balance Due:</span>
                                <span>₹{{ number_format($rem, 2) }}</span>
                            </div>
                        @else
                            <div class="d-flex justify-content-between" style="font-size: 13px; color: #155724; font-weight: 600;">
                                <span>Payment Status:</span>
                                <span>PAID IN FULL</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Signatures & Notes -->
            <div class="row mt-5 pt-4 border-top">
                <div class="col-6 text-start">
                    <p class="text-muted mb-0" style="font-size: 12px;">Authorized Pharmacist / Receiver Signature</p>
                </div>
                <div class="col-6 text-end">
                    <p class="text-muted mb-0" style="font-size: 12px;">Supplier / Distributor Signature</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
