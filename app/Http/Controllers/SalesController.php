<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Patients;
use App\Models\TaxRate;
use App\Models\BankMaster;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function sales_list(Request $request)
    {
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;

        $query = Order::with(['order_items.product', 'patients'])
            ->where('isDeleted', 0);

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->orWhereNull('branch_id');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('order_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(20);

        $totalSales = Order::where('isDeleted', 0)->sum('total_amount');
        $totalPaid = Order::where('isDeleted', 0)->where('payment_status', 'paid')->sum('total_amount');
        $totalRemaining = Order::where('isDeleted', 0)->sum('remaining_amount');

        return view('sales.saleslist', compact('orders', 'totalSales', 'totalPaid', 'totalRemaining'));
    }

    public function pos(Request $request)
    {
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;

        $categories = Category::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $brands = Brand::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $taxes = TaxRate::where('status', 'active')->where('isDeleted', 0)->get();
        $patients = Patients::orderBy('id', 'desc')->get();
        $banks = BankMaster::where('status', 1)->where('isDeleted', 0)->get();
        $medicines = Medicine::orderBy('name', 'asc')->get();

        return view('sales.add-sales', compact('categories', 'brands', 'taxes', 'patients', 'banks', 'medicines'));
    }

    public function add_sales(Request $request)
    {
        return $this->pos($request);
    }

    public function salse_invoice($id)
    {
        $order = Order::with(['order_items.product', 'patients', 'payments'])->findOrFail($id);
        $setting = Setting::first();
        return view('sales.salse-invoice', compact('order', 'setting'));
    }

    public function sales_details($id)
    {
        $order = Order::with(['order_items.product', 'patients', 'payments'])->findOrFail($id);
        return view('sales.sales-details', compact('order'));
    }

    public function edit_sales($id)
    {
        $order = Order::with(['order_items.product', 'patients', 'payments'])->findOrFail($id);
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;
        $categories = Category::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $brands = Brand::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $taxes = TaxRate::where('status', 'active')->where('isDeleted', 0)->get();
        $patients = Patients::orderBy('id', 'desc')->get();
        $banks = BankMaster::where('status', 1)->where('isDeleted', 0)->get();
        $medicines = Medicine::orderBy('name', 'asc')->get();

        return view('sales.edit-sales', compact('order', 'categories', 'brands', 'taxes', 'patients', 'banks', 'medicines'));
    }
}

