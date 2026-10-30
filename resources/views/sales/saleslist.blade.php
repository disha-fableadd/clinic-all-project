@extends('layout.app')

@section('title', 'All Sales Bills')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')
<style>
    :root {
        --theme-orange: #f89884;
        --theme-orange-dark: #ea7a63;
        --theme-navy: #002e5b;
        --theme-mint: #cfece0;
        --theme-dark: #1e293b;
    }

    /* GST Tabs (50% Radius Pill & Project Theme Colors) */
    .gst-tabs {
        display: inline-flex;
        background: #fff5f2;
        padding: 4px;
        border-radius: 50px !important;
        margin-bottom: 16px;
        gap: 4px;
        border: 1.5px solid #fed7ce;
    }
    .gst-tab-item {
        padding: 7px 24px;
        font-weight: 700;
        font-size: 13px;
        border-radius: 50px !important;
        cursor: pointer;
        color: #5a6a80;
        transition: all 0.2s ease;
        user-select: none;
    }
    .gst-tab-item:hover:not(.active) {
        color: #f89884;
    }
    .gst-tab-item.active {
        background: #f89884 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(248, 152, 132, 0.4);
    }

    /* Main Card */
    .sales-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        background: #ffffff;
        padding: 22px 24px;
        margin-bottom: 30px;
    }

    /* Filter Form Controls (50% Radius Pill) */
    .sales-filter-input, .sales-filter-select {
        height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 6px 18px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        background-color: #ffffff;
        width: 100%;
        outline: none;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .sales-filter-input:focus, .sales-filter-select:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 2px rgba(248, 152, 132, 0.25) !important;
    }

    /* Delete All Button (50% Radius Pill) */
    #deleteAllSalesBtn {
        height: 38px !important;
        border-radius: 50px !important;
        font-size: 13px !important;
        background-color: #f89884 !important;
        border-color: #f89884 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        transition: all 0.2s;
    }
    #deleteAllSalesBtn:hover {
        background-color: #f67e65 !important;
        border-color: #f67e65 !important;
    }

    /* Summary KPI Boxes (50% Radius Pill) */
    .summary-box-pending {
        border: 1.5px solid #ea5455;
        color: #ea5455;
        background-color: #fffaf9;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 50px !important;
        padding: 8px 18px !important;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .summary-box-paid {
        border: 1.5px solid #28c76f;
        color: #28c76f;
        background-color: #f9fff9;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 50px !important;
        padding: 8px 18px !important;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .summary-box-total {
        border: 1.5px solid #f89884;
        color: #f89884;
        background-color: #fff8f6;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 50px !important;
        padding: 8px 18px !important;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    /* Show Per Page Dropdown (50% Radius Pill) */
    .per-page-select {
        height: 34px !important;
        border-radius: 50px !important;
        padding: 2px 28px 2px 14px !important;
        font-size: 12.5px !important;
        display: inline-block;
        width: auto;
        border: 1.5px solid #cbd5e1 !important;
        outline: none;
        background-color: #ffffff;
    }
    .per-page-select:focus {
        border-color: #f89884 !important;
    }

    /* Table & Status Badges (50% Radius Pill) */
    .table-sales {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .table-sales th {
        background-color: #f8fafc;
        color: #334155;
        font-weight: 700;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 10px;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-sales td {
        padding: 12px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }
    .table-sales tr:hover td {
        background-color: #fafbfc;
    }

    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
        min-height: 420px;
        padding-bottom: 120px;
    }

    /* Payment Badges (50% Radius Pill) */
    .status-badge {
        display: inline-block;
        padding: 5px 16px;
        border-radius: 50px !important;
        font-weight: 600;
        font-size: 11.5px;
        text-transform: capitalize;
        text-align: center;
        color: #ffffff !important;
        white-space: nowrap;
    }
    .status-badge.type-sales { background-color: #f89884 !important; border-radius: 50px !important; }
    .status-badge.type-challan { background-color: #f89884 !important; border-radius: 50px !important; }

    .status-badge.badge-pending { background-color: #5a6a80 !important; border-radius: 50px !important; }
    .status-badge.badge-cash { background-color: #f89884 !important; border-radius: 50px !important; }
    .status-badge.badge-paid, .status-badge.badge-online { background-color: #28c76f !important; border-radius: 50px !important; }
    .status-badge.badge-debit { background-color: #00cfe8 !important; border-radius: 50px !important; }
    .status-badge.badge-cash_online { background-color: #20c997 !important; border-radius: 50px !important; }
    .status-badge.badge-upi { background-color: #7367f0 !important; border-radius: 50px !important; }

    /* Documentation Button (50% Radius Pill) */
    .btn-doc-orange {
        background-color: #f89884 !important;
        border: 1px solid #f89884 !important;
        color: #ffffff !important;
        border-radius: 50px !important;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 18px !important;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .btn-doc-orange:hover {
        background-color: #f67e65 !important;
        border-color: #f67e65 !important;
        color: #ffffff !important;
    }

    /* Action 3-Dots Dropdown Menu */
    .action-dropdown-wrap {
        position: relative !important;
        display: inline-block !important;
        vertical-align: middle;
    }
    .action-menu-toggle {
        background: #ffffff;
        border: 1.5px solid #d7dde8;
        border-radius: 50px !important;
        color: #1e293b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        width: 32px;
        padding: 0;
        cursor: pointer;
        transition: all 0.15s ease;
        outline: none;
    }
    .action-menu-toggle:hover, .action-dropdown-wrap.active .action-menu-toggle {
        background: #fff5f2;
        border-color: #f89884;
        color: #f89884;
    }

    .action-menu-box {
        display: none;
        position: absolute !important;
        top: calc(100% + 4px) !important;
        right: 0 !important;
        left: auto !important;
        min-width: 175px !important;
        padding: 6px 0;
        border-radius: 12px !important;
        background: #ffffff !important;
        border: 1px solid #e8ebed;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
        z-index: 99999 !important;
    }
    .action-menu-box.show {
        display: block !important;
    }
    .action-menu-box .dropdown-item {
        font-size: 13px;
        color: #334155;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        transition: all 0.15s;
        text-decoration: none;
        cursor: pointer;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
    }
    .action-menu-box .dropdown-item i {
        font-size: 13px;
        width: 16px;
        text-align: center;
        color: #64748b;
    }
    .action-menu-box .dropdown-item.pay-item {
        color: #f89884;
        font-weight: 700;
    }
    .action-menu-box .dropdown-item.pay-item i {
        color: #f89884;
    }
    .action-menu-box .dropdown-item:hover {
        background-color: #fff5f2;
        color: #f89884;
    }
    .action-menu-box .dropdown-item:hover i {
        color: #f89884;
    }
    .action-menu-box .dropdown-item.text-danger:hover {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .action-menu-box .dropdown-item.text-danger i {
        color: #dc2626;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        <!-- Without / With GST Bills Toggle Sub-Tabs (50% Radius Pill) -->
        <div class="gst-tabs">
            <div class="gst-tab-item" data-gst="without_gst">Without GST Bills</div>
            <div class="gst-tab-item active" data-gst="with_gst">With GST Bills</div>
        </div>

        <!-- Main Content Card -->
        <div class="sales-card">
            <!-- Filter Bar Row (50% Radius Pill) -->
            <div class="row g-2 align-items-center mb-3">
                <!-- Search sales input -->
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="position-relative">
                        <input type="text" id="salesSearchInput" class="sales-filter-input" placeholder="Search sales...">
                    </div>
                </div>

                <!-- Patient Filter -->
                <div class="col-lg-2 col-md-4 col-6">
                    <select id="filterPatient" class="sales-filter-select">
                        <option value="">All Patient</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">{{ $p->fullname ?? $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Month Filter -->
                <div class="col-lg-2 col-md-4 col-6">
                    <select id="filterMonth" class="sales-filter-select">
                        <option value="">All Months</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Year Filter -->
                <div class="col-lg-2 col-md-4 col-6">
                    <select id="filterYear" class="sales-filter-select">
                        <option value="">All Years</option>
                        @foreach($years as $yr)
                            <option value="{{ $yr }}" {{ $yr == date('Y') ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Picker -->
                <!-- <div class="col-lg-2 col-md-4 col-6">
                    <input type="text" id="filterDateRange" class="sales-filter-input" placeholder="Select Date Range" autocomplete="off">
                </div> -->

                <!-- Delete All Button -->
                <div class="col-lg-2 col-md-4 col-12">
                    <button type="button" class="btn w-100 fw-bold" id="deleteAllSalesBtn">
                        <i class="fas fa-trash-alt me-1"></i> Delete All
                    </button>
                </div>
            </div>

            <!-- Summary Boxes Row (Pending, Paid, Total - 50% Radius Pill) -->
            <div class="row g-3 mb-3">
                <div class="col-md-4 col-12">
                    <div class="summary-box-pending">
                        Total Pending: <span id="summaryPendingAmount">&#8377;0.00</span>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="summary-box-paid">
                        Total Paid: <span id="summaryPaidAmount">&#8377;0.00</span>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="summary-box-total">
                        Total: <span id="summaryTotalAmount">&#8377;0.00</span>
                    </div>
                </div>
            </div>

            <!-- Show Per Page Selector & Info Bar -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2" style="font-size: 13px; color: #475569;">
                    <span>Show per page:</span>
                    <select id="perPageSelect" class="form-select per-page-select">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div id="tableInfoText" style="font-size: 13px; color: #64748b; font-weight: 500;">
                    Showing 0 items
                </div>
            </div>

            <!-- Orders Table Container -->
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table-sales" id="salesTable">
                    <thead>
                        <tr>
                            <th style="width: 36px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckbox" style="cursor: pointer; width: 16px; height: 16px;">
                            </th>
                            <th>Bill No</th>
                            <th>Bill Date</th>
                            <th>Patient Name</th>
                            <th>Mobile Number</th>
                            <th>Payment Mode</th>
                            <th>Total</th>
                            <th>Documentations</th>
                            <th style="text-align: center; width: 60px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="salesTableBody">
                        <!-- Populated via JavaScript dynamically -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination Container -->
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2" id="paginationWrap">
                <div id="paginationInfo" class="text-muted" style="font-size: 13px;"></div>
                <ul class="pagination pagination-sm mb-0" id="paginationList"></ul>
            </div>
        </div>

    </div>
</div>

<!-- ================= MODAL: Product Documentation ================= -->
<div class="modal fade" id="documentationModal" tabindex="-1" aria-labelledby="documentationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.18);">
            <div class="modal-header d-flex justify-content-between align-items-center" style="background: #ffffff; border-bottom: 1.5px solid #f1f5f9; padding: 18px 24px;">
                <h5 class="modal-title font-weight-bold" id="documentationLabel" style="color: #1e293b; font-size: 18px; margin: 0; font-weight: 700;">Product Documentation</h5>
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="color: #ef4444; font-size: 20px; border: none; background: transparent; cursor: pointer;">
                    <i class="fa fa-times text-danger"></i>
                </button>
            </div>
            <form id="documentationForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="docOrderId" name="order_id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Batch Number -->
                        <div class="col-md-6 col-12">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155;">Batch Number</label>
                            <input type="text" class="form-control" name="batch_number" id="doc_batch_number" placeholder="Enter Batch Number" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; padding: 6px 18px;">
                        </div>

                        <!-- Manufacturing Date -->
                        <div class="col-md-6 col-12">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155;">Manufacturing Date</label>
                            <input type="month" class="form-control" name="manufacturing_date" id="doc_mfg_date" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; padding: 6px 18px;">
                        </div>

                        <!-- Expiry Date -->
                        <div class="col-md-6 col-12">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155;">Expiry Date</label>
                            <input type="month" class="form-control" name="expiry_date" id="doc_expiry_date" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; padding: 6px 18px;">
                        </div>

                        <!-- Upload COA (PDF) -->
                        <div class="col-md-6 col-12">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #334155;">Upload COA (PDF)</label>
                            <input type="file" class="form-control" name="coa_file[]" id="doc_coa_file" accept="application/pdf" multiple style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; padding: 6px 18px;">
                            <small class="text-muted d-block mt-1">Max size 15MB</small>
                            <div id="existingCoaList" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-white d-flex justify-content-end gap-2" style="border-top: 1.5px solid #f1f5f9;">
                    <button type="submit" class="btn text-white fw-bold px-4" id="saveDocBtn" style="background-color: #f89884; border-radius: 50px !important; font-size: 14px; padding: 9px 24px; border: none;">Save Changes</button>
                    <button type="button" class="btn text-white px-4 fw-bold" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #5a6a80; border-radius: 50px !important; font-size: 14px; padding: 9px 24px; border: none;">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL: Make Payment ================= -->
<div class="modal fade" id="makePaymentModal" tabindex="-1" aria-labelledby="makePaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.18);">
            <div class="modal-header d-flex justify-content-between align-items-center" style="background: #ffffff; border-bottom: none; padding: 18px 24px 8px 24px;">
                <div></div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn" id="btnOpenHistoryFromPayModal" style="background-color: #5a6a80; color: #ffffff; border-radius: 50px !important; font-size: 13px; font-weight: 600; padding: 7px 18px; border: none;">
                        View Payment History
                    </button>
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="border:none; background:transparent; font-size: 18px; color: #ef4444; padding: 0 4px; cursor: pointer;">
                        <i class="fa fa-times text-danger"></i>
                    </button>
                </div>
            </div>
            <form id="makePaymentForm">
                @csrf
                <input type="hidden" id="payOrderId" name="order_id">
                <input type="hidden" id="payRemainingHidden" value="0">
                <div class="modal-body px-4 py-2">
                    <!-- Amount Summary Box -->
                    <div class="p-3 mb-3 rounded-4" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px;">
                        <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                            Total Amount: <span id="payTotalAmount">&#8377;0.00</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: #1e293b;">
                            Remaining Amount: <span id="payRemainingAmount">&#8377;0.00</span>
                        </div>
                    </div>

                    <!-- Select Payment Method -->
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Select Payment Method</label>
                        <select class="form-control" name="payment_method" id="payMethodSelect" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;" required>
                            <option value="">Select</option>
                            <option value="Cash" selected>Cash</option>
                            <option value="Online">Online</option>
                            <option value="Cash+Online">Cash+Online</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Debit">Debit Card</option>
                        </select>
                    </div>

                    <!-- Single Payment Amount (Shown for Cash, Online, Cheque, Debit) -->
                    <div class="mb-3" id="paySingleAmountWrap">
                        <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Payment Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="amount" id="payAmountInput" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;" placeholder="Enter amount">
                    </div>

                    <!-- Cash + Online Split Inputs -->
                    <div class="row g-2 mb-3 d-none" id="payCashOnlineWrap">
                        <div class="col-6">
                            <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Cash Amount</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="cash_amount" id="payCashAmountInput" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;" value="0.00">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Online Amount</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="online_amount" id="payOnlineAmountInput" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;" value="0.00">
                        </div>
                    </div>

                    <!-- Payment Date & Remarks Row -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Payment Date</label>
                            <input type="date" class="form-control" name="payment_date" id="makePayDate" value="{{ date('Y-m-d') }}" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="makePayRemarks" placeholder="" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;">
                        </div>
                    </div>

                    <!-- Received By & Paid By Row -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Received By</label>
                            <input type="text" class="form-control" name="received_by" id="makePayReceivedBy" placeholder="" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight: 600; font-size: 13.5px; color: #334155; margin-bottom: 6px;">Paid By</label>
                            <input type="text" class="form-control" name="paid_by" id="makePayPaidBy" placeholder="" style="border-radius: 50px !important; height: 42px; border: 1.5px solid #cbd5e1; font-size: 13.5px; padding: 6px 18px;">
                        </div>
                    </div>
                </div>
                <!-- Footer Buttons -->
                <div class="modal-footer px-4 pb-4 pt-2 bg-white d-flex justify-content-end gap-2" style="border-top: none;">
                    <button type="submit" class="btn text-white fw-bold" id="submitPaymentBtn" style="background-color: #f89884; border-radius: 50px !important; padding: 9px 24px; font-size: 14px; border: none;">
                        Submit Payment
                    </button>
                    <button type="button" class="btn text-white fw-bold" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #5a6a80; border-radius: 50px !important; padding: 9px 24px; font-size: 14px; border: none;">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL: Payment History ================= -->
<div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="historyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.18);">
            <div class="modal-header d-flex justify-content-between align-items-center" style="background: #ffffff; border-bottom: 1.5px solid #f1f5f9; padding: 16px 24px;">
                <h5 class="modal-title font-weight-bold" id="historyLabel" style="color: #1e293b; font-size: 18px; margin: 0; font-weight: 700;">Payment History</h5>
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="border:none; background:transparent; font-size: 18px; color: #ef4444; padding: 0; cursor: pointer;">
                    <i class="fa fa-times text-danger"></i>
                </button>
            </div>
            <div class="modal-body p-4">
                <!-- Loading spinner -->
                <div id="paymentHistoryLoading" class="text-center py-3 text-muted">
                    <i class="fas fa-spinner fa-spin fa-2x mb-2" style="color: #f89884;"></i>
                    <div>Loading history...</div>
                </div>

                <!-- History Content Container -->
                <div id="paymentHistoryContent" class="d-none">
                    <!-- Payments List / No payments box -->
                    <div id="paymentHistoryEntriesWrap">
                        <!-- Injected via JS -->
                    </div>

                    <!-- 4-Row Summary Box -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-top: 16px; background: #ffffff;">
                        <div style="padding: 10px 16px; border-bottom: 1px solid #e2e8f0; font-size: 14px; color: #1e293b;">
                            <strong>Order Total:</strong> <span style="font-weight: 700;" id="histOrderTotal">&#8377;0.00</span>
                        </div>
                        <div style="padding: 10px 16px; border-bottom: 1px solid #e2e8f0; font-size: 14px; color: #1e293b;">
                            <strong>Total Paid:</strong> <span style="font-weight: 700;" id="histTotalPaid">&#8377;0.00</span>
                        </div>
                        <div style="padding: 10px 16px; border-bottom: 1px solid #e2e8f0; font-size: 14px; color: #1e293b;">
                            <strong>Return Amount:</strong> <span style="font-weight: 700;" id="histReturnAmount">&#8377;0.00</span>
                        </div>
                        <div style="padding: 10px 16px; font-size: 14px; color: #1e293b;">
                            <strong>Remaining:</strong> <span style="font-weight: 700;" id="histRemaining">&#8377;0.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-3 bg-white d-flex justify-content-start px-4" style="border-top: none;">
                <button type="button" class="btn text-white fw-bold px-4" data-dismiss="modal" data-bs-dismiss="modal" style="background-color: #5a6a80; border-radius: 50px !important; padding: 8px 26px; font-size: 14px; border: none;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    // Raw Sales Data from Backend
    var allSalesList = @json($orders ?? []);
    var saleAuthToken = (typeof token !== 'undefined' && token) ? token : (localStorage.getItem('token') || '');
    var currentGstFilter = 'with_gst'; // default active tab
    var currentPage = 1;
    var perPage = 10;
    var filterDateStart = null;
    var filterDateEnd = null;

    // Format Currency Helper
    function formatMoney(num) {
        return parseFloat(num || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Format Date: e.g. 29-Oct-2026
    function formatDateDisplay(dateStr) {
        if (!dateStr) return 'N/A';
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const day = String(d.getDate()).padStart(2, '0');
        const m = months[d.getMonth()];
        const y = d.getFullYear();
        return `${day}-${m}-${y}`;
    }

    // Helper: Map Payment Method to Class & Label (All 50% radius pills)
    function getPaymentBadgeHtml(method, paymentStatus) {
        const m = (method || '').toLowerCase();
        const s = (paymentStatus || '').toLowerCase();

        if (s === 'pending' || m === 'pending' || m === 'pay_later') {
            return `<span class="status-badge badge-pending">Pending</span>`;
        }
        if (m === 'cash') {
            return `<span class="status-badge badge-cash">Cash</span>`;
        }
        if (m === 'debit') {
            return `<span class="status-badge badge-debit">Debit</span>`;
        }
        if (m === 'cash_online' || m === 'cash+online') {
            return `<span class="status-badge badge-cash_online">Cash+Online</span>`;
        }
        if (m === 'upi' || m === 'online') {
            return `<span class="status-badge badge-upi">UPI Paid</span>`;
        }
        return `<span class="status-badge badge-cash">${method || 'Paid'}</span>`;
    }

    // Main Filter Function
    function getFilteredSales() {
        const search = ($('#salesSearchInput').val() || '').toLowerCase().trim();
        const selectedPatient = $('#filterPatient').val();
        const selectedMonth = $('#filterMonth').val();
        const selectedYear = $('#filterYear').val();

        return allSalesList.filter(order => {
            // 1. GST Filter (without_gst vs with_gst)
            const orderGst = (order.gst_option || '').toLowerCase();
            const isWithGst = orderGst === 'with_gst' || orderGst === 'gst' || orderGst === 'with gst';
            if (currentGstFilter === 'with_gst' && !isWithGst) return false;
            if (currentGstFilter === 'without_gst' && isWithGst) return false;

            // 2. Patient Filter
            if (selectedPatient) {
                const patientId = order.user_id || (order.patients && order.patients.length > 0 ? order.patients[0].id : null);
                if (String(patientId) !== String(selectedPatient)) return false;
            }

            // 3. Date Filters
            const rawDate = order.order_date || order.created_at;
            if (rawDate) {
                const d = new Date(rawDate);
                if (!isNaN(d.getTime())) {
                    // Month
                    if (selectedMonth) {
                        const mStr = String(d.getMonth() + 1).padStart(2, '0');
                        if (mStr !== selectedMonth) return false;
                    }
                    // Year
                    if (selectedYear) {
                        const yStr = String(d.getFullYear());
                        if (yStr !== selectedYear) return false;
                    }
                    // Date Range
                    if (filterDateStart && filterDateEnd) {
                        const checkTime = d.setHours(0,0,0,0);
                        if (checkTime < filterDateStart || checkTime > filterDateEnd) return false;
                    }
                }
            }

            // 4. Text Search (Bill No, Patient Name, Mobile)
            if (search) {
                const billNo = (order.order_number || order.order_invoice || '').toLowerCase();
                const patName = (order.patients && order.patients.length > 0 ? order.patients[0].fullname : (order.user ? order.user.name : '')).toLowerCase();
                const phone = (order.patients && order.patients.length > 0 ? (order.patients[0].phone || order.patients[0].contact_no) : '').toLowerCase();
                const total = String(order.total_amount || '');

                if (!billNo.includes(search) && !patName.includes(search) && !phone.includes(search) && !total.includes(search)) {
                    return false;
                }
            }

            return true;
        });
    }

    // Render Table and Recalculate Summary Boxes
    function renderSalesTable() {
        const filtered = getFilteredSales();

        // 1. Recalculate Summary Boxes from currently filtered dataset
        let totalAmt = 0;
        let totalPending = 0;
        let totalPaid = 0;

        filtered.forEach(o => {
            const tot = parseFloat(o.total_amount) || 0;
            const rem = parseFloat(o.remaining_amount) || 0;
            totalAmt += tot;
            totalPending += rem;
            totalPaid += Math.max(0, tot - rem);
        });

        $('#summaryPendingAmount').html('&#8377;' + formatMoney(totalPending));
        $('#summaryPaidAmount').html('&#8377;' + formatMoney(totalPaid));
        $('#summaryTotalAmount').html('&#8377;' + formatMoney(totalAmt));
        $('#tableInfoText').text(`Showing ${filtered.length} items`);

        // 2. Pagination calculation
        const totalItems = filtered.length;
        const totalPages = Math.ceil(totalItems / perPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;

        const startIdx = (currentPage - 1) * perPage;
        const pageItems = filtered.slice(startIdx, startIdx + perPage);

        // 3. Build Table Rows
        const tbody = $('#salesTableBody');
        tbody.empty();

        if (pageItems.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="fas fa-file-invoice fa-3x mb-2 text-warning"></i>
                        <div class="fw-bold fs-6">No sales invoices found matching current filter</div>
                    </td>
                </tr>
            `);
            $('#paginationList').empty();
            $('#paginationInfo').text('Showing 0 to 0 of 0 entries');
            return;
        }

        pageItems.forEach(order => {
            const billNo = order.order_number || order.order_invoice || `INV-${order.id}`;
            const billDate = formatDateDisplay(order.order_date || order.created_at);
            const patName = (order.patients && order.patients.length > 0) ? (order.patients[0].fullname || order.patients[0].name) : (order.user?.name || 'Walk-in Patient');
            const patPhone = (order.patients && order.patients.length > 0) ? (order.patients[0].phone || order.patients[0].contact_no || '-') : (order.user?.phone || '-');
            const patId = (order.patients && order.patients.length > 0) ? order.patients[0].id : (order.user_id || '');
            const totalStr = '&#8377;' + formatMoney(order.total_amount);
            const remaining = parseFloat(order.remaining_amount) || 0;
            const isPendingPayment = remaining > 0;

            const rowHtml = `
                <tr data-id="${order.id}">
                    <td style="text-align: center;">
                        <input type="checkbox" class="sale-checkbox" data-id="${order.id}" style="cursor: pointer; width: 16px; height: 16px;">
                    </td>
                    <td>
                        <a href="/sales-invoice/${order.id}" class="fw-bold" style="color: #002e5b; text-decoration: none;">
                            ${billNo}
                        </a>
                    </td>
                    <td>${billDate}</td>
                    <td class="fw-semibold">${patName}</td>
                    <td>${patPhone}</td>
                    <td>
                        ${getPaymentBadgeHtml(order.payment_method, order.payment_status)}
                    </td>
                    <td class="fw-bold" style="color: #1e293b;">${totalStr}</td>
                    <td>
                        <button type="button" class="btn btn-doc-orange documentation-btn" data-id="${order.id}">
                            Documentation
                        </button>
                    </td>
                    <td style="text-align: center; position: relative;">
                        <div class="action-dropdown-wrap">
                            <button class="action-menu-toggle" type="button" title="Actions">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="action-menu-box shadow">
                                ${isPendingPayment ? `
                                    <a class="dropdown-item pay-item make-payment-btn" href="javascript:void(0);" data-id="${order.id}" data-total="${order.total_amount}" data-remaining="${remaining}">
                                        <i class="fa fa-inr" style="color: #f89884; font-weight: bold; width: 16px; text-align: center;"></i> <span style="color: #f89884; font-weight: 700;">Pay</span>
                                    </a>
                                ` : ''}
                                <a class="dropdown-item open-history-btn" href="javascript:void(0);" data-id="${order.id}">
                                    <i class="fas fa-history" style="color: #64748b; width: 16px; text-align: center;"></i> <span>History</span>
                                </a>
                                <a class="dropdown-item" href="/add-sales?patient_id=${encodeURIComponent(patId)}">
                                    <i class="fas fa-shopping-cart" style="color: #64748b; width: 16px; text-align: center;"></i> <span>New Sale</span>
                                </a>
                                <a class="dropdown-item" href="/edit-sales/${order.id}">
                                    <i class="fas fa-edit" style="color: #64748b; width: 16px; text-align: center;"></i> <span>Edit</span>
                                </a>
                                <a class="dropdown-item" href="/sales-invoice/${order.id}">
                                    <i class="fas fa-eye" style="color: #64748b; width: 16px; text-align: center;"></i> <span>Invoice</span>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="window.open('/sales-invoice/${order.id}?print=1', '_blank');">
                                    <i class="fas fa-print" style="color: #64748b; width: 16px; text-align: center;"></i> <span>Print</span>
                                </a>
                                <a class="dropdown-item" href="/sales-details/${order.id}">
                                    <i class="fas fa-file-alt" style="color: #64748b; width: 16px; text-align: center;"></i> <span>Patient Details</span>
                                </a>
                                <div class="dropdown-divider my-1" style="border-top: 1px solid #f1f5f9;"></div>
                                <a class="dropdown-item text-danger delete-order-btn" href="javascript:void(0);" data-id="${order.id}">
                                    <i class="fas fa-trash-alt" style="color: #ef4444; width: 16px; text-align: center;"></i> <span style="color: #ef4444; font-weight: 600;">Delete</span>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(rowHtml);
        });

        // 4. Render Pagination
        renderPagination(totalItems, totalPages);
        updateDeleteBtnText();
    }

    // Pagination Generator
    function renderPagination(totalItems, totalPages) {
        const pagList = $('#paginationList');
        pagList.empty();

        const from = totalItems === 0 ? 0 : (currentPage - 1) * perPage + 1;
        const to = Math.min(currentPage * perPage, totalItems);
        $('#paginationInfo').text(`Showing ${from} to ${to} of ${totalItems} entries`);

        if (totalPages <= 1) return;

        pagList.append(`
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" data-page="${currentPage - 1}">&laquo;</a>
            </li>
        `);

        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                pagList.append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${i}">${i}</a>
                    </li>
                `);
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                pagList.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
            }
        }

        pagList.append(`
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" data-page="${currentPage + 1}">&raquo;</a>
            </li>
        `);
    }

    // Checkbox toggling & Delete button text update
    function updateDeleteBtnText() {
        const checkedCount = $('.sale-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#deleteAllSalesBtn').html(`<i class="fas fa-trash-alt me-1"></i> Delete Selected (${checkedCount})`);
        } else {
            $('#deleteAllSalesBtn').html(`<i class="fas fa-trash-alt me-1"></i> Delete All`);
        }
    }

    $(document).ready(function() {
        // Init DateRangePicker
        if (typeof $('#filterDateRange').daterangepicker === 'function') {
            $('#filterDateRange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD-MM-YYYY'
                }
            });

            $('#filterDateRange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY'));
                filterDateStart = picker.startDate.startOf('day').toDate().getTime();
                filterDateEnd = picker.endDate.endOf('day').toDate().getTime();
                currentPage = 1;
                renderSalesTable();
            });

            $('#filterDateRange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                filterDateStart = null;
                filterDateEnd = null;
                currentPage = 1;
                renderSalesTable();
            });
        }

        // GST Tabs Click Handler
        $('.gst-tab-item').on('click', function() {
            $('.gst-tab-item').removeClass('active');
            $(this).addClass('active');
            currentGstFilter = $(this).data('gst');
            currentPage = 1;
            renderSalesTable();
        });

        // Search Input
        $('#salesSearchInput').on('keyup input', function() {
            currentPage = 1;
            renderSalesTable();
        });

        // Dropdowns Filter
        $('#filterPatient, #filterMonth, #filterYear').on('change', function() {
            currentPage = 1;
            renderSalesTable();
        });

        // Per Page Change
        $('#perPageSelect').on('change', function() {
            perPage = parseInt($(this).val()) || 10;
            currentPage = 1;
            renderSalesTable();
        });

        // Pagination Click
        $(document).on('click', '#paginationList .page-link', function(e) {
            e.preventDefault();
            const p = parseInt($(this).data('page'));
            if (p && p !== currentPage) {
                currentPage = p;
                renderSalesTable();
                $('html, body').animate({ scrollTop: $('#salesTable').offset().top - 100 }, 200);
            }
        });

        // Select All Checkbox
        $('#selectAllCheckbox').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.sale-checkbox').prop('checked', isChecked);
            updateDeleteBtnText();
        });

        $(document).on('change', '.sale-checkbox', function() {
            const total = $('.sale-checkbox').length;
            const checked = $('.sale-checkbox:checked').length;
            $('#selectAllCheckbox').prop('checked', total > 0 && total === checked);
            updateDeleteBtnText();
        });

        // Initial Render
        renderSalesTable();

        // ================= PRODUCT DOCUMENTATION MODAL =================
        $(document).on('click', '.documentation-btn', function() {
            const orderId = $(this).data('id');
            $('#docOrderId').val(orderId);
            $('#documentationForm')[0].reset();
            $('#existingCoaList').empty();

            // Load existing documentation data
            $.ajax({
                url: '/api/sales/documentation/' + orderId,
                type: 'GET',
                headers: { 'Authorization': 'Bearer ' + saleAuthToken },
                success: function(res) {
                    if (res && res.status === 'success' && res.data) {
                        const d = res.data;
                        $('#doc_batch_number').val(d.batch_number || '');
                        if (d.mfg_date) {
                            $('#doc_mfg_date').val(d.mfg_date.substring(0, 7));
                        }
                        if (d.expiry_date) {
                            $('#doc_expiry_date').val(d.expiry_date.substring(0, 7));
                        }
                        if (d.coa_pdfs && Array.isArray(d.coa_pdfs) && d.coa_pdfs.length > 0) {
                            let links = '<div class="fw-bold" style="font-size:12px; margin-bottom:4px;">Uploaded COA Files:</div>';
                            d.coa_pdfs.forEach((url, i) => {
                                links += `<a href="${url}" target="_blank" class="badge bg-light text-dark border me-1 mb-1 p-2" style="text-decoration:none;"><i class="fas fa-file-pdf text-danger me-1"></i> File ${i+1}</a> `;
                            });
                            $('#existingCoaList').html(links);
                        }
                    }
                    $('#documentationModal').modal('show');
                },
                error: function() {
                    $('#documentationModal').modal('show');
                }
            });
        });

        // Submit Documentation
        $('#documentationForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this)[0];
            const formData = new FormData(form);
            const btn = $('#saveDocBtn');

            btn.prop('disabled', true).text('Saving...');
            $.ajax({
                url: '/api/sales/documentation/store',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': 'Bearer ' + saleAuthToken
                },
                success: function(res) {
                    btn.prop('disabled', false).text('Save Changes');
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Product Documentation saved successfully.',
                            icon: 'success',
                            confirmButtonColor: '#f89884'
                        });
                        $('#documentationModal').modal('hide');
                    } else {
                        Swal.fire('Error', res.message || 'Error saving documentation', 'error');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Save Changes');
                    Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error saving documentation', 'error');
                }
            });
        });

        // ================= 3-DOT ACTION MENU TOGGLE =================
        // Clicking anywhere in the 3-dots button toggles menu directly underneath
        $(document).on('click', '.action-dropdown-wrap, .action-menu-toggle', function(e) {
            if ($(e.target).closest('.action-menu-box').length) {
                return; // Click inside menu item, handled separately
            }
            e.preventDefault();
            e.stopPropagation();
            const $wrap = $(this).closest('.action-dropdown-wrap');
            const $box = $wrap.find('.action-menu-box');
            const isShown = $box.hasClass('show');

            $('.action-menu-box').removeClass('show');
            $('.action-dropdown-wrap').removeClass('active');

            if (!isShown) {
                $box.addClass('show');
                $wrap.addClass('active');
            }
        });

        // Close when clicking anywhere outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.action-dropdown-wrap').length) {
                $('.action-menu-box').removeClass('show');
                $('.action-dropdown-wrap').removeClass('active');
            }
        });

        // Close when clicking any menu item
        $(document).on('click', '.action-menu-box .dropdown-item', function() {
            $('.action-menu-box').removeClass('show');
            $('.action-dropdown-wrap').removeClass('active');
        });

        // ================= MAKE PAYMENT MODAL =================
        $(document).on('click', '.make-payment-btn', function() {
            $('.action-menu-box').removeClass('show');
            $('.action-dropdown-wrap').removeClass('active');
            const orderId = $(this).data('id');
            const total = parseFloat($(this).data('total')) || 0;
            const remaining = parseFloat($(this).data('remaining')) || 0;

            $('#payOrderId').val(orderId);
            $('#payRemainingHidden').val(remaining);
            $('#payTotalAmount').html('&#8377;' + formatMoney(total));
            $('#payRemainingAmount').html('&#8377;' + formatMoney(remaining));

            $('#payMethodSelect').val('Cash');
            $('#payAmountInput').val(remaining.toFixed(2));
            $('#paySingleAmountWrap').removeClass('d-none');
            $('#payCashOnlineWrap').addClass('d-none');
            $('#payCashAmountInput').val('0.00');
            $('#payOnlineAmountInput').val('0.00');

            $('#makePayRemarks').val('');
            $('#makePayReceivedBy').val('');
            $('#makePayPaidBy').val('');

            const today = new Date().toISOString().split('T')[0];
            $('#makePayDate').val(today);

            $('#makePaymentModal').modal('show');
        });

        // Payment Method change inside Make Payment Modal
        $('#payMethodSelect').on('change', function() {
            const method = $(this).val();
            const remaining = parseFloat($('#payRemainingHidden').val()) || 0;

            if (method === 'Cash+Online') {
                $('#paySingleAmountWrap').addClass('d-none');
                $('#payCashOnlineWrap').removeClass('d-none');
                const half = (remaining / 2).toFixed(2);
                $('#payCashAmountInput').val(half);
                $('#payOnlineAmountInput').val((remaining - parseFloat(half)).toFixed(2));
            } else {
                $('#payCashOnlineWrap').addClass('d-none');
                $('#paySingleAmountWrap').removeClass('d-none');
                $('#payAmountInput').val(remaining.toFixed(2));
            }
        });

        // View payment history button inside Make Payment Modal
        $('#btnOpenHistoryFromPayModal').on('click', function() {
            const orderId = $('#payOrderId').val();
            $('#makePaymentModal').modal('hide');
            openPaymentHistoryModal(orderId);
        });

        // Submit Payment
        $('#makePaymentForm').on('submit', function(e) {
            e.preventDefault();
            const orderId = $('#payOrderId').val();
            const method = $('#payMethodSelect').val();
            const remaining = parseFloat($('#payRemainingHidden').val()) || 0;

            let amount = 0;
            let cashAmt = 0;
            let onlineAmt = 0;

            if (method === 'Cash+Online') {
                cashAmt = parseFloat($('#payCashAmountInput').val()) || 0;
                onlineAmt = parseFloat($('#payOnlineAmountInput').val()) || 0;
                amount = cashAmt + onlineAmt;
            } else {
                amount = parseFloat($('#payAmountInput').val()) || 0;
            }

            if (amount <= 0) {
                Swal.fire('Error', 'Please enter a valid amount greater than 0', 'error');
                return;
            }

            const btn = $('#submitPaymentBtn');
            btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: '/sales/make-payment',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: orderId,
                    payment_method: method,
                    amount: amount,
                    cash_amount: cashAmt,
                    online_amount: onlineAmt,
                    payment_date: $('#makePayDate').val(),
                    remarks: $('#makePayRemarks').val(),
                    received_by: $('#makePayReceivedBy').val(),
                    paid_by: $('#makePayPaidBy').val()
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': 'Bearer ' + saleAuthToken
                },
                success: function(res) {
                    btn.prop('disabled', false).text('Submit Payment');
                    if (res.status) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment Saved Successfully!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#makePaymentModal').modal('hide');
                        // Update in local array
                        const item = allSalesList.find(o => o.id == orderId);
                        if (item) {
                            item.remaining_amount = res.remaining_amount;
                            item.payment_status = res.payment_status;
                            if (method.toLowerCase() !== 'pending') item.payment_method = method;
                        }
                        renderSalesTable();
                    } else {
                        Swal.fire('Error', res.message || 'Error recording payment', 'error');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Submit Payment');
                    Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error recording payment', 'error');
                }
            });
        });

        // ================= PAYMENT HISTORY MODAL =================
        $(document).on('click', '.open-history-btn', function() {
            $('.action-menu-box').removeClass('show');
            $('.action-dropdown-wrap').removeClass('active');
            const orderId = $(this).data('id');
            openPaymentHistoryModal(orderId);
        });

        function openPaymentHistoryModal(orderId) {
            $('#paymentHistoryModal').modal('show');
            $('#paymentHistoryLoading').removeClass('d-none');
            $('#paymentHistoryContent').addClass('d-none');
            $('#paymentHistoryEntriesWrap').empty();

            $.ajax({
                url: '/api/sales/payment-history/' + orderId,
                type: 'GET',
                headers: { 'Authorization': 'Bearer ' + saleAuthToken },
                success: function(res) {
                    $('#paymentHistoryLoading').addClass('d-none');
                    $('#paymentHistoryContent').removeClass('d-none');

                    // 1. Fill 4-row summary box
                    const total = parseFloat(res.total_amount) || 0;
                    const remaining = parseFloat(res.remaining_amount) || 0;
                    const paid = parseFloat(res.paid_amount) || 0;
                    const returnAmt = parseFloat(res.return_amount) || 0;

                    $('#histOrderTotal').html('&#8377;' + formatMoney(total));
                    $('#histTotalPaid').html('&#8377;' + formatMoney(paid));
                    $('#histReturnAmount').html('&#8377;' + formatMoney(returnAmt));
                    $('#histRemaining').html('&#8377;' + formatMoney(remaining));

                    // 2. Render previous payments or empty box
                    const wrap = $('#paymentHistoryEntriesWrap');
                    if (res.status && res.payments && res.payments.length > 0) {
                        let html = '<div class="d-flex flex-column gap-2 mb-3">';
                        res.payments.forEach(p => {
                            const pDate = formatDateDisplay(p.payment_date || p.created_at);
                            const pAmt = formatMoney(p.payment_amount);
                            const pMode = p.payment_method ? p.payment_method.toUpperCase() : 'CASH';
                            html += `
                                <div style="border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 14px; background: #ffffff;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="color: #64748b; font-size: 13px;">${pDate}</span>
                                        <span style="font-weight: 700; font-size: 14px; color: #1e293b;">&#8377;${pAmt} via ${pMode}</span>
                                    </div>
                                    ${p.remarks ? `<div class="text-muted mt-1" style="font-size: 12px;"><i class="fa fa-info-circle me-1"></i>${p.remarks}</div>` : ''}
                                </div>
                            `;
                        });
                        html += '</div>';
                        wrap.html(html);
                    } else {
                        wrap.html(`
                            <div class="p-3 mb-3 text-muted" style="border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px;">
                                No payment history found.
                            </div>
                        `);
                    }
                },
                error: function() {
                    $('#paymentHistoryLoading').addClass('d-none');
                    $('#paymentHistoryContent').removeClass('d-none');
                    $('#paymentHistoryEntriesWrap').html(`
                        <div class="p-3 mb-3 text-danger" style="border: 1.5px solid #fecaca; border-radius: 12px; font-size: 14px;">
                            Failed to fetch payment history.
                        </div>
                    `);
                }
            });
        }

        // ================= DELETE SINGLE SALE =================
        $(document).on('click', '.delete-order-btn', function() {
            const orderId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This sale bill will be deleted and medicine inventory will be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea5455',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/api/sales/delete/' + orderId,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        headers: { 'Authorization': 'Bearer ' + saleAuthToken },
                        success: function(res) {
                            if (res.status) {
                                Swal.fire('Deleted!', 'Sale bill deleted.', 'success');
                                allSalesList = allSalesList.filter(o => o.id != orderId);
                                renderSalesTable();
                            } else {
                                Swal.fire('Error', res.message || 'Error deleting sale', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error deleting sale', 'error');
                        }
                    });
                }
            });
        });

        // ================= DELETE ALL / DELETE SELECTED =================
        $('#deleteAllSalesBtn').on('click', function() {
            const checkedBoxes = $('.sale-checkbox:checked');
            const checkedIds = [];
            checkedBoxes.each(function() {
                checkedIds.push($(this).data('id'));
            });

            if (checkedIds.length > 0) {
                // Delete selected
                Swal.fire({
                    title: 'Delete Selected Sales?',
                    text: `Are you sure you want to delete ${checkedIds.length} selected sale bill(s)?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea5455',
                    confirmButtonText: 'Yes, delete selected!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/api/sales/delete-multiple',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: checkedIds
                            },
                            headers: { 'Authorization': 'Bearer ' + saleAuthToken },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire('Deleted!', 'Selected sales deleted.', 'success');
                                    allSalesList = allSalesList.filter(o => !checkedIds.includes(o.id));
                                    $('#selectAllCheckbox').prop('checked', false);
                                    renderSalesTable();
                                } else {
                                    Swal.fire('Error', res.message || 'Error deleting sales', 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error deleting sales', 'error');
                            }
                        });
                    }
                });
            } else {
                // Delete all filtered sales
                const filtered = getFilteredSales();
                if (filtered.length === 0) {
                    Swal.fire('Info', 'No sales to delete in current filter.', 'info');
                    return;
                }
                const allIds = filtered.map(o => o.id);
                Swal.fire({
                    title: 'Delete All Matching Sales?',
                    text: `This will permanently delete all ${allIds.length} sale bills matching current filter!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea5455',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/api/sales/delete-multiple',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: allIds
                            },
                            headers: { 'Authorization': 'Bearer ' + saleAuthToken },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire('Deleted!', 'All matching sales deleted.', 'success');
                                    allSalesList = allSalesList.filter(o => !allIds.includes(o.id));
                                    renderSalesTable();
                                } else {
                                    Swal.fire('Error', res.message || 'Error deleting sales', 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.message : 'Error deleting sales', 'error');
                            }
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
