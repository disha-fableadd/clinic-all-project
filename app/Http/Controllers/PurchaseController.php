<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\Purchases;
use App\Models\Supplier;
use App\Models\Medicine;
use App\Models\Category;
use App\Models\Brand;
use App\Models\TaxRate;
use App\Models\BankMaster;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function purchase_list(Request $request)
    {
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;

        $query = PurchaseInvoice::with(['vendor'])
            ->where('isDeleted', 0);

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->orWhereNull('branch_id');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $purchases = $query->orderBy('id', 'desc')->paginate(20);

        $totalPurchases = PurchaseInvoice::where('isDeleted', 0)->sum('grand_total');
        $totalPaid = PurchaseInvoice::where('isDeleted', 0)->sum('paid');
        $totalRemaining = PurchaseInvoice::where('isDeleted', 0)->sum('remaining_amount');
        $vendors = Supplier::orderBy('name', 'asc')->get();

        return view('purchase.purchaselist', compact('purchases', 'totalPurchases', 'totalPaid', 'totalRemaining', 'vendors'));
    }

    public function add_purchase(Request $request)
    {
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;

        $vendors = Supplier::orderBy('name', 'asc')->get();
        $categories = Category::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $brands = Brand::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $taxes = TaxRate::where('status', 'active')->where('isDeleted', 0)->get();
        $medicines = Medicine::orderBy('name', 'asc')->get();
        $banks = BankMaster::where('status', 1)->where('isDeleted', 0)->get();

        return view('purchase.addpurchase', compact('vendors', 'categories', 'brands', 'taxes', 'medicines', 'banks'));
    }

    public function purchase_invoice($id)
    {
        $invoice = PurchaseInvoice::with(['vendor'])->findOrFail($id);
        $setting = Setting::first();
        return view('purchase.purchase_invoice', compact('invoice', 'setting'));
    }

    public function edit_purchase($id)
    {
        $invoice = PurchaseInvoice::with(['vendor', 'purchases'])->findOrFail($id);
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;

        $vendors = Supplier::orderBy('name', 'asc')->get();
        $categories = Category::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $brands = Brand::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $taxes = TaxRate::where('status', 'active')->where('isDeleted', 0)->get();
        $medicines = Medicine::orderBy('name', 'asc')->get();
        $banks = BankMaster::where('status', 1)->where('isDeleted', 0)->get();

        return view('purchase.editpurchase', compact('invoice', 'vendors', 'categories', 'brands', 'taxes', 'medicines', 'banks'));
    }

    public function storeBankAjax(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric|min:0',
        ]);

        $bank = BankMaster::create([
            'bank_name' => $validated['bank_name'],
            'name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'ifsc_code' => $validated['ifsc_code'] ?? '',
            'branch_name' => $validated['branch_name'] ?? '',
            'opening_balance' => $validated['opening_balance'] ?? 0,
            'status' => 1,
            'isDeleted' => 0,
        ]);

        return response()->json([
            'status' => true,
            'bank' => $bank,
            'message' => 'Bank account added successfully.'
        ]);
    }
}

