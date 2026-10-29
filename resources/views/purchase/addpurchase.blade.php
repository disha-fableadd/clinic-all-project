@extends('layout.app')

@section('title', 'Add Purchase Bill')

@section('content')
<style>
    /* Site Theme: #f89884 and #cfece0 with 50% pill radius */
    .purchase-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        background: #ffffff;
        margin-bottom: 20px;
    }
    .purchase-card .card-body {
        padding: 24px 28px;
    }
    .form-group {
        margin-bottom: 18px !important;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #212b36;
        margin-bottom: 6px;
        display: block;
    }
    .form-control, .form-select,
    .form-control[readonly], .form-control:disabled,
    .table input.form-control, .table select.form-select {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 8px 18px !important;
        font-size: 13.5px !important;
        color: #000000 !important;
        background-color: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 3px rgba(248, 152, 132, 0.25) !important;
        outline: none;
    }

    /* Select2 Alignment & 50% Radius */
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
        color: #000000 !important;
        font-size: 13.5px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 14px !important;
    }

    /* Buttons */
    .btn-submit-main {
        background-color: #f89884 !important;
        border-color: #f89884 !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 30px !important;
        border-radius: 50px !important;
        box-shadow: 0 2px 6px rgba(248, 152, 132, 0.35);
        transition: all 0.2s;
        border: none;
    }
    .btn-submit-main:hover {
        background-color: #e58774 !important;
        color: #ffffff !important;
    }
    .btn-cancel-main {
        background-color: #cfece0 !important;
        border: 1px solid #b5e4d2 !important;
        color: #000000 !important;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 24px !important;
        border-radius: 50px !important;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-cancel-main:hover {
        background-color: #bce7d6 !important;
        color: #000000 !important;
    }
    .btn-back-main {
        background-color: #cfece0 !important;
        border: 1px solid #b5e4d2 !important;
        color: #000000 !important;
        border-radius: 50px !important;
        font-weight: 600;
        font-size: 13.5px;
        padding: 7px 20px !important;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-back-main:hover {
        background-color: #bce7d6 !important;
        color: #000000 !important;
    }
    .btn-add-pill {
        background-color: #f89884 !important;
        color: #ffffff !important;
        border-radius: 50px !important;
        font-size: 11px;
        padding: 2px 10px;
        font-weight: 600;
        float: right;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    /* Payment Mode Buttons */
    .pay-mode-btn {
        flex: 1;
        min-height: 50px;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        background: #ffffff;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        padding: 8px 16px;
    }
    .pay-mode-btn.active {
        background-color: #cfece0 !important;
        border-color: #f89884 !important;
        color: #000000 !important;
        box-shadow: 0 0 0 2px rgba(248, 152, 132, 0.3);
    }
    .pay-mode-btn:hover {
        border-color: #f89884;
    }

    /* Product Autocomplete Dropdown */
    #searchDropdownResults {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1050;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-height: 280px;
        overflow-y: auto;
        display: none;
    }
    .search-result-item {
        padding: 10px 16px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background 0.15s;
    }
    .search-result-item:hover {
        background: #fbf5f4;
    }

    .table-input {
        height: 38px !important;
        border-radius: 50px !important;
        font-size: 13px !important;
        padding: 4px 12px !important;
    }
    .btn-remove-row {
        width: 32px;
        height: 32px;
        border-radius: 50% !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fee2e2;
        color: #dc2626;
        border: none;
        transition: all 0.2s;
    }
    .btn-remove-row:hover {
        background: #dc2626;
        color: #ffffff;
    }
    .form-control::placeholder, .form-select::placeholder, textarea.form-control::placeholder {
        color: #94a3b8 !important;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <!-- Top Toolbar Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h4 class="page-title mb-0" style="font-weight: 700; font-size: 21px; color: #1e293b;">New Purchase Bill</h4>
                <div class="d-inline-flex align-items-center gap-2 border-start ps-3">
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="gst_option" id="radioGst" value="with_gst" checked onchange="toggleGst()">
                        <label class="form-check-label" for="radioGst" style="font-size: 13.5px; font-weight: 600;">GST</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="gst_option" id="radioNoGst" value="without_gst" onchange="toggleGst()">
                        <label class="form-check-label" for="radioNoGst" style="font-size: 13.5px; font-weight: 600;">Without GST</label>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('purchase.ai-bill') }}" class="btn btn-cancel-main" style="padding: 7px 18px !important; font-size: 13px;">
                    <i class="fa fa-magic me-1"></i> AI Bill Upload
                </a>
                <a href="{{ route('purchase.lists') }}" class="btn btn-back-main">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="purchaseForm">
            @csrf

            <!-- Vendor Information Card -->
            <div class="card purchase-card">
                <div class="card-body">
                    <div class="row">
                        <!-- Vendor Name -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-handshake text-muted me-1"></i> Vendor Name
                                    <button type="button" class="btn-add-pill" data-bs-toggle="modal" data-bs-target="#quickAddVendorModal">+ Add</button>
                                </label>
                                <select class="form-control select2" id="vendor_id" name="vendor_id" required onchange="handleVendorChange()">
                                    <option value="">Select or Type Vendor</option>
                                    @foreach($vendors as $v)
                                        <option value="{{ $v->id }}" data-phone="{{ $v->phone }}">
                                            {{ $v->name }} {{ $v->phone ? '('.$v->phone.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Vendor Phone -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-phone text-muted me-1"></i> Vendor Phone</label>
                                <input type="text" class="form-control" name="vendor_phone" id="vendor_phone" placeholder="Vendor phone">
                            </div>
                        </div>

                        <!-- Vendor Bill No -->
                        <div class="col-lg-2 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-file-invoice text-muted me-1"></i> Vendor Bill No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="bill_no" id="bill_no" placeholder="INV-001" required>
                            </div>
                        </div>

                        <!-- Purchase Date -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-day text-muted me-1"></i> Purchase Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="purchase_date" id="purchase_date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-check text-muted me-1"></i> Due Date</label>
                                <input type="date" class="form-control" name="due_date" id="due_date">
                            </div>
                        </div>

                        <!-- Payment Due Days -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-clock text-muted me-1"></i> Payment Due Days</label>
                                <input type="number" class="form-control" name="payment_due_days" id="payment_due_days" placeholder="e.g. 30" oninput="calculateDueDate()">
                            </div>
                        </div>

                        <!-- Interest Before Due -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-percentage text-muted me-1"></i> Interest Before Due (%)</label>
                                <input type="number" step="0.01" class="form-control" name="interest_before_due" id="interest_before_due" placeholder="0.00">
                            </div>
                        </div>

                        <!-- Interest After Due -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-percentage text-muted me-1"></i> Interest After Due (%)</label>
                                <input type="number" step="0.01" class="form-control" name="interest_after_due" id="interest_after_due" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicines / Items Selection Table Card -->
            <div class="card purchase-card">
                <div class="card-body">
                    <!-- Search & Header Bar -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <span style="font-weight: 700; font-size: 15px; color: #1e293b;" id="itemsCountBadge">Total items : 0</span>
                        <div class="position-relative" style="flex: 1; max-width: 500px;">
                            <input type="text" class="form-control" id="medicineSearchInput" placeholder="Search medicine name, batch or barcode to add row..." autocomplete="off">
                            <div id="searchDropdownResults"></div>
                        </div>
                        <button type="button" class="btn btn-submit-main btn-sm py-2 px-3" onclick="addBlankRow()">
                            <i class="fas fa-plus me-1"></i> Add Blank Row
                        </button>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="purchaseItemsTable">
                            <thead style="background-color: #cfece0; color: #1e293b; font-size: 13px;">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Medicine / Product</th>
                                    <th style="width: 120px;">Batch</th>
                                    <th style="width: 130px;">Expiry</th>
                                    <th style="width: 85px;" class="text-center">Qty</th>
                                    <th style="width: 85px;" class="text-center">Free Qty</th>
                                    <th style="width: 110px;" class="text-end">Pur. Price (₹)</th>
                                    <th style="width: 110px;" class="text-end">MRP (₹)</th>
                                    <th style="width: 90px;" class="text-center gst-header-col">GST %</th>
                                    <th style="width: 120px;" class="text-end">Total (₹)</th>
                                    <th style="width: 50px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseItemsBody">
                                <tr id="noItemRow">
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        <i class="fas fa-pills fa-2x mb-2 d-block" style="color: #f89884;"></i>
                                        Search medicines above or click "+ Add Blank Row" to add items
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Billing Summary & Discounts Card -->
            <div class="card purchase-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group mb-2">
                                <label>Shipping Charges (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="shipping" id="shipping" value="0" oninput="calculateTotals()">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group mb-2">
                                <label>Misc Charges (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="misc_charges" id="misc_charges" value="0" oninput="calculateTotals()">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group mb-2">
                                <label>Discount Rate (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="discount" id="discount" value="0" oninput="calculateTotals()">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group mb-2">
                                <label>Remarks (Optional)</label>
                                <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter remarks">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-4 mt-3 pt-3 border-top flex-wrap">
                        <div style="font-size: 15px; color: #475569;">
                            Subtotal: <strong style="color: #1e293b;" id="subtotalDisplay">₹0.00</strong>
                        </div>
                        <div style="font-size: 18px; font-weight: 700; color: #f89884;">
                            Grand Total: <span id="grandTotalDisplay">₹0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Modes Card -->
            <div class="card purchase-card">
                <div class="card-body">
                    <label class="mb-3" style="font-size: 14px; font-weight: 700; color: #1e293b;">
                        <i class="fas fa-wallet text-muted me-1"></i> Payment Mode
                    </label>

                    <div class="d-flex gap-2 flex-wrap mb-4">
                        <div class="pay-mode-btn active" data-mode="Cash" onclick="selectPayMode('Cash')">
                            <i class="fas fa-money-bill-wave text-success"></i> Cash
                        </div>
                        <div class="pay-mode-btn" data-mode="Online" onclick="selectPayMode('Online')">
                            <i class="fas fa-mobile-alt text-primary"></i> Online / UPI
                        </div>
                        <div class="pay-mode-btn" data-mode="Bank" onclick="selectPayMode('Bank')">
                            <i class="fas fa-university text-info"></i> Bank Transfer
                        </div>
                        <div class="pay-mode-btn" data-mode="pay_later" onclick="selectPayMode('pay_later')">
                            <i class="fas fa-clock text-warning"></i> Pay Later
                        </div>
                    </div>
                    <input type="hidden" name="payment_mode" id="selectedPaymentMode" value="Cash">

                    <!-- Bank Select and Paid Amount Breakdown -->
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-6 col-12" id="bankSelectCol">
                            <div class="form-group mb-2">
                                <label>Deposit / Debit Account</label>
                                <select class="form-control select2" id="bank_id" name="bank_id">
                                    @foreach($banks as $b)
                                        <option value="{{ $b->id }}">{{ $b->bank_name ?? $b->name ?? 'Default Bank' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group mb-2">
                                <label>Paid Amount (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="amount" id="paidAmountInput" value="0.00" oninput="calculateBalance()">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group mb-2">
                                <label>Remaining Due (₹)</label>
                                <input type="text" class="form-control bg-light" id="remainingBalanceInput" readonly value="0.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Action Buttons Bar -->
            <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                <div style="font-size: 16px; font-weight: 700; color: #1e293b;">
                    Total Amount : <span style="color: #f89884; font-size: 20px;" id="totalBottomDisplay">₹0.00</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('purchase.lists') }}" class="btn btn-cancel-main">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-submit-main" id="savePurchaseBtn">
                        Save Purchase Bill <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Quick Add Vendor -->
<div class="modal fade" id="quickAddVendorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: #f89884; color: #fff; padding: 18px 24px;">
                <h5 class="modal-title font-weight-bold" style="color: #fff;"><i class="fa fa-handshake me-2"></i> Quick Add Vendor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickVendorForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label>Vendor Name <span class="text-danger">*</span></label>
                        <input type="text" id="quick_vendor_name" name="name" class="form-control" required placeholder="Vendor or Distributor Name">
                    </div>
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input type="text" id="quick_vendor_phone" name="phone" class="form-control" placeholder="Phone number">
                    </div>
                    <div class="form-group">
                        <label>GST Number</label>
                        <input type="text" id="quick_vendor_gst" name="gst_number" class="form-control" placeholder="GSTIN (optional)">
                    </div>
                    <div class="form-group mb-0">
                        <label>Address</label>
                        <input type="text" id="quick_vendor_address" name="address" class="form-control" placeholder="Address">
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-cancel-main" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-submit-main">Save Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const medicinesCatalog = @json($medicines);
    let rowIdx = 0;

    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({ width: '100%' });
        }
    });

    function handleVendorChange() {
        const sel = $('#vendor_id option:selected');
        const phone = sel.data('phone') || '';
        $('#vendor_phone').val(phone);
    }

    function calculateDueDate() {
        const days = parseInt($('#payment_due_days').val()) || 0;
        const pDate = $('#purchase_date').val();
        if (pDate && days > 0) {
            const date = new Date(pDate);
            date.setDate(date.getDate() + days);
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            $('#due_date').val(`${yyyy}-${mm}-${dd}`);
        }
    }

    function toggleGst() {
        const isWithGst = $('#radioGst').is(':checked');
        if (isWithGst) {
            $('.gst-header-col, .gst-row-col').show();
        } else {
            $('.gst-header-col, .gst-row-col').hide();
        }
        calculateTotals();
    }

    // Medicine Search Autocomplete
    $('#medicineSearchInput').on('keyup focus', function() {
        const query = $(this).val().toLowerCase().trim();
        const resultsBox = $('#searchDropdownResults');
        if (query.length < 1) {
            resultsBox.hide().empty();
            return;
        }

        const matches = medicinesCatalog.filter(m => 
            (m.name && m.name.toLowerCase().includes(query)) ||
            (m.barcode && m.barcode.toLowerCase().includes(query)) ||
            (m.batch_no && m.batch_no.toLowerCase().includes(query))
        );

        if (matches.length === 0) {
            resultsBox.html('<div class="p-3 text-center text-muted">No medicines found. Click "+ Add Blank Row" to enter a custom item.</div>').show();
            return;
        }

        let html = '';
        matches.slice(0, 15).forEach(m => {
            html += `
                <div class="search-result-item" onclick="selectMedicine(${m.id})">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong style="color: #1e293b;">${m.name}</strong>
                        <span class="badge" style="background-color: #cfece0; color: #1f513f;">Stock: ${m.quantity || 0}</span>
                    </div>
                    <div class="text-muted" style="font-size: 12px;">
                        Price: ₹${parseFloat(m.purchase_price || 0).toFixed(2)} | MRP: ₹${parseFloat(m.mrp || 0).toFixed(2)} | Batch: ${m.batch_no || 'N/A'}
                    </div>
                </div>
            `;
        });
        resultsBox.html(html).show();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#medicineSearchInput, #searchDropdownResults').length) {
            $('#searchDropdownResults').hide();
        }
    });

    function selectMedicine(medId) {
        const med = medicinesCatalog.find(m => m.id === medId);
        if (!med) return;
        $('#searchDropdownResults').hide();
        $('#medicineSearchInput').val('');

        appendProductRow(med.id, med.name, med.batch_no || '', med.expiry_date || '', 1, 0, med.purchase_price || 0, med.mrp || 0, 12);
    }

    function addBlankRow() {
        appendProductRow('', '', '', '', 1, 0, 0, 0, 12);
    }

    function appendProductRow(id, name, batch, expiry, qty, freeQty, price, mrp, gst) {
        $('#noItemRow').hide();
        rowIdx++;

        const isWithGst = $('#radioGst').is(':checked');
        const gstDisplay = isWithGst ? '' : 'display: none;';

        const tr = `
            <tr id="row_${rowIdx}">
                <td class="text-center font-weight-bold row-index"></td>
                <td>
                    <input type="hidden" class="med-id" value="${id}">
                    <input type="text" class="form-control table-input med-name" value="${name}" placeholder="Medicine name" required>
                </td>
                <td>
                    <input type="text" class="form-control table-input batch-no" value="${batch}" placeholder="Batch">
                </td>
                <td>
                    <input type="date" class="form-control table-input expiry-date" value="${expiry}">
                </td>
                <td>
                    <input type="number" min="1" class="form-control table-input text-center row-qty" value="${qty}" oninput="calcRow(${rowIdx})">
                </td>
                <td>
                    <input type="number" min="0" class="form-control table-input text-center row-free-qty" value="${freeQty}">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" class="form-control table-input text-end row-price" value="${parseFloat(price).toFixed(2)}" oninput="calcRow(${rowIdx})">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" class="form-control table-input text-end row-mrp" value="${parseFloat(mrp).toFixed(2)}">
                </td>
                <td class="gst-row-col" style="${gstDisplay}">
                    <select class="form-control table-input text-center row-gst" onchange="calcRow(${rowIdx})">
                        <option value="0" ${gst == 0 ? 'selected' : ''}>0%</option>
                        <option value="5" ${gst == 5 ? 'selected' : ''}>5%</option>
                        <option value="12" ${gst == 12 ? 'selected' : ''}>12%</option>
                        <option value="18" ${gst == 18 ? 'selected' : ''}>18%</option>
                        <option value="28" ${gst == 28 ? 'selected' : ''}>28%</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control table-input text-end bg-light row-total" readonly value="0.00">
                </td>
                <td class="text-center">
                    <button type="button" class="btn-remove-row" onclick="removeRow(${rowIdx})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#purchaseItemsBody').append(tr);
        calcRow(rowIdx);
        updateRowNumbers();
    }

    function removeRow(idx) {
        $(`#row_${idx}`).remove();
        if ($('#purchaseItemsBody tr').length === 0 || ($('#purchaseItemsBody tr').length === 1 && $('#noItemRow').length)) {
            $('#noItemRow').show();
        }
        updateRowNumbers();
        calculateTotals();
    }

    function updateRowNumbers() {
        let i = 1;
        $('#purchaseItemsBody tr').each(function() {
            if ($(this).attr('id') !== 'noItemRow') {
                $(this).find('.row-index').text(i++);
            }
        });
        $('#itemsCountBadge').text(`Total items : ${i - 1}`);
    }

    function calcRow(idx) {
        const row = $(`#row_${idx}`);
        const qty = parseFloat(row.find('.row-qty').val()) || 0;
        const price = parseFloat(row.find('.row-price').val()) || 0;
        const isWithGst = $('#radioGst').is(':checked');
        const gstRate = isWithGst ? (parseFloat(row.find('.row-gst').val()) || 0) : 0;

        const base = qty * price;
        const gstAmt = (base * gstRate) / 100;
        const total = base + gstAmt;

        row.find('.row-total').val(total.toFixed(2));
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        const isWithGst = $('#radioGst').is(':checked');

        $('#purchaseItemsBody tr').each(function() {
            if ($(this).attr('id') !== 'noItemRow') {
                const qty = parseFloat($(this).find('.row-qty').val()) || 0;
                const price = parseFloat($(this).find('.row-price').val()) || 0;
                const gstRate = isWithGst ? (parseFloat($(this).find('.row-gst').val()) || 0) : 0;

                const base = qty * price;
                const gst = (base * gstRate) / 100;
                subtotal += (base + gst);
            }
        });

        const shipping = parseFloat($('#shipping').val()) || 0;
        const misc = parseFloat($('#misc_charges').val()) || 0;
        const discount = parseFloat($('#discount').val()) || 0;

        const grandTotal = Math.max(0, (subtotal + shipping + misc) - discount);

        $('#subtotalDisplay').text('₹' + subtotal.toFixed(2));
        $('#grandTotalDisplay').text('₹' + grandTotal.toFixed(2));
        $('#totalBottomDisplay').text('₹' + grandTotal.toFixed(2));

        if ($('#selectedPaymentMode').val() === 'pay_later') {
            $('#paidAmountInput').val(0);
        } else if (parseFloat($('#paidAmountInput').val()) === 0 || $('#paidAmountInput').data('auto')) {
            $('#paidAmountInput').val(grandTotal.toFixed(2)).data('auto', true);
        }

        calculateBalance();
    }

    function selectPayMode(mode) {
        $('.pay-mode-btn').removeClass('active');
        $(`.pay-mode-btn[data-mode="${mode}"]`).addClass('active');
        $('#selectedPaymentMode').val(mode);

        const grand = parseFloat($('#grandTotalDisplay').text().replace('₹', '')) || 0;
        if (mode === 'pay_later') {
            $('#paidAmountInput').val(0).prop('readonly', true);
        } else {
            $('#paidAmountInput').prop('readonly', false);
            if (parseFloat($('#paidAmountInput').val()) === 0) {
                $('#paidAmountInput').val(grand.toFixed(2));
            }
        }
        calculateBalance();
    }

    function calculateBalance() {
        const grand = parseFloat($('#grandTotalDisplay').text().replace('₹', '')) || 0;
        const paid = parseFloat($('#paidAmountInput').val()) || 0;
        const rem = Math.max(0, grand - paid);
        $('#remainingBalanceInput').val(rem.toFixed(2));
    }

    // Quick Add Vendor AJAX
    $('#quickVendorForm').on('submit', function(e) {
        e.preventDefault();
        const name = $('#quick_vendor_name').val();
        const phone = $('#quick_vendor_phone').val();
        const gst = $('#quick_vendor_gst').val();
        const address = $('#quick_vendor_address').val();

        $.ajax({
            url: "/api/suppliers",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name: name,
                phone: phone,
                gst_number: gst,
                address: address
            },
            success: function(res) {
                const newId = res.supplier ? res.supplier.id : (res.id || Date.now());
                const opt = new Option(`${name} (${phone})`, newId, true, true);
                $(opt).data('phone', phone);
                $('#vendor_id').append(opt).trigger('change');
                $('#vendor_phone').val(phone);

                bootstrap.Modal.getInstance(document.getElementById('quickAddVendorModal')).hide();
                Swal.fire({ icon: 'success', title: 'Vendor Added', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false });
            },
            error: function() {
                const fallbackId = 'new_' + Date.now();
                const opt = new Option(`${name} (${phone})`, fallbackId, true, true);
                $(opt).data('phone', phone);
                $('#vendor_id').append(opt).trigger('change');
                $('#vendor_phone').val(phone);
                bootstrap.Modal.getInstance(document.getElementById('quickAddVendorModal')).hide();
            }
        });
    });

    // Form Submission
    $('#purchaseForm').on('submit', function(e) {
        e.preventDefault();

        const vendorId = $('#vendor_id').val();
        const billNo = $('#bill_no').val();
        const purchaseDate = $('#purchase_date').val();

        if (!vendorId) {
            Swal.fire({ icon: 'warning', title: 'Vendor Required', text: 'Please select a vendor.', confirmButtonColor: '#f89884' });
            return;
        }
        if (!billNo) {
            Swal.fire({ icon: 'warning', title: 'Bill No Required', text: 'Please enter the vendor bill number.', confirmButtonColor: '#f89884' });
            return;
        }

        const items = [];
        $('#purchaseItemsBody tr').each(function() {
            if ($(this).attr('id') !== 'noItemRow') {
                const id = $(this).find('.med-id').val();
                const name = $(this).find('.med-name').val();
                const batch = $(this).find('.batch-no').val();
                const expiry = $(this).find('.expiry-date').val();
                const qty = parseFloat($(this).find('.row-qty').val()) || 0;
                const freeQty = parseFloat($(this).find('.row-free-qty').val()) || 0;
                const price = parseFloat($(this).find('.row-price').val()) || 0;
                const mrp = parseFloat($(this).find('.row-mrp').val()) || 0;
                const gst = parseFloat($(this).find('.row-gst').val()) || 0;
                const total = parseFloat($(this).find('.row-total').val()) || 0;

                if (name && qty > 0) {
                    items.push({
                        product_id: id || null,
                        item: name,
                        batch_no: batch,
                        expiry: expiry,
                        quantity: qty,
                        free_quantity: freeQty,
                        purchase_price: price,
                        mrp: mrp,
                        gst: gst,
                        total: total
                    });
                }
            }
        });

        if (items.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No Items Added', text: 'Please add at least one medicine item.', confirmButtonColor: '#f89884' });
            return;
        }

        const grand = parseFloat($('#grandTotalDisplay').text().replace('₹', '')) || 0;
        const paid = parseFloat($('#paidAmountInput').val()) || 0;
        const rem = parseFloat($('#remainingBalanceInput').val()) || 0;

        const payload = {
            vendor_id: vendorId,
            vendor_phone: $('#vendor_phone').val(),
            bill_no: billNo,
            purchase_date: purchaseDate,
            due_date: $('#due_date').val() || null,
            payment_due_days: $('#payment_due_days').val() || null,
            interest_before_due: $('#interest_before_due').val() || null,
            interest_after_due: $('#interest_after_due').val() || null,
            gst_option: $('input[name="gst_option"]:checked').val(),
            shipping: parseFloat($('#shipping').val()) || 0,
            discount: parseFloat($('#discount').val()) || 0,
            grand_total: grand,
            payment_mode: $('#selectedPaymentMode').val(),
            bank_id: $('#bank_id').val(),
            amount: paid,
            remaining_amount: rem,
            paid_type: paid >= grand ? 'Paid' : (paid > 0 ? 'Partial' : 'Unpaid'),
            products: items
        };

        $('#savePurchaseBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Saving...');

        $.ajax({
            url: "/api/purchase_order",
            type: "POST",
            data: JSON.stringify(payload),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Purchase Bill Saved!',
                    text: 'Inventory stock has been updated.',
                    confirmButtonColor: '#f89884'
                }).then(() => {
                    window.location.href = "{{ route('purchase.lists') }}";
                });
            },
            error: function(err) {
                $('#savePurchaseBtn').prop('disabled', false).html('Save Purchase Bill <i class="fas fa-arrow-right ms-1"></i>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error Saving Purchase',
                    text: err.responseJSON ? err.responseJSON.message : 'Please check your inputs.',
                    confirmButtonColor: '#f89884'
                });
            }
        });
    });

    // Start with 1 blank row by default
    $(document).ready(function() {
        addBlankRow();
    });
</script>
@endsection
