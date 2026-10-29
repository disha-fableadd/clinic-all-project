@extends('layout.app')

@section('title', 'Sale Bill #' . ($order->order_number ?? $order->id))

@section('content')
<div class="page-wrapper" style="padding: 25px 30px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1" style="font-weight: 700; color: #1e293b;">Sale Bill #{{ $order->order_number ?? $order->id }}</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">View or print sale bill</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('sales.list') }}" class="btn btn-outline-secondary" style="border-radius: 50px; font-weight: 600;">
                <i class="fa fa-arrow-left me-1"></i> Back to Bills
            </a>
            <a href="{{ route('sales.invoice', $order->id) }}" class="btn" style="background: #f89884; color: #fff; border-radius: 50px; font-weight: 600;">
                <i class="fa fa-print me-1"></i> Print Invoice
            </a>
        </div>
    </div>

    <div class="alert alert-info" style="border-radius: 16px; background-color: #cfece0; border-color: #b8e2d1; color: #1f513f;">
        <i class="fa fa-info-circle me-2"></i> To ensure clinical billing audit compliance, completed sales can be viewed in detail or reprinted. You can view the full bill details here: <a href="{{ route('sales.details', $order->id) }}" class="fw-bold text-dark">View Sale Details</a>.
    </div>
</div>
@endsection

