@extends('layout.app')

@section('title', 'Add Sale')

@section('content')
<style>
    /* Clinic Theme: #f89884 and #cfece0 with 50% pill radius */
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

    /* Compact Form Groups */
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
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f89884 !important;
        box-shadow: 0 0 0 3px rgba(248, 152, 132, 0.25) !important;
        outline: none;
    }

    /* Select2 Alignment & 50% Radius */
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 8px !important;
        color: #1e293b !important;
        font-size: 13px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 12px !important;
    }

    /* Pill Buttons */
    .btn-submit-main {
        background-color: #f89884 !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 13.5px;
        padding: 10px 24px !important;
        border-radius: 50px !important;
        box-shadow: 0 2px 6px rgba(248, 152, 132, 0.35);
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-submit-main:hover {
        background-color: #e58774 !important;
        color: #ffffff !important;
    }
    .btn-back-main {
        background-color: #cfece0 !important;
        border: 1px solid #b5e4d2 !important;
        color: #1e293b !important;
        border-radius: 50px !important;
        font-weight: 600;
        font-size: 13px;
        padding: 6px 18px !important;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-back-main:hover {
        background-color: #bce7d6 !important;
        color: #1e293b !important;
    }
    .btn-add-pill {
        background-color: #f89884 !important;
        color: #ffffff !important;
        border-radius: 50px !important;
        font-size: 11px;
        padding: 1px 10px;
        font-weight: 600;
        float: right;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    /* Payment Mode Buttons */
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
        cursor: pointer;
        transition: all 0.2s;
        padding: 6px 14px;
    }
    .pay-mode-btn.active {
        background-color: #cfece0 !important;
        border-color: #f89884 !important;
        color: #1e293b !important;
        box-shadow: 0 0 0 2px rgba(248, 152, 132, 0.3);
    }
    .pay-mode-btn:hover {
        border-color: #f89884;
    }

    /* Product search dropdown results */
    #searchDropdownResults {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1050;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
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

    /* Search Input with Icon */
    .search-input-wrap {
        position: relative;
    }
    .search-input-wrap .search-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }
    .search-input-wrap input {
        padding-left: 42px !important;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <!-- Top Toolbar Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h4 class="page-title mb-0" style="font-weight: 700; font-size: 21px; color: #1e293b;">Add Sale</h4>
                <div class="form-check form-check-inline ms-2">
                    <input class="form-check-input" type="checkbox" id="chkMedicalReport">
                    <label class="form-check-label" for="chkMedicalReport" style="font-size: 13px; font-weight: 600;">Medical Report</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chkChallan">
                    <label class="form-check-label" for="chkChallan" style="font-size: 13px; font-weight: 600;">Challan</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chkCustom">
                    <label class="form-check-label" for="chkCustom" style="font-size: 13px; font-weight: 600;">Custom</label>
                </div>
                <div class="d-inline-flex align-items-center gap-2 border-start ps-3">
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="gst_option" id="radioNoGst" value="without_gst">
                        <label class="form-check-label" for="radioNoGst" style="font-size: 13px; font-weight: 600;">No GST</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="gst_option" id="radioGst" value="with_gst" checked>
                        <label class="form-check-label" for="radioGst" style="font-size: 13px; font-weight: 600;">GST</label>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('sales.list') }}" class="btn-back-main">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="addSaleForm">
            @csrf

            <!-- SINGLE UNIFIED CARD FOR ALL SALE FIELDS (Compact & No Excess Space) -->
            <div class="card single-sale-card">
                <div class="card-body">
                    <!-- Patient Row 1 (5 Columns) -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group-compact">
                                <label>
                                    <i class="fas fa-user-injured text-muted me-1"></i> Patient Name
                                    <button type="button" class="btn-add-pill" id="quickAddPatientBtn">+ Add</button>
                                </label>
                                <select class="form-control select2" id="patient_id" name="patient_id">
                                    <option value="">Select or Type Patient</option>
                                    @foreach($patients as $p)
                                        <option value="{{ $p->id }}" 
                                            data-phone="{{ $p->phone }}" 
                                            data-age="{{ $p->age }}" 
                                            data-sex="{{ $p->gender }}"
                                            data-bp="{{ $p->bp }}"
                                            data-temp="{{ $p->temperature }}"
                                            data-pulse="{{ $p->pulse }}"
                                            data-history="{{ $p->patient_history }}"
                                            data-complaint="{{ $p->patient_complaint }}"
                                            data-lab="{{ $p->advice_for_lab_tests }}">
                                            {{ $p->fullname }} {{ $p->phone ? '('.$p->phone.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <div class="form-group-compact">
                                <label><i class="fas fa-phone text-muted me-1"></i> Patient Phone</label>
                                <input type="text" class="form-control" name="patient_phone" id="patient_phone" placeholder="Patient number">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="form-group-compact">
                                <label><i class="fas fa-calendar-alt text-muted me-1"></i> Age</label>
                                <input type="number" class="form-control" name="patient_age" id="patient_age" placeholder="Age" min="0" max="150">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-6">
                            <div class="form-group-compact">
                                <label><i class="fas fa-venus-mars text-muted me-1"></i> Sex</label>
                                <select class="form-control" name="patient_sex" id="patient_sex">
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-1 col-12">
                            <div class="form-group-compact">
                                <label><i class="fas fa-heartbeat text-danger me-1"></i> B.P</label>
                                <input type="text" class="form-control" name="patient_bp" id="patient_bp" placeholder="e.g. 120/80">
                            </div>
                        </div>
                    </div>

                    <!-- Patient Row 2 (6 Columns) -->
                    <div class="row mt-1 mb-2">
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group-compact">
                                <label><i class="fas fa-thermometer-half text-warning me-1"></i> Temperature</label>
                                <input type="text" class="form-control" name="patient_temperature" id="patient_temperature" placeholder="Temperature">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group-compact">
                                <label><i class="fas fa-wave-square text-success me-1"></i> Pulse</label>
                                <input type="text" class="form-control" name="patient_pulse" id="patient_pulse" placeholder="Pulse">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group-compact">
                                <label><i class="fas fa-file-medical-alt text-muted me-1"></i> Patient History</label>
                                <input type="text" class="form-control" name="patient_history" id="patient_history" placeholder="Patient History">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group-compact">
                                <label><i class="fas fa-stethoscope text-muted me-1"></i> Patient Complaint</label>
                                <input type="text" class="form-control" name="patient_complaint" id="patient_complaint" placeholder="Patient Complaint">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group-compact">
                                <label><i class="fas fa-vial text-muted me-1"></i> Advice for Lab tests</label>
                                <input type="text" class="form-control" name="advice_for_lab_tests" id="advice_for_lab_tests" placeholder="Advice for Lab tests">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group-compact">
                                <label><i class="fas fa-calendar-day text-muted me-1"></i> Bill Date</label>
                                <input type="date" class="form-control" name="order_date" id="order_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 14px 0; border-color: #e2e8f0;">

                    <!-- Total items bar & + Add Product button -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-weight: 700; font-size: 14px; color: #1e293b;" id="itemsCountBadge">Total items : 0</span>
                        <button type="button" class="btn btn-submit-main btn-sm py-1 px-3" id="addProductModalBtn">
                            <i class="fas fa-plus me-1"></i> Add Custom Product
                        </button>
                    </div>

                    <!-- Full-Width Search Input -->
                    <div class="search-input-wrap mb-3">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control" id="productSearchInput" placeholder="Search name, category, batch or barcode..." autocomplete="off">
                        <div id="searchDropdownResults"></div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle mb-0" id="saleItemsTable">
                            <thead style="background-color: #cfece0; color: #1e293b; font-size: 12.5px;">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Medicine / Product</th>
                                    <th style="width: 120px;">Batch</th>
                                    <th style="width: 120px;">Expiry</th>
                                    <th style="width: 75px;" class="text-center">Stock</th>
                                    <th style="width: 80px;" class="text-center">Qty</th>
                                    <th style="width: 100px;" class="text-end">Price (₹)</th>
                                    <th style="width: 80px;" class="text-center">Disc %</th>
                                    <th style="width: 80px;" class="text-center">GST %</th>
                                    <th style="width: 110px;" class="text-end">Total (₹)</th>
                                    <th style="width: 50px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="saleItemsBody">
                                <tr id="noItemRow">
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        <i class="fas fa-pills fa-2x mb-2 d-block" style="color: #f89884;"></i>
                                        Search medicines above or scan barcode to add to bill
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Charges Row: Shipping, Misc, Disc %, Disc Rate, Remarks -->
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group-compact">
                                <label>Shipping Charges</label>
                                <input type="number" step="0.01" class="form-control" name="shipping" id="shipping_charges" value="0">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group-compact">
                                <label>Misc Charges</label>
                                <input type="number" step="0.01" class="form-control" name="misc_charges" id="misc_charges" value="0">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group-compact">
                                <label>Disc % (Overall)</label>
                                <input type="number" step="0.01" class="form-control" name="overall_disc_percent" id="overall_disc_percent" value="0">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group-compact">
                                <label>Disc Rate (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="overall_disc_rate" id="overall_disc_rate" value="0">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-12">
                            <div class="form-group-compact">
                                <label>Remarks (Optional)</label>
                                <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter remarks">
                            </div>
                        </div>
                    </div>

                    <!-- Subtotal & Grand Total Display -->
                    <div class="d-flex justify-content-between align-items-center py-2 px-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div>
                            <span class="text-muted" style="font-size: 13.5px;">Subtotal:</span>
                            <strong style="color: #1e293b; font-size: 14px;" class="ms-1" id="displaySubtotal">₹0.00</strong>
                        </div>
                        <div>
                            <span style="font-size: 14.5px; font-weight: 700; color: #1e293b;">Grand Total:</span>
                            <span style="font-size: 18px; font-weight: 800; color: #f89884;" class="ms-1" id="displayGrandTotal">₹0.00</span>
                        </div>
                    </div>

                    <!-- Payment Mode Section -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-1 mb-2">
                            <i class="far fa-folder-open text-warning"></i>
                            <span style="font-size: 13px; font-weight: 700; color: #1e293b;">Payment Mode</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="pay-mode-btn" data-mode="pay_later">
                                <i class="fas fa-clock text-warning"></i> Pay Later
                            </div>
                            <div class="pay-mode-btn active" data-mode="cash">
                                <i class="fas fa-money-bill-wave text-success"></i> Cash
                            </div>
                            <div class="pay-mode-btn" data-mode="debit">
                                <i class="fas fa-credit-card text-info"></i> Debit
                            </div>
                            <div class="pay-mode-btn" data-mode="cash_online">
                                <i class="fas fa-wallet text-primary"></i> Cash+Online
                            </div>
                            <div class="pay-mode-btn" data-mode="upi">
                                <i class="fas fa-qrcode text-danger"></i> UPI Paid
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" id="payment_method" value="cash">
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-submit-main flex-fill d-flex justify-content-between align-items-center py-2 px-4" id="btnGenerateBill" onclick="submitSale(false)">
                            <span>Total Amount : <span id="footerTotalAmount">₹0.00</span></span>
                            <span>Generate Bill <i class="fas fa-arrow-right ms-1"></i></span>
                        </button>
                        <button type="button" class="btn btn-submit-main flex-fill py-2 px-4" id="btnGenerateBillNew" onclick="submitSale(true)">
                            <i class="fas fa-plus me-1"></i> Generate Bill & New Sale
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Quick Add Patient -->
<div class="modal fade" id="quickAddPatientModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: #f89884; color: #fff; padding: 16px 24px;">
                <h5 class="modal-title font-weight-bold" style="color: #fff;"><i class="fas fa-user-plus me-2"></i> Add Patient</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickPatientForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group-compact">
                        <label>Patient Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="quick_patient_name" id="quick_patient_name" required placeholder="Full Name">
                    </div>
                    <div class="form-group-compact">
                        <label>Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="quick_patient_phone" id="quick_patient_phone" required placeholder="10-digit mobile">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group-compact">
                                <label>Age</label>
                                <input type="number" class="form-control" name="quick_patient_age" id="quick_patient_age" placeholder="Age" min="0" max="150">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group-compact">
                                <label>Gender</label>
                                <select class="form-control" name="quick_patient_gender" id="quick_patient_gender">
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-back-main" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-submit-main">Save Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Add Custom Product -->
<div class="modal fade" id="addCustomProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: #f89884; color: #fff; padding: 16px 24px;">
                <h5 class="modal-title font-weight-bold" style="color: #fff;"><i class="fas fa-pills me-2"></i> Add Custom Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="customProductForm">
                <div class="modal-body p-4">
                    <div class="form-group-compact">
                        <label>Medicine / Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="custom_product_name" required placeholder="Medicine Name">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group-compact">
                                <label>Batch No</label>
                                <input type="text" class="form-control" id="custom_batch_no" placeholder="Batch">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group-compact">
                                <label>Expiry Date</label>
                                <input type="date" class="form-control" id="custom_expiry_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group-compact">
                                <label>Price (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="custom_price" required placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group-compact">
                                <label>GST %</label>
                                <select class="form-control" id="custom_gst">
                                    <option value="0">0%</option>
                                    <option value="5">5%</option>
                                    <option value="12" selected>12%</option>
                                    <option value="18">18%</option>
                                    <option value="28">28%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-back-main" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-submit-main">Add to Bill</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const allMedicines = @json($medicines);
    let selectedItems = [];
    const token = '{{ csrf_token() }}';
    const branchId = '{{ session("selectedBranchId") ?? (Auth::user()->branch_id ?? 1) }}';

    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({ width: '100%' });
        }
    });

    // Populate patient fields on change
    $('#patient_id').on('change', function() {
        const sel = $(this).find('option:selected');
        if (sel.val()) {
            $('#patient_phone').val(sel.data('phone') || '');
            $('#patient_age').val(sel.data('age') || '');
            if (sel.data('sex')) $('#patient_sex').val(sel.data('sex'));
            $('#patient_bp').val(sel.data('bp') || '');
            $('#patient_temperature').val(sel.data('temp') || '');
            $('#patient_pulse').val(sel.data('pulse') || '');
            $('#patient_history').val(sel.data('history') || '');
            $('#patient_complaint').val(sel.data('complaint') || '');
            $('#advice_for_lab_tests').val(sel.data('lab') || '');
        }
    });

    // Quick add patient modal
    $('#quickAddPatientBtn').on('click', function(e) {
        e.preventDefault();
        $('#quickPatientForm')[0].reset();
        const myModal = new bootstrap.Modal(document.getElementById('quickAddPatientModal'));
        myModal.show();
    });

    $('#quickPatientForm').on('submit', function(e) {
        e.preventDefault();
        const name = $('#quick_patient_name').val().trim();
        const phone = $('#quick_patient_phone').val().trim();
        const age = $('#quick_patient_age').val();
        const gender = $('#quick_patient_gender').val();

        if (!name || !phone) {
            alert('Please fill in patient name and phone.');
            return;
        }

        const newId = 'NEW_' + Date.now();
        const newOption = new Option(`${name} (${phone})`, newId, true, true);
        $(newOption).data('phone', phone).data('age', age).data('sex', gender);
        $('#patient_id').append(newOption).trigger('change');

        $('#patient_phone').val(phone);
        $('#patient_age').val(age);
        $('#patient_sex').val(gender);

        bootstrap.Modal.getInstance(document.getElementById('quickAddPatientModal')).hide();
    });

    // Add custom product modal
    $('#addProductModalBtn').on('click', function() {
        $('#customProductForm')[0].reset();
        const myModal = new bootstrap.Modal(document.getElementById('addCustomProductModal'));
        myModal.show();
    });

    $('#customProductForm').on('submit', function(e) {
        e.preventDefault();
        const name = $('#custom_product_name').val().trim();
        const batch = $('#custom_batch_no').val().trim();
        const expiry = $('#custom_expiry_date').val();
        const price = parseFloat($('#custom_price').val()) || 0;
        const gst = parseFloat($('#custom_gst').val()) || 0;

        selectedItems.push({
            id: 'CUSTOM_' + Date.now(),
            name: name,
            batch_no: batch,
            expiry_date: expiry,
            stock: 999,
            qty: 1,
            price: price,
            discount_percent: 0,
            gst_percent: gst,
            is_custom: 1,
        });

        renderTable();
        bootstrap.Modal.getInstance(document.getElementById('addCustomProductModal')).hide();
    });

    // Payment method selector
    $('.pay-mode-btn').on('click', function() {
        $('.pay-mode-btn').removeClass('active');
        $(this).addClass('active');
        $('#payment_method').val($(this).data('mode'));
    });

    // Search Autocomplete
    $('#productSearchInput').on('keyup focus', function() {
        const query = $(this).val().toLowerCase().trim();
        const resultsBox = $('#searchDropdownResults');
        if (query.length < 1) {
            resultsBox.hide().empty();
            return;
        }

        const matches = allMedicines.filter(m => 
            (m.name && m.name.toLowerCase().includes(query)) ||
            (m.barcode && m.barcode.toLowerCase().includes(query)) ||
            (m.batch_no && m.batch_no.toLowerCase().includes(query))
        );

        if (matches.length === 0) {
            resultsBox.html('<div class="p-3 text-center text-muted">No medicines found. Click "+ Add Custom Product" above.</div>').show();
            return;
        }

        let html = '';
        matches.slice(0, 15).forEach(m => {
            html += `
                <div class="search-result-item" data-id="${m.id}">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong style="color: #1e293b;">${m.name}</strong>
                        <span class="badge" style="background-color: #cfece0; color: #1f513f;">Stock: ${m.quantity || 0}</span>
                    </div>
                    <div class="text-muted" style="font-size: 12px;">
                        Price: ₹${parseFloat(m.mrp || m.purchase_price || 0).toFixed(2)} | Batch: ${m.batch_no || 'N/A'} | Exp: ${m.expiry_date || 'N/A'}
                    </div>
                </div>
            `;
        });
        resultsBox.html(html).show();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#productSearchInput, #searchDropdownResults').length) {
            $('#searchDropdownResults').hide();
        }
    });

    $(document).on('click', '.search-result-item', function() {
        const id = $(this).data('id');
        const med = allMedicines.find(m => m.id == id);
        if (med) {
            addItemToSale(med);
        }
        $('#productSearchInput').val('');
        $('#searchDropdownResults').hide();
    });

    function addItemToSale(med) {
        const existing = selectedItems.find(i => i.id == med.id);
        if (existing) {
            existing.qty += 1;
        } else {
            selectedItems.push({
                id: med.id,
                name: med.name,
                batch_no: med.batch_no || '',
                expiry_date: med.expiry_date || '',
                stock: med.quantity || 0,
                qty: 1,
                price: parseFloat(med.mrp || med.unit || med.purchase_price || 0),
                discount_percent: 0,
                gst_percent: (med.gst_option === 'With GST' ? 12 : 0),
                is_custom: 0,
            });
        }
        renderTable();
    }

    function renderTable() {
        if (selectedItems.length === 0) {
            $('#saleItemsBody').html(`
                <tr id="noItemRow">
                    <td colspan="11" class="text-center py-4 text-muted">
                        <i class="fas fa-pills fa-2x mb-2 d-block" style="color: #f89884;"></i>
                        Search medicines above or scan barcode to add to bill
                    </td>
                </tr>
            `);
            $('#itemsCountBadge').text('Total items : 0');
            recalcTotals();
            return;
        }

        let rows = '';
        selectedItems.forEach((item, idx) => {
            const lineTotal = item.qty * item.price * (1 - (item.discount_percent / 100));
            rows += `
                <tr data-index="${idx}">
                    <td class="text-center">${idx + 1}</td>
                    <td><strong>${item.name}</strong></td>
                    <td><input type="text" class="form-control form-control-sm item-batch" value="${item.batch_no}" style="height: 32px !important; font-size: 12.5px;"></td>
                    <td><input type="text" class="form-control form-control-sm item-expiry" value="${item.expiry_date}" style="height: 32px !important; font-size: 12.5px;"></td>
                    <td class="text-center"><span class="badge" style="background: #f1f5f9; color: #475569;">${item.stock}</span></td>
                    <td><input type="number" min="1" class="form-control form-control-sm item-qty text-center" value="${item.qty}" style="height: 32px !important;"></td>
                    <td><input type="number" step="0.01" min="0" class="form-control form-control-sm item-price text-end" value="${item.price.toFixed(2)}" style="height: 32px !important;"></td>
                    <td><input type="number" min="0" max="100" class="form-control form-control-sm item-disc text-center" value="${item.discount_percent}" style="height: 32px !important;"></td>
                    <td><input type="number" min="0" class="form-control form-control-sm item-gst text-center" value="${item.gst_percent}" style="height: 32px !important;"></td>
                    <td class="fw-bold line-total text-end">₹${lineTotal.toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item" style="border-radius: 50px; width: 30px; height: 30px; padding: 0;"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });

        $('#saleItemsBody').html(rows);
        $('#itemsCountBadge').text(`Total items : ${selectedItems.length}`);
        recalcTotals();
    }

    $(document).on('input', '.item-qty, .item-price, .item-disc, .item-gst', function() {
        const row = $(this).closest('tr');
        const idx = row.data('index');
        const item = selectedItems[idx];
        if (item) {
            item.qty = parseInt(row.find('.item-qty').val()) || 1;
            item.price = parseFloat(row.find('.item-price').val()) || 0;
            item.discount_percent = parseFloat(row.find('.item-disc').val()) || 0;
            item.gst_percent = parseFloat(row.find('.item-gst').val()) || 0;
            const lineTot = item.qty * item.price * (1 - (item.discount_percent / 100));
            row.find('.line-total').text('₹' + lineTot.toFixed(2));
            recalcTotals();
        }
    });

    $(document).on('click', '.btn-remove-item', function() {
        const idx = $(this).closest('tr').data('index');
        selectedItems.splice(idx, 1);
        renderTable();
    });

    function recalcTotals() {
        let subtotal = 0;
        selectedItems.forEach(i => {
            subtotal += i.qty * i.price * (1 - (i.discount_percent / 100));
        });

        const shipping = parseFloat($('#shipping_charges').val()) || 0;
        const misc = parseFloat($('#misc_charges').val()) || 0;
        const discPercent = parseFloat($('#overall_disc_percent').val()) || 0;
        let discRate = parseFloat($('#overall_disc_rate').val()) || 0;

        if (discPercent > 0) {
            discRate = subtotal * (discPercent / 100);
            $('#overall_disc_rate').val(discRate.toFixed(2));
        }

        const grandTotal = Math.max(0, subtotal + shipping + misc - discRate);

        $('#displaySubtotal').text('₹' + subtotal.toFixed(2));
        $('#displayGrandTotal').text('₹' + grandTotal.toFixed(2));
        $('#footerTotalAmount').text('₹' + grandTotal.toFixed(2));
    }

    $('#shipping_charges, #misc_charges, #overall_disc_percent, #overall_disc_rate').on('input', recalcTotals);

    // Form Submit
    function submitSale(isNewAfter = false) {
        if (selectedItems.length === 0) {
            alert('Please add at least one medicine/product to generate bill.');
            return;
        }

        let subtotal = 0;
        selectedItems.forEach(i => {
            subtotal += i.qty * i.price * (1 - (i.discount_percent / 100));
        });

        const shipping = parseFloat($('#shipping_charges').val()) || 0;
        const misc = parseFloat($('#misc_charges').val()) || 0;
        const discRate = parseFloat($('#overall_disc_rate').val()) || 0;
        const grandTotal = Math.max(0, subtotal + shipping + misc - discRate);

        const payload = {
            patient_id: $('#patient_id').val() && !$('#patient_id').val().startsWith('NEW_') ? $('#patient_id').val() : null,
            patient_name: $('#patient_id').val() && $('#patient_id').val().startsWith('NEW_') ? $('#patient_id option:selected').text().split('(')[0].trim() : ($('#patient_id option:selected').text().split('(')[0].trim() || 'Walk-in Patient'),
            patient_phone: $('#patient_phone').val(),
            patient_age: $('#patient_age').val(),
            patient_sex: $('#patient_sex').val(),
            patient_bp: $('#patient_bp').val(),
            patient_temperature: $('#patient_temperature').val(),
            patient_pulse: $('#patient_pulse').val(),
            patient_history: $('#patient_history').val(),
            patient_complaint: $('#patient_complaint').val(),
            advice_for_lab_tests: $('#advice_for_lab_tests').val(),
            order_date: $('#order_date').val(),
            gst_option: $('input[name="gst_option"]:checked').val(),
            payment_method: $('#payment_method').val(),
            shipping: shipping,
            misc_charges: misc,
            discount: discRate,
            subtotal: subtotal,
            total: grandTotal,
            remarks: $('#remarks').val(),
            branch_id: branchId,
            items: selectedItems.map(i => ({
                product_id: i.id,
                name: i.name,
                batch_no: i.batch_no,
                expiry_date: i.expiry_date,
                quantity: i.qty,
                price: i.price,
                discount_percent: i.discount_percent,
                gst_percent: i.gst_percent,
                total: i.qty * i.price * (1 - (i.discount_percent / 100)),
            })),
        };

        $('#btnGenerateBill, #btnGenerateBillNew').prop('disabled', true);

        $.ajax({
            url: '{{ url("api/order_sale") }}',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            data: payload,
            success: function(res) {
                if (res.status) {
                    alert('Sale Bill created successfully! Invoice: ' + res.order_number);
                    if (isNewAfter) {
                        window.location.reload();
                    } else {
                        window.location.href = '{{ route("sales.list") }}';
                    }
                } else {
                    alert(res.message || 'Error creating sale bill');
                    $('#btnGenerateBill, #btnGenerateBillNew').prop('disabled', false);
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON ? xhr.responseJSON.message : 'Error submitting sale');
                $('#btnGenerateBill, #btnGenerateBillNew').prop('disabled', false);
            }
        });
    }
</script>
@endsection
