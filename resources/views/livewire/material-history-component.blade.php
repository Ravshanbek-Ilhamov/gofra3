<div>
    <div class="content-wrapper">
        <section class="content">
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="row">
                    <!-- 📌 1. Ombor Tanlash (col-5) -->
                    <div class="col-5">
                        <label for="warehouse" class="form-label fw-bold">
                            <i class="fas fa-warehouse text-primary"></i> Select Warehouse:
                        </label>
                        
                        <select wire:model="id" wire:change="updateStatistics" id="warehouse" class="form-control select2">
                            <option value="">🏢 Choose a warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">
                                    🏢 {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- 📌 2. Filter (ByMaterials yoki ByProducts) (col-5) -->
                    <div class="col-5">
                        <label for="filter" class="form-label fw-bold">
                            <i class="fas fa-filter text-warning"></i> Filter By:
                        </label>
                
                        <select wire:model="filter" wire:change="updateStatistics" id="filter" class="form-control select2">
                            <option value="1">📦 Materials</option>
                            <option value="2">🛒 Products</option>
                        </select>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">📊 Warehouse Values</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Warehouse</th>
                                    <th>Material Name</th>
                                    <th>Current Value</th>
                                    <th>Detail History</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehousevalues as $warehousevalue )
                                    
                                <tr>
                                    <td>{{ $warehousevalue->warehouse->name}}</td>
                                    <td>{{ $warehousevalue->material->name }}</td>
                                    <td>{{ $warehousevalue->value }}</td>
                                    <td>
                                        <a href="{{ route('history.detail', ['filter' => $filter, 'id' => $id,'material_id'=>$warehousevalue->product_id]) }}" class="btn btn-success">
                                            <i class="fas fa-history"></i> View History
                                        </a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

