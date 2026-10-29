@extends('layout.app')

@section('title', 'Add Sale')

@section('content')
<style>
    /* Site Theme: #f89884 and #cfece0 with 50% pill radius */
    .sale-card {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        background: #ffffff;
        margin-bottom: 20px;
    }
    .sale-card .card-body {
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
    .form-control {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 50px !important;
        padding: 8px 18px !important;
        font-size: 13.5px !important;
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
        color: #1e293b !important;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 24px !important;
        border-radius: 50px !important;
        transition: all 0.2s;
    }
    .btn-cancel-main:hover {
        background-color: #bce7d6 !important;
        color: #1e293b !important;
    }
    .btn-back-main {
        background-color: #cfece0 !important;
        border: 1px solid #b5e4d2 !important;
        color: #1e293b !important;
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
        color: #1e293b !important;
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

    /* Payment Mode Cards */
    .pay-mode-btn {
        flex: 1;
        min-height: 52px;
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
        border: 1px solid #cbd5e1;
        border-radius: 12px;
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
</style>

<div class="page-wrapper">
    <div class="content">
        <!-- Top Toolbar Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h4 class="page-title mb-0" style="font-weight: 700; font-size: 21px; color: #1e293b;">Add Sale</h4>
                <div class="form-check form-check-inline ms-2">
                    <input class="form-check-input" type="checkbox" id="chkMedicalReport">
                    <label class="form-check-label" for="chkMedicalReport" style="font-size: 13.5px; font-weight: 600;">Medical Report</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chkChallan">
                    <label class="form-check-label" for="chkChallan" style="font-size: 13.5px; font-weight: 600;">Challan</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chkCustom">
                    <label class="form-check-label" for="chkCustom" style="font-size: 13.5px; font-weight: 600;">Custom</label>
                </div>
                <div class="d-inline-flex align-items-center gap-2 border-start ps-3">
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="gst_option" id="radioNoGst" value="without_gst">
                        <label class="form-check-label" for="radioNoGst" style="font-size: 13.5px; font-weight: 600;">No GST</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="gst_option" id="radioGst" value="with_gst" checked>
                        <label class="form-check-label" for="radioGst" style="font-size: 13.5px; font-weight: 600;">GST</label>
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

            <!-- Patient Vitals & Clinical Info Card (Contractor/Company completely omitted) -->
            <div class="card sale-card">
                <div class="card-body">
                    <div class="row">
                        <!-- Patient Name -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
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

                        <!-- Phone -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-phone text-muted me-1"></i> Patient Phone</label>
                                <input type="text" class="form-control" name="patient_phone" id="patient_phone" placeholder="Patient number">
                            </div>
                        </div>

                        <!-- Age -->
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt text-muted me-1"></i> Age</label>
                                <input type="number" class="form-control" name="patient_age" id="patient_age" placeholder="Age" min="0" max="150">
                            </div>
                        </div>

                        <!-- Sex -->
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="form-group">
                                <label><i class="fas fa-venus-mars text-muted me-1"></i> Sex</label>
                                <select class="form-control" name="patient_sex" id="patient_sex">
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- B.P -->
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group">
                                <label><i class="fas fa-heartbeat text-danger me-1"></i> B.P</label>
                                <input type="text" class="form-control" name="patient_bp" id="patient_bp" placeholder="e.g. 120/80">
                            </div>
                        </div>

                        <!-- Temperature -->
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group">
                                <label><i class="fas fa-thermometer-half text-warning me-1"></i> Temperature</label>
                                <input type="text" class="form-control" name="patient_temperature" id="patient_temperature" placeholder="Temperature">
                            </div>
                        </div>

                        <!-- Pulse -->
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group">
                                <label><i class="fas fa-wave-square text-success me-1"></i> Pulse</label>
                                <input type="text" class="form-control" name="patient_pulse" id="patient_pulse" placeholder="Pulse">
                            </div>
                        </div>

                        <!-- Patient History -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-notes-medical text-muted me-1"></i> Patient History</label>
                                <input type="text" class="form-control" name="patient_history" id="patient_history" placeholder="Patient History">
                            </div>
                        </div>

                        <!-- Patient Complaint -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-stethoscope text-muted me-1"></i> Patient Complaint</label>
                                <input type="text" class="form-control" name="patient_complaint" id="patient_complaint" placeholder="Patient Complaint">
                            </div>
                        </div>

                        <!-- Advice for Lab tests -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-vial text-muted me-1"></i> Advice for Lab tests</label>
                                <input type="text" class="form-control" name="advice_for_lab_tests" id="advice_for_lab_tests" placeholder="Advice for Lab tests">
                            </div>
                        </div>

                        <!-- Bill Date -->
                        <div class="col-lg-2 col-md-4 col-12">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-day text-muted me-1"></i> Bill Date</label>
                                <input type="date" class="form-control" name="order_date" id="order_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicines / Products Selection Table Card -->
            <div class="card sale-card">
                <div class="card-body">
                    <!-- Search & Header Bar -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <span style="font-weight: 700; font-size: 15px; color: #1e293b;" id="itemsCountBadge">Total items : 0</span>
                        <div class="position-relative" style="flex: 1; max-width: 500px;">
                            <input type="text" class="form-control" id="productSearchInput" placeholder="Search name, category, batch or barcode..." autocomplete="off">
                            <div id="searchDropdownResults"></div>
                        </div>
                        <button type="button" class="btn btn-submit-main btn-sm py-2 px-3" id="addProductModalBtn" style="border-radius: 50px;">
                            <i class="fas fa-plus me-1"></i> Add Custom Product
                        </button>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="saleItemsTable">
                            <thead style="background-color: #cfece0; color: #1e293b; font-size: 13px;">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Medicine / Product</th>
                                    <th>Batch</th>
                                    <th>Expiry</th>
                                    <th>Stock</th>
                                    <th style="width: 90px;">Qty</th>
                                    <th style="width: 110px;">Price (₹)</th>
                                    <th style="width: 90px;">Disc %</th>
                                    <th style="width: 90px;">GST %</th>
                                    <th style="width: 120px;">Total (₹)</th>
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
                </div>
            </div>

            <!-- Billing Summary & Discounts Card -->
            <div class="card sale-card">
                <div class="card-body">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group mb-0">
                                <label>Shipping Charges</label>
                                <input type="number" class="form-control" name="shipping" id="shipping_charges" value="0" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group mb-0">
                                <label>Misc Charges</label>
                                <input type="number" class="form-control" name="misc_charges" id="misc_charges" value="0" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group mb-0">
                                <label>Disc % (Overall)</label>
                                <input type="number" class="form-control" name="overall_discount_percent" id="overall_disc_percent" value="0" min="0" max="100" step="0.01">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="form-group mb-0">
                                <label>Disc Rate (₹)</label>
                                <input type="number" class="form-control" name="overall_discount_amount" id="overall_disc_rate" value="0" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-8 col-12">
                            <div class="form-group mb-0">
                                <label>Remarks (Optional)</label>
                                <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter remarks">
                            </div>
                        </div>
                    </div>

                    <!-- Totals Display -->
                    <div class="d-flex justify-content-end gap-5 mt-4 pt-3 border-top">
                        <div>
                            <span class="text-muted fw-bold">Subtotal:</span>
                            <span class="fs-5 fw-bold text-dark ms-2" id="displaySubtotal">₹0.00</span>
                        </div>
                        <div>
                            <span style="color: #f89884; font-weight: 700; font-size: 16px;">Grand Total:</span>
                            <span class="fs-4 fw-bold ms-2" style="color: #f89884;" id="displayGrandTotal">₹0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Mode Selection Card -->
            <div class="card sale-card">
                <div class="card-body">
                    <label class="form-label fw-bold mb-3" style="font-size: 13.5px;"><i class="fas fa-wallet text-muted me-1"></i> Payment Mode</label>
                    <input type="hidden" name="payment_method" id="payment_method" value="cash">

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="pay-mode-btn" data-mode="pay_later">
                            <i class="fas fa-clock"></i> Pay Later
                        </button>
                        <button type="button" class="pay-mode-btn active" data-mode="cash">
                            <i class="fas fa-money-bill-wave"></i> Cash
                        </button>
                        <button type="button" class="pay-mode-btn" data-mode="debit">
                            <i class="fas fa-credit-card"></i> Debit / Bank
                        </button>
                        <button type="button" class="pay-mode-btn" data-mode="cash_online">
                            <i class="fas fa-exchange-alt"></i> Cash+Online
                        </button>
                        <button type="button" class="pay-mode-btn" data-mode="upi">
                            <i class="fas fa-qrcode"></i> UPI Paid
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Action Bar -->
            <div class="card sale-card" style="border: 2px solid #cfece0; background: #fffdfc;">
                <div class="card-body py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div style="font-size: 18px; font-weight: 700; color: #1e293b;">
                        Total Amount : <span id="footerTotalAmount" style="color: #f89884;">₹0.00</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-submit-main" id="btnGenerateBill">
                            Generate Bill <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                        <button type="button" class="btn btn-cancel-main" id="btnGenerateAndNew">
                            <i class="fas fa-plus me-1"></i> Generate Bill & New Sale
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Quick Add Patient -->
<div class="modal fade" id="modalQuickPatient" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="background: #cfece0; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">Quick Add Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group mb-3">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="m_patient_name" placeholder="Patient Name" required>
                </div>
                <div class="form-group mb-3">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" id="m_patient_phone" placeholder="10-digit Phone">
                </div>
                <div class="row">
                    <div class="col-6 form-group mb-3">
                        <label>Age</label>
                        <input type="number" class="form-control" id="m_patient_age" placeholder="Age">
                    </div>
                    <div class="col-6 form-group mb-3">
                        <label>Gender</label>
                        <select class="form-control" id="m_patient_gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-cancel-main" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-submit-main" id="btnSaveQuickPatient">Save Patient</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    const branchId = localStorage.getItem('selectedBranchId');

    if ($.fn.select2) {
        $('.select2').select2({ width: '100%' });
    }

    // Auto-fill vitals on patient select
    $('#patient_id').on('change', function() {
        const opt = $(this).find('option:selected');
        if (opt.val()) {
            $('#patient_phone').val(opt.data('phone') || '');
            $('#patient_age').val(opt.data('age') || '');
            if (opt.data('sex')) $('#patient_sex').val(opt.data('sex'));
            $('#patient_bp').val(opt.data('bp') || '');
            $('#patient_temperature').val(opt.data('temp') || '');
            $('#patient_pulse').val(opt.data('pulse') || '');
            $('#patient_history').val(opt.data('history') || '');
            $('#patient_complaint').val(opt.data('complaint') || '');
            $('#advice_for_lab_tests').val(opt.data('lab') || '');
        }
    });

    // Quick Add Patient
    $('#quickAddPatientBtn').on('click', function() {
        new bootstrap.Modal(document.getElementById('modalQuickPatient')).show();
    });

    $('#btnSaveQuickPatient').on('click', function() {
        const name = $('#m_patient_name').val().trim();
        if (!name) {
            alert('Patient name is required');
            return;
        }
        const phone = $('#m_patient_phone').val().trim();
        const age = $('#m_patient_age').val().trim();
        const gender = $('#m_patient_gender').val();

        const newOpt = new Option(name + (phone ? ' ('+phone+')' : ''), 'NEW_' + Date.now(), true, true);
        $(newOpt).data('phone', phone).data('age', age).data('sex', gender);
        $('#patient_id').append(newOpt).trigger('change');

        $('#patient_phone').val(phone);
        $('#patient_age').val(age);
        $('#patient_sex').val(gender);

        bootstrap.Modal.getInstance(document.getElementById('modalQuickPatient')).hide();
        $('#m_patient_name').val('');
        $('#m_patient_phone').val('');
        $('#m_patient_age').val('');
    });

    // Payment Mode Click
    $('.pay-mode-btn').on('click', function() {
        $('.pay-mode-btn').removeClass('active');
        $(this).addClass('active');
        $('#payment_method').val($(this).data('mode'));
    });

    // Medicines live search
    const allMedicines = @json($medicines);
    let selectedItems = [];

    $('#productSearchInput').on('input', function() {
        const query = $(this).val().toLowerCase().trim();
        if (!query) {
            $('#searchDropdownResults').hide();
            return;
        }

        const filtered = allMedicines.filter(m => 
            (m.name && m.name.toLowerCase().includes(query)) ||
            (m.barcode && m.barcode.toLowerCase().includes(query)) ||
            (m.batch_no && m.batch_no.toLowerCase().includes(query))
        ).slice(0, 8);

        if (filtered.length === 0) {
            $('#searchDropdownResults').html('<div class="p-3 text-muted text-center">No medicines found</div>').show();
            return;
        }

        let html = '';
        filtered.forEach(m => {
            const price = m.mrp || m.unit || m.purchase_price || 0;
            html += `
                <div class="search-result-item d-flex justify-content-between align-items-center" data-id="${m.id}">
                    <div>
                        <div class="fw-bold text-dark">${m.name}</div>
                        <small class="text-muted">Stock: ${m.quantity || 0} | Batch: ${m.batch_no || 'N/A'} | Exp: ${m.expiry_date || 'N/A'}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge" style="background:#cfece0; color:#1e293b; font-size:13px;">₹${parseFloat(price).toFixed(2)}</span>
                    </div>
                </div>
            `;
        });

        $('#searchDropdownResults').html(html).show();
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
                    <td>${idx + 1}</td>
                    <td><strong>${item.name}</strong></td>
                    <td><input type="text" class="form-control form-control-sm item-batch" value="${item.batch_no}" style="height: 34px !important;"></td>
                    <td><input type="text" class="form-control form-control-sm item-expiry" value="${item.expiry_date}" style="height: 34px !important;"></td>
                    <td><span class="badge bg-light text-dark">${item.stock}</span></td>
                    <td><input type="number" min="1" class="form-control form-control-sm item-qty" value="${item.qty}" style="height: 34px !important;"></td>
                    <td><input type="number" step="0.01" min="0" class="form-control form-control-sm item-price" value="${item.price.toFixed(2)}" style="height: 34px !important;"></td>
                    <td><input type="number" min="0" max="100" class="form-control form-control-sm item-disc" value="${item.discount_percent}" style="height: 34px !important;"></td>
                    <td><input type="number" min="0" class="form-control form-control-sm item-gst" value="${item.gst_percent}" style="height: 34px !important;"></td>
                    <td class="fw-bold line-total">₹${lineTotal.toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item" style="border-radius: 50px;"><i class="fas fa-trash"></i></button>
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

        $('#btnGenerateBill').prop('disabled', true).text('Generating...');

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
                    alert(res.message || 'Error generating bill');
                    $('#btnGenerateBill').prop('disabled', false).html('Generate Bill <i class="fas fa-arrow-right ms-1"></i>');
                }
            },
            error: function(err) {
                $('#btnGenerateBill').prop('disabled', false).html('Generate Bill <i class="fas fa-arrow-right ms-1"></i>');
                alert(err.responseJSON ? (err.responseJSON.message || JSON.stringify(err.responseJSON.errors)) : 'Error generating bill');
            }
        });
    }

    $('#addSaleForm').on('submit', function(e) {
        e.preventDefault();
        submitSale(false);
    });

    $('#btnGenerateAndNew').on('click', function() {
        submitSale(true);
    });
});
</script>
@endsection

