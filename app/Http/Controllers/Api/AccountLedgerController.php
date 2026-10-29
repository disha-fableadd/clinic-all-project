<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Patients;
use App\Models\Supplier;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;

class AccountLedgerController extends Controller
{
    public function getLedgerDetails(Request $request)
    {
        $type = $request->input('type', 'patient'); // 'patient' or 'vendor'
        $id = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Please select an entity.',
            ], 422);
        }

        if ($type === 'patient') {
            $patient = Patients::find($id);
            if (!$patient) {
                return response()->json(['status' => false, 'message' => 'Patient not found'], 404);
            }

            $query = Invoice::where('patient_id', $id);

            if ($startDate) {
                $query->whereDate('date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('date', '<=', $endDate);
            }

            $invoices = $query->orderBy('date', 'desc')->get();

            $paidInvoices = [];
            $pendingInvoices = [];
            $totalInvoiced = 0;
            $totalPaid = 0;
            $totalPending = 0;

            foreach ($invoices as $inv) {
                $grandTotal = (float) ($inv->grand_total ?? 0);
                $totalInvoiced += $grandTotal;

                $items = json_decode($inv->types_details, true);
                $itemNames = [];
                if (is_array($items)) {
                    foreach ($items as $it) {
                        $itemNames[] = ($it['name'] ?? 'Item') . ' (x' . ($it['quantity'] ?? 1) . ')';
                    }
                }
                $summary = implode(', ', $itemNames);

                $record = [
                    'id' => $inv->id,
                    'invoice_no' => 'INV-' . ($inv->type_id ?? $inv->id),
                    'date' => $inv->date ? date('d-M-Y', strtotime($inv->date)) : 'N/A',
                    'amount' => $grandTotal,
                    'payment_type' => $inv->payment_type ?? 'Cash',
                    'payment_status' => $inv->payment_status ?? 'pending',
                    'summary' => $summary ?: ucfirst($inv->type ?? 'General'),
                ];

                if (strtolower($inv->payment_status) === 'paid') {
                    $totalPaid += $grandTotal;
                    $paidInvoices[] = $record;
                } else {
                    $totalPending += $grandTotal;
                    $pendingInvoices[] = $record;
                }
            }

            return response()->json([
                'status' => true,
                'entity' => [
                    'id' => $patient->id,
                    'name' => $patient->fullname,
                    'phone' => $patient->phone,
                    'email' => $patient->email,
                ],
                'opening_balance' => 0.00,
                'paid_invoices' => $paidInvoices,
                'pending_invoices' => $pendingInvoices,
                'total_invoiced' => round($totalInvoiced, 2),
                'total_paid' => round($totalPaid, 2),
                'total_pending' => round($totalPending, 2),
                'closing_balance' => round($totalPending, 2),
            ]);
        }

        if ($type === 'vendor') {
            $vendor = Supplier::find($id);
            if (!$vendor) {
                return response()->json(['status' => false, 'message' => 'Vendor not found'], 404);
            }

            $openingBalance = (float) ($vendor->opening_balance ?? 0);

            // Fetch purchases from inventory where supplier_id = $id
            $query = Inventory::where('supplier_id', $id);
            if ($startDate) {
                $query->whereDate('purchase_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('purchase_date', '<=', $endDate);
            }
            $purchases = $query->orderBy('purchase_date', 'desc')->get();

            $purchaseRecords = [];
            $totalPurchases = 0;

            foreach ($purchases as $p) {
                $purchaseRecords[] = [
                    'id' => $p->id,
                    'invoice_no' => 'PUR-' . $p->id,
                    'date' => $p->purchase_date ? date('d-M-Y', strtotime($p->purchase_date)) : 'N/A',
                    'summary' => $p->item_name . ' (Qty: ' . $p->quantity . ')',
                    'status' => ucfirst($p->status ?? 'active'),
                ];
            }

            return response()->json([
                'status' => true,
                'entity' => [
                    'id' => $vendor->id,
                    'name' => $vendor->name,
                    'contact_person' => $vendor->contact_person,
                    'phone' => $vendor->phone,
                    'gstin' => $vendor->gst_number,
                ],
                'opening_balance' => round($openingBalance, 2),
                'purchases' => $purchaseRecords,
                'closing_balance' => round($openingBalance, 2),
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid ledger type'], 400);
    }
}

