@extends('layout.app')

@section('content')
<style>
    /* Site Theme: #f89884 and #cfece0 with 50% pill radius on fields and buttons */
    .ledger-filter-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        background: #ffffff;
    }
    .ledger-stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        border-left: 5px solid #f89884;
    }
    .ledger-stat-val {
        font-size: 24px;
        font-weight: 700;
        margin-top: 6px;
        color: #1e293b;
    }
    .form-control {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 8px 18px !important;
        font-size: 14px !important;
        color: #1e293b !important;
        background-color: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 3px rgba(248, 152, 132, 0.25) !important;
    }
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 8px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 10px !important;
        color: #1e293b !important;
        font-size: 14px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 14px !important;
    }
    .btn-search-ledger {
        height: 42px;
        background-color: #f89884 !important;
        border-color: #f89884 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 50px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(248, 152, 132, 0.35);
        transition: all 0.2s;
    }
    .btn-search-ledger:hover {
        background-color: #e58774 !important;
        color: #ffffff !important;
    }
    .btn-print-statement {
        background-color: #cfece0 !important;
        border: 1px solid #b5e4d2 !important;
        color: #1e293b !important;
        border-radius: 50px !important;
        font-weight: 600;
        padding: 7px 20px !important;
        font-size: 13.5px;
        transition: all 0.2s;
    }
    .btn-print-statement:hover {
        background-color: #bce7d6 !important;
        color: #1e293b !important;
    }
    .badge-paid {
        background-color: #cfece0;
        color: #15803d;
        border: 1px solid #b5e4d2;
        padding: 4px 12px;
        border-radius: 50px !important;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-pending {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        padding: 4px 12px;
        border-radius: 50px !important;
        font-size: 11px;
        font-weight: 600;
    }
    @media print {
        .no-print, .sidebar, .header {
            display: none !important;
        }
        .page-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row pt-2 pb-3 align-items-center no-print">
            <div class="col-6">
                <h4 class="page-title mb-0"><i class="fas fa-book me-2" style="color: #f89884;"></i> Account Ledger</h4>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-print-statement" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Print Statement
                </button>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card ledger-filter-card no-print mb-4">
            <div class="card-body p-4">
                <div class="row align-items-end g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold" style="font-size: 13.5px; color: #212b36;">Ledger Type</label>
                        <select class="form-control" id="ledgerType">
                            <option value="patient" selected>Patient (Customer)</option>
                            <option value="vendor">Vendor (Supplier)</option>
                        </select>
                    </div>

                    <div class="col-md-3" id="patientDropdownContainer">
                        <label class="form-label fw-bold" style="font-size: 13.5px; color: #212b36;">Select Patient</label>
                        <select class="form-control select2" id="patientSelect">
                            <option value="">-- Choose Patient --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->fullname }} ({{ $p->phone ?: 'No Phone' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3" id="vendorDropdownContainer" style="display: none;">
                        <label class="form-label fw-bold" style="font-size: 13.5px; color: #212b36;">Select Vendor</label>
                        <select class="form-control select2" id="vendorSelect">
                            <option value="">-- Choose Vendor --</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->phone ?: 'No Phone' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold" style="font-size: 13.5px; color: #212b36;">From Date</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold" style="font-size: 13.5px; color: #212b36;">To Date</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-search-ledger w-100" id="fetchLedgerBtn">
                            <i class="fas fa-search"></i> View Ledger
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statement Container -->
        <div id="statementSection" style="display: none;">
            <!-- Header Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 id="entityName" class="mb-1 text-primary fw-bold">Patient Name</h4>
                            <p id="entityDetails" class="text-muted mb-0">Phone: - | Email: -</p>
                        </div>
                        <div class="text-md-end mt-2 mt-md-0">
                            <span class="badge bg-light text-dark p-2 border" id="statementPeriod">Statement Period: All Time</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary KPI Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="ledger-stat-card" style="border-left-color: #3b82f6;">
                        <small class="text-muted fw-bold text-uppercase">Total Invoiced</small>
                        <div class="ledger-stat-val text-primary" id="kpiTotalInvoiced">₹0.00</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ledger-stat-card" style="border-left-color: #10b981;">
                        <small class="text-muted fw-bold text-uppercase">Total Paid</small>
                        <div class="ledger-stat-val text-success" id="kpiTotalPaid">₹0.00</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ledger-stat-card" style="border-left-color: #ef4444;">
                        <small class="text-muted fw-bold text-uppercase">Outstanding Balance</small>
                        <div class="ledger-stat-val text-danger" id="kpiBalance">₹0.00</div>
                    </div>
                </div>
            </div>

            <!-- Invoices Tables -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-danger"><i class="fas fa-clock me-2"></i> Pending / Unpaid Invoices</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Items / Service</th>
                                    <th>Status</th>
                                    <th class="text-end">Pending Amount</th>
                                </tr>
                            </thead>
                            <tbody id="pendingTableBody">
                                <tr><td colspan="5" class="text-center text-muted py-3">No pending invoices</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 text-success"><i class="fas fa-check-circle me-2"></i> Paid Invoices & Receipts</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Items / Service</th>
                                    <th>Payment Mode</th>
                                    <th class="text-end">Paid Amount</th>
                                </tr>
                            </thead>
                            <tbody id="paidTableBody">
                                <tr><td colspan="5" class="text-center text-muted py-3">No paid records found</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('token') || sessionStorage.getItem('token');

        if ($.fn.select2) {
            $('.select2').select2({ width: '100%' });
        }

        // Toggle Type
        $('#ledgerType').on('change', function() {
            if ($(this).val() === 'patient') {
                $('#patientDropdownContainer').show();
                $('#vendorDropdownContainer').hide();
            } else {
                $('#patientDropdownContainer').hide();
                $('#vendorDropdownContainer').show();
            }
        });

        $('#fetchLedgerBtn').on('click', function() {
            const type = $('#ledgerType').val();
            const id = type === 'patient' ? $('#patientSelect').val() : $('#vendorSelect').val();
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            if (!id) {
                alert('Please select a ' + (type === 'patient' ? 'Patient' : 'Vendor'));
                return;
            }

            $.ajax({
                url: '{{ url("api/account-ledger/details") }}',
                type: 'GET',
                headers: { 'Authorization': 'Bearer ' + token },
                data: {
                    type: type,
                    id: id,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(res) {
                    if (res.status) {
                        $('#statementSection').slideDown();

                        $('#entityName').text(res.entity.name);
                        let detailText = 'Phone: ' + (res.entity.phone || 'N/A');
                        if (res.entity.gstin) detailText += ' | GSTIN: ' + res.entity.gstin;
                        if (res.entity.email) detailText += ' | Email: ' + res.entity.email;
                        $('#entityDetails').text(detailText);

                        let periodText = 'Period: ';
                        if (startDate && endDate) {
                            periodText += startDate + ' to ' + endDate;
                        } else {
                            periodText += 'All Time';
                        }
                        $('#statementPeriod').text(periodText);

                        $('#kpiTotalInvoiced').text('₹' + (res.total_invoiced || 0).toFixed(2));
                        $('#kpiTotalPaid').text('₹' + (res.total_paid || 0).toFixed(2));
                        $('#kpiBalance').text('₹' + (res.closing_balance || 0).toFixed(2));

                        // Render Pending Table
                        if (res.pending_invoices && res.pending_invoices.length > 0) {
                            let pRows = '';
                            res.pending_invoices.forEach(row => {
                                pRows += `
                                    <tr>
                                        <td><strong>${row.invoice_no}</strong></td>
                                        <td>${row.date}</td>
                                        <td>${row.summary}</td>
                                        <td><span class="badge-pending">Pending</span></td>
                                        <td class="text-end text-danger fw-bold">₹${parseFloat(row.amount).toFixed(2)}</td>
                                    </tr>
                                `;
                            });
                            $('#pendingTableBody').html(pRows);
                        } else {
                            $('#pendingTableBody').html('<tr><td colspan="5" class="text-center text-muted py-3">No pending invoices</td></tr>');
                        }

                        // Render Paid Table
                        if (res.paid_invoices && res.paid_invoices.length > 0) {
                            let paidRows = '';
                            res.paid_invoices.forEach(row => {
                                paidRows += `
                                    <tr>
                                        <td><strong>${row.invoice_no}</strong></td>
                                        <td>${row.date}</td>
                                        <td>${row.summary}</td>
                                        <td><span class="badge bg-secondary text-white">${row.payment_type}</span></td>
                                        <td class="text-end text-success fw-bold">₹${parseFloat(row.amount).toFixed(2)}</td>
                                    </tr>
                                `;
                            });
                            $('#paidTableBody').html(paidRows);
                        } else {
                            $('#paidTableBody').html('<tr><td colspan="5" class="text-center text-muted py-3">No paid records found</td></tr>');
                        }
                    }
                },
                error: function(err) {
                    alert(err.responseJSON ? err.responseJSON.message : 'Error fetching ledger');
                }
            });
        });
    });
</script>
@endsection

