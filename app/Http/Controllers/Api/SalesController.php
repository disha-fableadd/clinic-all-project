<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use App\Models\Patients;
use App\Models\PaymentStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function order_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $branchId = $request->branch_id ?? session('selectedBranchId') ?? optional(Auth::user())->branch_id ?? 1;
            $userId = optional(Auth::user())->id;

            // 1. Resolve / Create Patient & Vitals
            $patientId = null;
            if (!empty($request->patient_id) && is_numeric($request->patient_id)) {
                $patient = Patients::find($request->patient_id);
                if ($patient) {
                    $patientId = $patient->id;
                    // Update vitals if passed
                    if ($request->filled('patient_bp')) $patient->bp = $request->patient_bp;
                    if ($request->filled('patient_temperature')) $patient->temperature = $request->patient_temperature;
                    if ($request->filled('patient_pulse')) $patient->pulse = $request->patient_pulse;
                    if ($request->filled('patient_history')) $patient->patient_history = $request->patient_history;
                    if ($request->filled('patient_complaint')) $patient->patient_complaint = $request->patient_complaint;
                    if ($request->filled('advice_for_lab_tests')) $patient->advice_for_lab_tests = $request->advice_for_lab_tests;
                    if ($request->filled('patient_age')) $patient->age = $request->patient_age;
                    if ($request->filled('patient_sex')) $patient->gender = $request->patient_sex;
                    $patient->save();
                }
            } elseif (!empty($request->patient_name)) {
                // Quick create patient
                $patient = Patients::create([
                    'fullname' => $request->patient_name,
                    'phone' => $request->patient_phone ?? null,
                    'age' => $request->patient_age ?? null,
                    'gender' => $request->patient_sex ?? 'Male',
                    'bp' => $request->patient_bp ?? null,
                    'temperature' => $request->patient_temperature ?? null,
                    'pulse' => $request->patient_pulse ?? null,
                    'patient_history' => $request->patient_history ?? null,
                    'patient_complaint' => $request->patient_complaint ?? null,
                    'advice_for_lab_tests' => $request->advice_for_lab_tests ?? null,
                    'branch_id' => $branchId,
                    'status' => 'active',
                ]);
                $patientId = $patient->id;
            }

            // 2. Generate unique order / invoice number
            $latestId = (Order::max('id') ?? 0) + 1;
            $orderNumber = 'INV-' . str_pad($latestId, 6, '0', STR_PAD_LEFT);

            $paymentMethod = $request->payment_method ?? 'cash';
            $totalAmount = (float) $request->total;
            $paidAmount = in_array($paymentMethod, ['pay_later', 'credit']) ? 0.00 : $totalAmount;
            $remainingAmount = max(0, $totalAmount - $paidAmount);
            $paymentStatus = $remainingAmount <= 0 ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending');

            // 3. Create Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $patientId,
                'order_date' => $request->order_date ?? now()->toDateString(),
                'order_type' => $request->order_type ?? 'sale',
                'discount' => $request->discount ?? 0,
                'discount_percent' => $request->overall_discount_percent ?? null,
                'discount_amount' => $request->overall_discount_amount ?? null,
                'round_off' => $request->round_off ?? 0,
                'shipping' => $request->shipping ?? 0,
                'misc_charges' => $request->misc_charges ?? 0,
                'gst_option' => $request->gst_option ?? 'without_gst',
                'branch_id' => $branchId,
                'created_by' => $userId,
                'total_amount' => $totalAmount,
                'remaining_amount' => $remainingAmount,
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethod,
                'order_invoice' => $orderNumber,
                'remarks' => $request->remarks ?? null,
                'is_emergency' => $request->is_emergency ?? 0,
                'isDeleted' => 0,
            ]);

            // 4. Attach Patient pivot
            if ($patientId) {
                DB::table('order_patient')->updateOrInsert(
                    ['order_id' => $order->id, 'patient_id' => $patientId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            // 5. Create Order Items & Decrement Medicine Stock
            foreach ($request->items as $item) {
                $qty = (int) ($item['quantity'] ?? 1);
                $price = (float) ($item['price'] ?? 0);
                $mrp = (float) ($item['mrp'] ?? $price);
                $total = (float) ($item['total'] ?? ($qty * $price));

                $productId = !empty($item['product_id']) ? (int) $item['product_id'] : null;
                $isCustom = !empty($item['is_custom']) || !$productId;
                $customName = $item['custom_name'] ?? ($item['name'] ?? null);

                OrderItem::create([
                    'order_id' => $order->id,
                    'user_id' => $patientId,
                    'product_id' => $productId,
                    'custom_product_name' => $customName,
                    'is_custom_product' => $isCustom ? 1 : 0,
                    'batch_number' => $item['batch_no'] ?? null,
                    'expiry_date' => !empty($item['expiry_date']) ? date('Y-m-d', strtotime($item['expiry_date'])) : null,
                    'product_gst_details' => $item['product_gst_details'] ?? null,
                    'product_gst_total' => $item['product_gst_total'] ?? 0,
                    'product_discount' => $item['discount_percent'] ?? 0,
                    'product_discount_price' => $item['discount_price'] ?? 0,
                    'category_id' => $item['category_id'] ?? null,
                    'quantity' => $qty,
                    'price' => $price,
                    'mrp' => $mrp,
                    'total_amount' => $total,
                    'branch_id' => $branchId,
                    'created_by' => $userId,
                    'sale_type' => $item['sale_type'] ?? 'local',
                    'isDeleted' => 0,
                ]);

                // Decrement inventory stock
                if ($productId) {
                    $med = Medicine::find($productId);
                    if ($med) {
                        $newStock = max(0, ((int) $med->quantity) - $qty);
                        $med->quantity = $newStock;
                        $med->availablility = $newStock > 0 ? 'in_stock' : 'out_stock';
                        $med->stock_value = $newStock * ((float) ($med->purchase_price ?: $med->mrp ?: $med->unit ?: 0));
                        $med->save();
                    }
                }
            }

            // 6. Record Payment
            if ($paidAmount > 0) {
                PaymentStore::create([
                    'user_id' => $patientId,
                    'order_id' => $order->id,
                    'payment_amount' => $paidAmount,
                    'payment_date' => now()->toDateString(),
                    'payment_type' => 'order',
                    'payment_method' => $paymentMethod,
                    'cash_amount' => in_array($paymentMethod, ['cash', 'cash_online']) ? $paidAmount : 0,
                    'upi_amount' => in_array($paymentMethod, ['upi', 'cash_online']) ? $paidAmount : 0,
                    'remaining_amount' => (string) $remainingAmount,
                    'remarks' => $request->remarks,
                    'isDeleted' => 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Sale created successfully!',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'invoice_url' => url('sales-invoice/' . $order->id),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error saving sale: ' . $e->getMessage()
            ], 500);
        }
    }

    public function get_orders(Request $request)
    {
        $branchId = session('selectedBranchId') ?? Auth::user()->branch_id ?? 1;

        $orders = Order::with(['order_items.product', 'patients'])
            ->where('isDeleted', 0)
            ->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->orWhereNull('branch_id');
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

    public function getsalseById($id)
    {
        $order = Order::with(['order_items.product', 'patients', 'payments'])->find($id);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json([
            'status' => true,
            'order' => $order
        ]);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::with('order_items')->findOrFail($id);

            // Restore Stock
            foreach ($order->order_items as $item) {
                if ($item->product_id) {
                    $med = Medicine::find($item->product_id);
                    if ($med) {
                        $med->quantity = ((int) $med->quantity) + ((int) $item->quantity);
                        $med->availablility = 'in_stock';
                        $med->stock_value = $med->quantity * ((float) ($med->purchase_price ?: $med->mrp ?: $med->unit ?: 0));
                        $med->save();
                    }
                }
            }

            $order->isDeleted = 1;
            $order->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Sale invoice deleted and inventory stock restored.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error deleting sale: ' . $e->getMessage()
            ], 500);
        }
    }

    public function makePaymentSubmit(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);
        $amount = (float) $request->amount;

        $newRemaining = max(0, ((float) $order->remaining_amount) - $amount);
        $order->remaining_amount = $newRemaining;
        $order->payment_status = $newRemaining <= 0 ? 'paid' : 'partial';
        $order->save();

        PaymentStore::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'payment_amount' => $amount,
            'payment_date' => now()->toDateString(),
            'payment_type' => 'order',
            'payment_method' => $request->payment_method,
            'cash_amount' => $request->payment_method === 'cash' ? $amount : 0,
            'upi_amount' => $request->payment_method === 'upi' ? $amount : 0,
            'remaining_amount' => (string) $newRemaining,
            'remarks' => $request->remarks,
            'isDeleted' => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Payment recorded successfully!',
            'remaining_amount' => $newRemaining,
            'payment_status' => $order->payment_status,
        ]);
    }
}

