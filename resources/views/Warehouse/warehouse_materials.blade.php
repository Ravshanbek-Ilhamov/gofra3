@extends('Layout.main')

@section('title', 'Warehouse Materials')

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-warehouse"></i>- Materials</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Material Name</th>
                                        <th>Available Quantity</th>
                                        <th>Unit</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($WarehouseValue as $item)
                                        <tr>
                                            <td>{{ $item->material ? $item->material->name : 'No Material' }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ number_format($item->value) }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ optional($item->material?->invoiceMaterials->first())->unit ?? 'No Unit' }}
                                            </td>
                                            
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal for selecting warehouse and quantity -->
                                        <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="modalLabel-{{ $item->id }}">
                                                            Export Material</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('warehouse.transfer', $id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="material_id" value="{{ $item->material->id }}">
                                                        
                                                            <div class="mb-3">
                                                                <label for="warehouse-{{ $item->id }}" class="form-label">Select Warehouse</label>
                                                                <select class="form-select" name="to_id" id="warehouse-{{ $item->id }}">
                                                                    <option value="" selected disabled>Select Warehouse</option>
                                                                    @foreach ($warehouses as $warehouse)
                                                                        <option value="{{ $warehouse->id }}">
                                                                            {{ $warehouse->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        
                                                            <div class="mb-3">
                                                                <label for="quantity-{{ $item->id }}" class="form-label">Quantity</label>
                                                                <input type="number" name="quantity" id="quantity-{{ $item->id }}" class="form-control qty-input" min="1"
                                                                    max="{{ $item->value }}" placeholder="Enter quantity">
                                                            </div>
                                                        
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-share"></i> transfer
                                                                </button>
                                                            </div>
                                                        </form>
                                                        
                                                </div>
                                            </div>
                                        </div>
                        </div>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{route('warehouse.index')}}" class="btn btn-dark">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    
    </div>
@endsection
