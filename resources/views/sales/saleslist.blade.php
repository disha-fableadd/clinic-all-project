@extends('layout.app')

@section('title', 'Sale Bill List')

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
            <h3 class="mb-1" style="font-weight: 700; color: #1e293b;">Sale Bill</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">Manage sales invoices, customer receipts, and payment statuses</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('sales.add') }}" class="btn btn-clinic-primary pill-btn">
                <i class="fa fa-plus me-1"></i> New Sale Bill
            </a>
        </div>
    </div>

    <!-- KPI Summary Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: rgba(248, 152, 132, 0.18); color: #f89884;">
                    <i class="fa fa-receipt"></i>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 13px; font-weight: 600;">Total Sales</span>
                    <h4 class="mb-0 mt-1" style="font-weight: 700; color: #1e293b;">₹{{ number_format($totalSales ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: rgba(207, 236, 224, 0.6); color: #1f513f;">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 13px; font-weight: 600;">Total Received</span>
                    <h4 class="mb-0 mt-1" style="font-weight: 700; color: #155724;">₹{{ number_format($totalPaid ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #fff1f0; color: #e11d48;">
                    <i class="fa fa-clock"></i>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 13px; font-weight: 600;">Pending Balance</span>
                    <h4 class="mb-0 mt-1" style="font-weight: 700; color: #e11d48;">₹{{ number_format($totalRemaining ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card mb-4" style="border-radius: 20px; border: 1px solid #eef2f6; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('sales.list') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600;">From Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600;">To Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600;">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending / Unpaid</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-clinic-primary pill-btn flex-fill">
                        <i class="fa fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('sales.list') }}" class="btn btn-clinic-secondary pill-btn">
                        <i class="fa fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Table Card -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="salesTable">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th style="font-size: 13px; font-weight: 700; color: #475569; padding: 14px 16px;">Bill No</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569;">Date</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569;">Patient</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569;">Phone</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569;">Payment Mode</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569;">Total (₹)</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569;">Remaining (₹)</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569; text-align: center;">Status</th>
                        <th style="font-size: 13px; font-weight: 700; color: #475569; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $patient = $order->patients->first();
                            $patientName = $patient ? $patient->name : ($order->patient_name ?? 'Walk-in Patient');
                            $patientPhone = $patient ? ($patient->phone_number ?? $patient->phone) : ($order->patient_phone ?? '-');
                            $isPaid = strtolower($order->payment_status) == 'paid' || ($order->remaining_amount <= 0 && $order->total_amount > 0);
                        @endphp
                        <tr>
                            <td style="padding: 14px 16px;">
                                <strong style="color: #f89884;">#{{ $order->order_number ?? $order->id }}</strong>
                            </td>
                            <td>{{ date('d-M-Y', strtotime($order->order_date ?? $order->created_at)) }}</td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">{{ $patientName }}</div>
                            </td>
                            <td class="text-muted">{{ $patientPhone }}</td>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #475569; border-radius: 50px; padding: 5px 12px;">
                                    {{ ucfirst($order->payment_method ?? 'Cash') }}
                                </span>
                            </td>
                            <td>
                                <strong style="color: #1e293b;">₹{{ number_format($order->total_amount ?? 0, 2) }}</strong>
                            </td>
                            <td>
                                @if(($order->remaining_amount ?? 0) > 0)
                                    <span style="color: #e11d48; font-weight: 600;">₹{{ number_format($order->remaining_amount, 2) }}</span>
                                @else
                                    <span style="color: #155724; font-weight: 600;">₹0.00</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($isPaid)
                                    <span class="badge badge-paid">Paid</span>
                                @else
                                    <span class="badge badge-pending">Unpaid / Due</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('sales.invoice', $order->id) }}" class="action-btn" title="View / Print Invoice">
                                    <i class="fa fa-print"></i>
                                </a>
                                <a href="{{ route('sales.details', $order->id) }}" class="action-btn" title="Sale Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if(!$isPaid)
                                    <button type="button" class="action-btn" title="Receive Payment" onclick="openPaymentModal({{ $order->id }}, '{{ $order->order_number }}', {{ $order->remaining_amount ?? $order->total_amount }})">
                                        <i class="fa fa-credit-card text-success"></i>
                                    </button>
                                @endif
                                <button type="button" class="action-btn btn-delete" title="Delete Sale" onclick="confirmDeleteSale({{ $order->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa fa-inbox fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                                <p class="mb-0">No sales recorded yet. Click <strong>"+ New Sale Bill"</strong> to create one.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($orders, 'links'))
            <div class="mt-4 d-flex justify-content-end">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal: Quick Receive Payment -->
<div class="modal fade" id="makePaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: #f89884; color: #fff; padding: 18px 24px;">
                <h5 class="modal-title font-weight-bold" style="color: #fff;"><i class="fa fa-credit-card me-2"></i> Receive Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickPaymentForm">
                @csrf
                <input type="hidden" id="modal_order_id" name="order_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Bill No</label>
                        <input type="text" id="modal_bill_no" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Payment Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" id="modal_payment_amount" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Payment Mode</label>
                        <select class="form-select" id="modal_payment_mode" name="payment_mode">
                            <option value="Cash">Cash</option>
                            <option value="Online">Online / UPI</option>
                            <option value="Card">Debit / Credit Card</option>
                            <option value="Bank">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Notes (Optional)</label>
                        <input type="text" name="notes" class="form-control" placeholder="Transaction ref or note">
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary pill-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-clinic-primary pill-btn px-4">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openPaymentModal(orderId, billNo, remainingAmount) {
        $('#modal_order_id').val(orderId);
        $('#modal_bill_no').val(billNo);
        $('#modal_payment_amount').val(remainingAmount > 0 ? remainingAmount : '');
        var myModal = new bootstrap.Modal(document.getElementById('makePaymentModal'));
        myModal.show();
    }

    $('#quickPaymentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('api.sales.make-payment') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Recorded!',
                    text: 'Payment has been successfully updated.',
                    confirmButtonColor: '#f89884'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.responseJSON ? err.responseJSON.message : 'Failed to record payment',
                    confirmButtonColor: '#f89884'
                });
            }
        });
    });

    function confirmDeleteSale(orderId) {
        Swal.fire({
            title: 'Delete Sale Bill?',
            text: "This will delete the sale and restore the medicine stock quantities!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f89884',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/sales/delete/" + orderId,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Sale bill deleted and stock restored.',
                            confirmButtonColor: '#f89884'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed',
                            text: err.responseJSON ? err.responseJSON.message : 'Could not delete sale',
                            confirmButtonColor: '#f89884'
                        });
                    }
                });
            }
        });
    }
</script>
@endsection

