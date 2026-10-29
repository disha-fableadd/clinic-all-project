@extends('layout.app')

@section('title', 'Add Purchase Bill')

@section('content')
<style>
    :root {
        --clinic-primary: #f89884;
        --clinic-secondary: #cfece0;
        --clinic-dark: #2c3e50;
    }

    .purchase-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        background: #ffffff;
        margin-bottom: 25px;
    }
    .purchase-card .card-body {
        padding: 26px 30px;
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

    .form-control, .form-select {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 6px 18px !important;
        font-size: 13.5px !important;
        transition: all 0.2s ease-in-out;
        background-color: #fff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 3px rgba(248, 152, 132, 0.25) !important;
        background-color: #fff;
    }

    .pill-btn {
        border-radius: 50px !important;
        font-weight: 600;
        padding: 8px 24px;
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

    /* GST Mode Toggle */
    .gst-toggle-box {
        background: #f8fafc;
        border-radius: 50px;
        padding: 6px 16px;
        display: inline-flex;
        gap: 16px;
        border: 1.5px solid #e2e8f0;
    }
    .gst-toggle-box input[type="radio"] {
        accent-color: #f89884;
    }

    /* Product Table */
    .items-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 12.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 10px;
        border-bottom: 2px solid #e2e8f0;
    }
    .items-table tbody td {
        padding: 8px 6px;
        vertical-align: middle;
    }
    .items-table .table-input {
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

    .summary-badge {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 16px 20px;
    }
</style>

<div class="page-wrapper" style="padding: 25px 30px;">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="mb-1" style="font-weight: 700; color: #1e293b;">New Purchase Bill</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">Add inventory stock from suppliers and vendor bills</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="gst-toggle-box">
                <label class="form-check-label mb-0" style="font-size: 13px; font-weight: 600; cursor: pointer;">
                    <input type="radio" name="gst_option" value="with_gst" checked onchange="toggleGstMode()"> With GST
                </label>
                <label class="form-check-label mb-0" style="font-size: 13px; font-weight: 600; cursor: pointer;">
                    <input type="radio" name="gst_option" value="without_gst" onchange="toggleGstMode()"> Without GST
                </label>
            </div>
            <a href="{{ route('purchase.lists') }}" class="btn btn-outline-secondary pill-btn">
                <i class="fa fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <form id="purchaseForm">
        @csrf
        <!-- Vendor & Bill Info Card -->
        <div class="purchase-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Vendor / Supplier <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                <select class="form-select" id="vendor_id" name="vendor_id" required onchange="handleVendorChange()">
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" data-phone="{{ $vendor->phone ?? $vendor->mobile }}" data-name="{{ $vendor->name }}">
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-clinic-secondary pill-btn px-3" data-bs-toggle="modal" data-bs-target="#quickAddVendorModal" title="Quick Add Vendor">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Vendor Phone</label>
                            <input type="text" id="vendor_phone" name="vendor_phone" class="form-control" placeholder="Supplier phone">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Supplier Bill No <span class="text-danger">*</span></label>
                            <input type="text" id="bill_no" name="bill_no" class="form-control" placeholder="INV-001" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" id="purchase_date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Payment Due Days</label>
                            <input type="number" id="payment_due_days" name="payment_due_days" class="form-control" placeholder="e.g. 30" oninput="calculateDueDate()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Interest Before Due (%)</label>
                            <input type="number" step="0.01" id="interest_before_due" name="interest_before_due" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Interest After Due (%)</label>
                            <input type="number" step="0.01" id="interest_after_due" name="interest_after_due" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products / Medicines Table Card -->
        <div class="purchase-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="font-weight: 700; color: #1e293b;">
                        <i class="fa fa-pills me-2" style="color: #f89884;"></i> Purchase Items
                    </h5>
                    <button type="button" class="btn btn-clinic-primary pill-btn btn-sm" onclick="addProductRow()">
                        <i class="fa fa-plus me-1"></i> Add Item Row
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table items-table align-middle" id="itemsTable">
                        <thead>
                            <tr>
                                <th style="min-width: 200px;">Medicine Name</th>
                                <th style="min-width: 110px;">Batch No</th>
                                <th style="min-width: 120px;">Expiry Date</th>
                                <th style="min-width: 80px;" class="text-center">Qty</th>
                                <th style="min-width: 80px;" class="text-center">Free Qty</th>
                                <th style="min-width: 100px;" class="text-end">Pur. Price (₹)</th>
                                <th style="min-width: 100px;" class="text-end">MRP (₹)</th>
                                <th style="min-width: 90px;" class="text-center gst-col">GST %</th>
                                <th style="min-width: 110px;" class="text-end">Total (₹)</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Rows added dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="noItemsNotice" class="text-center py-4 text-muted">
                    <i class="fa fa-box-open fa-2x mb-2 text-secondary" style="opacity: 0.5;"></i>
                    <p class="mb-0">No items added yet. Click <strong>"+ Add Item Row"</strong> above to add medicines.</p>
                </div>
            </div>
        </div>

        <!-- Financial Summary & Payment Options -->
        <div class="row">
            <div class="col-md-6">
                <!-- Additional Charges Card -->
                <div class="purchase-card">
                    <div class="card-body">
                        <h6 style="font-weight: 700; color: #1e293b; margin-bottom: 16px;">Discounts & Charges</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping / Courier (₹)</label>
                                    <input type="number" step="0.01" id="shipping" name="shipping" class="form-control" value="0" oninput="calculateTotals()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Overall Discount (₹)</label>
                                    <input type="number" step="0.01" id="discount" name="discount" class="form-control" value="0" oninput="calculateTotals()">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Purchase Remarks / Notes</label>
                            <textarea id="remarks" name="remarks" class="form-control" style="border-radius: 16px !important; height: 60px !important;" placeholder="Optional invoice notes..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Card -->
                <div class="purchase-card">
                    <div class="card-body">
                        <h6 style="font-weight: 700; color: #1e293b; margin-bottom: 16px;">Payment Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select class="form-select" id="payment_mode" name="payment_mode" onchange="handlePaymentModeChange()">
                                        <option value="pay_later">Pay Later (Credit / Due)</option>
                                        <option value="Cash" selected>Cash</option>
                                        <option value="Online">Online / UPI</option>
                                        <option value="Bank">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Account</label>
                                    <select class="form-select" id="bank_id" name="bank_id">
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name ?? $bank->bank_name ?? 'Default Account' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label>Amount Paid Now (₹)</label>
                                    <input type="number" step="0.01" id="paid_amount" name="amount" class="form-control" value="0" oninput="calculateBalance()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label>Remaining Balance (₹)</label>
                                    <input type="text" id="remaining_amount" name="remaining_amount" class="form-control bg-light" readonly value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grand Totals & Submit -->
            <div class="col-md-6">
                <div class="purchase-card">
                    <div class="card-body">
                        <h6 style="font-weight: 700; color: #1e293b; margin-bottom: 20px;">Bill Summary</h6>
                        <div class="summary-badge mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted" style="font-size: 14px;">Total Items:</span>
                                <strong id="totalItemsCount" style="font-size: 14px;">0</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted" style="font-size: 14px;">Items Subtotal:</span>
                                <strong style="font-size: 14px;">₹<span id="subTotalText">0.00</span></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 gst-row">
                                <span class="text-muted" style="font-size: 14px;">Total GST:</span>
                                <strong style="font-size: 14px; color: #f89884;">₹<span id="taxTotalText">0.00</span></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted" style="font-size: 14px;">Shipping / Delivery:</span>
                                <strong style="font-size: 14px;">₹<span id="shippingText">0.00</span></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span style="font-size: 14px;">Discount Applied:</span>
                                <strong style="font-size: 14px;">-₹<span id="discountText">0.00</span></strong>
                            </div>
                            <hr style="margin: 12px 0; border-color: #cbd5e1;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size: 16px; font-weight: 700; color: #1e293b;">Grand Total:</span>
                                <span style="font-size: 22px; font-weight: 800; color: #f89884;">₹<span id="grandTotalText">0.00</span></span>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <a href="{{ route('purchase.lists') }}" class="btn btn-clinic-secondary pill-btn flex-fill text-center">
                                Cancel
                            </a>
                            <button type="submit" id="submitBtn" class="btn btn-clinic-primary pill-btn flex-fill" style="padding: 12px 24px; font-size: 15px;">
                                <i class="fa fa-check-circle me-1"></i> Save Purchase Bill
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal: Quick Add Vendor -->
<div class="modal fade" id="quickAddVendorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: #f89884; color: #fff; padding: 16px 24px;">
                <h5 class="modal-title font-weight-bold" style="color: #fff;"><i class="fa fa-truck me-2"></i> Quick Add Supplier</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickVendorForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" id="quick_vendor_name" name="name" class="form-control" required placeholder="Vendor or Distributor Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Mobile Number</label>
                        <input type="text" id="quick_vendor_phone" name="mobile" class="form-control" placeholder="10-digit phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">GST Number</label>
                        <input type="text" id="quick_vendor_gst" name="gst_number" class="form-control" placeholder="GSTIN (optional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Address</label>
                        <input type="text" id="quick_vendor_address" name="address" class="form-control" placeholder="City / Address">
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary pill-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-clinic-primary pill-btn px-4">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Available medicines from server for quick autocomplete/selection
    const medicinesCatalog = @json($medicines);
    let rowCount = 0;

    function handleVendorChange() {
        const selected = $('#vendor_id option:selected');
        const phone = selected.data('phone') || '';
        $('#vendor_phone').val(phone);
    }

    function calculateDueDate() {
        const days = parseInt($('#payment_due_days').val()) || 0;
        const purchaseDateVal = $('#purchase_date').val();
        if (purchaseDateVal && days > 0) {
            const date = new Date(purchaseDateVal);
            date.setDate(date.getDate() + days);
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            $('#due_date').val(`${yyyy}-${mm}-${dd}`);
        }
    }

    function toggleGstMode() {
        const isWithGst = $('input[name="gst_option"]:checked').val() === 'with_gst';
        if (isWithGst) {
            $('.gst-col, .gst-row').show();
        } else {
            $('.gst-col, .gst-row').hide();
        }
        calculateTotals();
    }

    function addProductRow() {
        rowCount++;
        $('#noItemsNotice').hide();

        let medicineOptions = '<option value="">-- Choose or Type Medicine --</option>';
        medicinesCatalog.forEach(m => {
            medicineOptions += `<option value="${m.id}" data-name="${m.name}" data-price="${m.purchase_price || 0}" data-mrp="${m.mrp || 0}">${m.name}</option>`;
        });

        const rowHtml = `
            <tr id="row_${rowCount}">
                <td>
                    <select class="form-select table-input medicine-select" name="item_${rowCount}" onchange="onMedicineSelect(${rowCount})">
                        ${medicineOptions}
                    </select>
                    <input type="text" class="form-control table-input custom-name-input mt-1 d-none" placeholder="Or Custom Medicine Name">
                </td>
                <td>
                    <input type="text" class="form-control table-input batch-input" placeholder="Batch No">
                </td>
                <td>
                    <input type="date" class="form-control table-input expiry-input">
                </td>
                <td>
                    <input type="number" min="1" value="1" class="form-control table-input text-center qty-input" oninput="calculateRow(${rowCount})">
                </td>
                <td>
                    <input type="number" min="0" value="0" class="form-control table-input text-center free-qty-input">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" value="0.00" class="form-control table-input text-end price-input" oninput="calculateRow(${rowCount})">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" value="0.00" class="form-control table-input text-end mrp-input">
                </td>
                <td class="gst-col">
                    <select class="form-select table-input text-center gst-input" onchange="calculateRow(${rowCount})">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="12" selected>12%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control table-input text-end bg-light row-total" readonly value="0.00">
                </td>
                <td class="text-center">
                    <button type="button" class="btn-remove-row" onclick="removeRow(${rowCount})">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#itemsBody').append(rowHtml);
        toggleGstMode();
    }

    function onMedicineSelect(id) {
        const row = $(`#row_${id}`);
        const selected = row.find('.medicine-select option:selected');
        const price = parseFloat(selected.data('price')) || 0;
        const mrp = parseFloat(selected.data('mrp')) || 0;

        row.find('.price-input').val(price.toFixed(2));
        row.find('.mrp-input').val(mrp.toFixed(2));
        calculateRow(id);
    }

    function removeRow(id) {
        $(`#row_${id}`).remove();
        if ($('#itemsBody tr').length === 0) {
            $('#noItemsNotice').show();
        }
        calculateTotals();
    }

    function calculateRow(id) {
        const row = $(`#row_${id}`);
        const qty = parseFloat(row.find('.qty-input').val()) || 0;
        const price = parseFloat(row.find('.price-input').val()) || 0;
        const gstRate = $('input[name="gst_option"]:checked').val() === 'with_gst' 
            ? (parseFloat(row.find('.gst-input').val()) || 0) 
            : 0;

        const baseTotal = qty * price;
        const gstAmount = (baseTotal * gstRate) / 100;
        const lineTotal = baseTotal + gstAmount;

        row.find('.row-total').val(lineTotal.toFixed(2));
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        let totalGst = 0;
        let count = 0;
        const isWithGst = $('input[name="gst_option"]:checked').val() === 'with_gst';

        $('#itemsBody tr').each(function() {
            count++;
            const qty = parseFloat($(this).find('.qty-input').val()) || 0;
            const price = parseFloat($(this).find('.price-input').val()) || 0;
            const gstRate = isWithGst ? (parseFloat($(this).find('.gst-input').val()) || 0) : 0;

            const base = qty * price;
            const gst = (base * gstRate) / 100;

            subtotal += base;
            totalGst += gst;
        });

        const shipping = parseFloat($('#shipping').val()) || 0;
        const discount = parseFloat($('#discount').val()) || 0;
        const grandTotal = Math.max(0, (subtotal + totalGst + shipping) - discount);

        $('#totalItemsCount').text(count);
        $('#subTotalText').text(subtotal.toFixed(2));
        $('#taxTotalText').text(totalGst.toFixed(2));
        $('#shippingText').text(shipping.toFixed(2));
        $('#discountText').text(discount.toFixed(2));
        $('#grandTotalText').text(grandTotal.toFixed(2));

        if ($('#payment_mode').val() === 'pay_later') {
            $('#paid_amount').val(0);
        } else if (parseFloat($('#paid_amount').val()) === 0 || $('#paid_amount').data('auto')) {
            $('#paid_amount').val(grandTotal.toFixed(2)).data('auto', true);
        }

        calculateBalance();
    }

    function handlePaymentModeChange() {
        const mode = $('#payment_mode').val();
        const grandTotal = parseFloat($('#grandTotalText').text()) || 0;
        if (mode === 'pay_later') {
            $('#paid_amount').val(0).prop('readonly', true);
        } else {
            $('#paid_amount').prop('readonly', false);
            if (parseFloat($('#paid_amount').val()) === 0) {
                $('#paid_amount').val(grandTotal.toFixed(2));
            }
        }
        calculateBalance();
    }

    function calculateBalance() {
        const grandTotal = parseFloat($('#grandTotalText').text()) || 0;
        const paid = parseFloat($('#paid_amount').val()) || 0;
        const remaining = Math.max(0, grandTotal - paid);
        $('#remaining_amount').val(remaining.toFixed(2));
    }

    // Handle Quick Vendor Add
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
                mobile: phone,
                phone: phone,
                gst_number: gst,
                address: address
            },
            success: function(res) {
                const newId = res.supplier ? res.supplier.id : (res.id || Date.now());
                $('#vendor_id').append(`<option value="${newId}" data-phone="${phone}" selected>${name}</option>`);
                $('#vendor_phone').val(phone);
                bootstrap.Modal.getInstance(document.getElementById('quickAddVendorModal')).hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Supplier Added!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            error: function() {
                // Fallback direct append if endpoint differs
                $('#vendor_id').append(`<option value="new_${Date.now()}" data-phone="${phone}" selected>${name}</option>`);
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
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select a vendor / supplier.' });
            return;
        }
        if (!billNo) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Please enter the supplier bill number.' });
            return;
        }

        const items = [];
        $('#itemsBody tr').each(function() {
            const medId = $(this).find('.medicine-select').val();
            const medName = $(this).find('.medicine-select option:selected').text();
            const batch = $(this).find('.batch-input').val();
            const expiry = $(this).find('.expiry-input').val();
            const qty = parseFloat($(this).find('.qty-input').val()) || 0;
            const freeQty = parseFloat($(this).find('.free-qty-input').val()) || 0;
            const price = parseFloat($(this).find('.price-input').val()) || 0;
            const mrp = parseFloat($(this).find('.mrp-input').val()) || 0;
            const gst = parseFloat($(this).find('.gst-input').val()) || 0;
            const total = parseFloat($(this).find('.row-total').val()) || 0;

            if (qty > 0 && (medId || medName)) {
                items.push({
                    product_id: medId,
                    item: medName,
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
        });

        if (items.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No Items', text: 'Please add at least one product with quantity.' });
            return;
        }

        const grandTotal = parseFloat($('#grandTotalText').text()) || 0;
        const paidAmount = parseFloat($('#paid_amount').val()) || 0;
        const remaining = parseFloat($('#remaining_amount').val()) || 0;

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
            grand_total: grandTotal,
            payment_mode: $('#payment_mode').val(),
            bank_id: $('#bank_id').val(),
            amount: paidAmount,
            remaining_amount: remaining,
            paid_type: paidAmount >= grandTotal ? 'Paid' : (paidAmount > 0 ? 'Partial' : 'Unpaid'),
            products: items
        };

        $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Saving...');

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
                    text: 'Stock has been automatically updated in Medicines inventory.',
                    confirmButtonColor: '#f89884'
                }).then(() => {
                    window.location.href = "{{ route('purchase.lists') }}";
                });
            },
            error: function(err) {
                $('#submitBtn').prop('disabled', false).html('<i class="fa fa-check-circle me-1"></i> Save Purchase Bill');
                Swal.fire({
                    icon: 'error',
                    title: 'Error Saving Purchase',
                    text: err.responseJSON ? err.responseJSON.message : 'Please check your inputs and try again.',
                    confirmButtonColor: '#f89884'
                });
            }
        });
    });

    // Initialize with 1 empty row
    $(document).ready(function() {
        addProductRow();
    });
</script>
@endsection

