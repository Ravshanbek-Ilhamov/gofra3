@extends('Layout.main')

@section('title', 'Show Invoice')

@section('contents')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Invoice Details Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Invoice Details</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Invoice ID</th>
                            <td>{{ $invoice->id }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $invoice->text ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Company Name</th>
                            <td>{{$invoice->company_name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $invoice->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Materials Table -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Invoice Materials</h3>
                </div>
                <div class="card-body">
                    @if($invoice->invoiceMaterials->count() > 0)
                        <table class="table table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Price per Unit</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->invoiceMaterials as $key => $material)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $material->material->name }}</td>
                                        <td>{{ $material->quantity }}</td>
                                        <td>{{ $material->unit }}</td>
                                        <td>${{ number_format($material->price, 2) }}</td>
                                        <td>${{ number_format($material->quantity * $material->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No materials found for this invoice.</p>
                    @endif
                </div>
            </div>
            <div>
                <a href="{{route('invoice_materials.index')}}" class="btn btn-dark m-3">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                
            </div>
        </div>
    </div>
</div>
@endsection
