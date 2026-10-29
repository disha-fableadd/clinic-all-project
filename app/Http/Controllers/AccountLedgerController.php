<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Supplier;

class AccountLedgerController extends Controller
{
    public function index(Request $request)
    {
        $branchId = auth()->user()->branch_id ?? null;

        $patients = Patients::when($branchId, function ($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->select('id', 'fullname', 'phone')->orderBy('fullname')->get();

        $vendors = Supplier::when($branchId, function ($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->select('id', 'name', 'phone')->orderBy('name')->get();

        return view('account_ledger.index', compact('patients', 'vendors'));
    }
}

