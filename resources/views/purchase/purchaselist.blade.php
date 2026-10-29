@extends('layout.app')

@section('title', 'Purchase Bill List')

@section('content')
<style>
    :root {
        --clinic-primary: #f89884;
        --clinic-secondary: #cfece0;
        --clinic-dark: #2c3e50;
    }

    .pill-btn {
        border-radius: 50px !important;
        font-weight: 600;
        padding: 8px 22px;
        transition: all 0.25s ease;
    }

    .btn-clinic-primary {
        background-color: #f89884 !important;
        border-color: #f89884 !important;
        color: #ffffff !important;
    }
    .btn-clinic-primary:hover {
        background-color: #f6816a !important;
        border-color: #f6816a !important;
        color: #ffffff !important;
    }

    .btn-clinic-secondary {
        background-color: #cfece0 !important;
        border-color: #cfece0 !important;
        color: #1f513f !important;
    }
    .btn-clinic-secondary:hover {
        background-color: #b8e2d1 !important;
        color: #143e30 !important;
    }

    .form-control, .form-select {
        border-radius: 50px !important;
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        padding: 6px 18px !important;
        font-size: 13.5px !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 3px rgba(248, 152, 132, 0.25) !important;
    }

    .kpi-card {
        border-radius: 20px;
        border: 1px solid #eef2f6;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        background: #ffffff;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
    }
    .kpi-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .table-card {
        border-radius: 20px;
        border: 1px solid #eef2f6;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        background: #ffffff;
        padding: 24px;
        margin-top: 20px;
    }

    .badge-paid {
        background-color: #cfece0 !important;
        color: #155724 !important;
        border-radius: 50px !important;
        padding: 6px 14px;
        font-weight: 600;
        font-size: 12px;
    }
    .badge-partial {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border-radius: 50px !important;
        padding: 6px 14px;
        font-weight: 600;
        font-size: 12px;
    }
    .badge-pending {
        background-color: #ffe6e0 !important;
        color: #d9534f !important;
        border-radius: 50px !important;
        padding: 6px 14px;
        font-weight: 600;
        font-size: 12px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50% !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 3px;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #475569;
        transition: all 0.2s;
    }
    .action-btn:hover {
        background: #f89884;
        color: #fff;
        border-color: #f89884;
    }
    .action-btn.btn-delete:hover {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h3 class="page-title mb-1" style="font-weight: 700; color: #1e293b;">Purchase Bill</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Manage vendor purchases, inventory receipts, and supplier payables</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('purchase.ai-bill') }}" class="btn btn-clinic-secondary pill-btn">
                    <i class="fa fa-magic me-1"></i> AI Bill Upload
                </a>
                <a href="{{ route('purchase.add') }}" class="btn btn-clinic-primary pill-btn">
                    <i class="fa fa-plus me-1"></i> New Purchase Bill
                </a>
            </div>
        </div>

        <!-- KPI Summary Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(248, 152, 132, 0.18); color: #f89884;">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div>
                        <span class="text-muted" style="font-size: 13px; font-weight: 600;">Total Purchases</span>
                        <h4 class="mb-0 mt-1" style="font-weight: 700; color: #1e293b;">₹{{ number_format($totalPurchases ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: rgba(207, 236, 224, 0.6); color: #1f513f;">
                        <i class="fa fa-check-double"></i>
                    </div>
                    <div>
                        <span class="text-muted" style="font-size: 13px; font-weight: 600;">Total Paid to Vendors</span>
                        <h4 class="mb-0 mt-1" style="font-weight: 700; color: #155724;">₹{{ number_format($totalPaid ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background: #fff1f0; color: #e11d48;">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                    <div>
                        <span class="text-muted" style="font-size: 13px; font-weight: 600;">Pending Payables</span>
                        <h4 class="mb-0 mt-1" style="font-weight: 700; color: #e11d48;">₹{{ number_format($totalRemaining ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card mb-4" style="border-radius: 20px; border: 1px solid #eef2f6; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('purchase.lists') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px; font-weight: 600;">Supplier / Vendor</label>
                        <select name="vendor_id" class="form-select">
                            <option value="">All Suppliers</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px; font-weight: 600;">From Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px; font-weight: 600;">To Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-clinic-primary pill-btn flex-fill">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('purchase.lists') }}" class="btn btn-clinic-secondary pill-btn">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Purchases Table Card -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="purchasesTable">
                    <thead style="background: #cfece0; color: #1e293b; border-bottom: 2px solid #b5e4d2;">
                        <tr>
                            <th style="font-size: 13px; font-weight: 700; padding: 14px 16px;">Bill No</th>
                            <th style="font-size: 13px; font-weight: 700;">Purchase Date</th>
                            <th style="font-size: 13px; font-weight: 700;">Vendor / Supplier</th>
                            <th style="font-size: 13px; font-weight: 700;">Contact</th>
                            <th style="font-size: 13px; font-weight: 700;">Grand Total (₹)</th>
                            <th style="font-size: 13px; font-weight: 700;">Paid (₹)</th>
                            <th style="font-size: 13px; font-weight: 700;">Balance Due (₹)</th>
                            <th style="font-size: 13px; font-weight: 700; text-align: center;">Status</th>
                            <th style="font-size: 13px; font-weight: 700; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $item)
                            @php
                                $vendorName = $item->vendor ? $item->vendor->name : ($item->vendor_name ?? 'Direct Supplier');
                                $vendorPhone = $item->vendor ? $item->vendor->phone : ($item->vendor_phone ?? '-');
                                $paid = $item->paid ?? 0;
                                $total = $item->grand_total ?? 0;
                                $remaining = $item->remaining_amount ?? max(0, $total - $paid);
                            @endphp
                            <tr>
                                <td style="padding: 14px 16px;">
                                    <strong style="color: #f89884;">{{ $item->bill_no ?? $item->invoice_number }}</strong>
                                    <div class="text-muted" style="font-size: 11px;">#{{ $item->invoice_number }}</div>
                                </td>
                                <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                                <td>
                                    <div style="font-weight: 600; color: #1e293b;">{{ $vendorName }}</div>
                                </td>
                                <td class="text-muted">{{ $vendorPhone }}</td>
                                <td>
                                    <strong style="color: #1e293b;">₹{{ number_format($total, 2) }}</strong>
                                </td>
                                <td>
                                    <span style="color: #155724; font-weight: 600;">₹{{ number_format($paid, 2) }}</span>
                                </td>
                                <td>
                                    @if($remaining > 0)
                                        <span style="color: #e11d48; font-weight: 600;">₹{{ number_format($remaining, 2) }}</span>
                                    @else
                                        <span style="color: #155724; font-weight: 600;">₹0.00</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($remaining <= 0 && $total > 0)
                                        <span class="badge badge-paid">Paid</span>
                                    @elseif($paid > 0)
                                        <span class="badge badge-partial">Partial</span>
                                    @else
                                        <span class="badge badge-pending">Unpaid</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('purchase.invoice', $item->id) }}" class="action-btn" title="View / Print Purchase Bill">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <button type="button" class="action-btn btn-delete" title="Delete Purchase" onclick="confirmDeletePurchase({{ $item->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fa fa-inbox fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                                    <p class="mb-0">No purchase bills found. Click <strong>"+ New Purchase Bill"</strong> to record stock.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($purchases, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $purchases->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeletePurchase(id) {
        Swal.fire({
            title: 'Delete Purchase Bill?',
            text: "This will remove the purchase record and adjust the medicine inventory quantity!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f89884',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/purchase_delete",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Purchase bill removed successfully.',
                            confirmButtonColor: '#f89884'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed',
                            text: err.responseJSON ? err.responseJSON.message : 'Could not delete purchase record',
                            confirmButtonColor: '#f89884'
                        });
                    }
                });
            }
        });
    }
</script>
@endsection
