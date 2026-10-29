@extends('layout.app')

@section('title', 'Edit Purchase Bill')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="page-title mb-1" style="font-weight: 700; color: #1e293b;">Edit Purchase Bill</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Modify bill details or view purchase summary</p>
            </div>
            <a href="{{ route('purchase.lists') }}" class="btn btn-outline-secondary" style="border-radius: 50px; font-weight: 600;">
                <i class="fa fa-arrow-left me-1"></i> Back to Bills
            </a>
        </div>

        <div class="alert alert-info" style="border-radius: 20px; background-color: #cfece0; border-color: #b8e2d1; color: #1f513f;">
            <i class="fa fa-info-circle me-2"></i> For inventory accuracy, if you need to adjust stock or supplier amounts, you can view the <a href="{{ route('purchase.invoice', $invoice->id) }}" class="fw-bold text-dark">Purchase Bill Invoice</a> or create an adjustment entry.
        </div>
    </div>
</div>
@endsection
