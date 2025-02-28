@extends('Layout.main')
@section('title','Invoice_Materials')
@section('contents')
<div class="container">
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
    <div class="row justify-content-center">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-file-excel"></i> Import Excel File</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('invoice_materials.create')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="excel_file" class="form-label"><strong>Select Excel File</strong></label>
                            <input type="file" name="excel_file" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="company_name" class="form-label"><strong>Company Name</strong></label>
                            <input type="text" name="company_name" class="form-control" placeholder="Input company name">
                        </div>
                        <div class="form-group">
                            <label for="warehouse_id" class="form-label"><strong>Select Warehouse</strong></label>
                            <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                                <option value="" disabled selected>-- Select Warehouse --</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-upload"></i> Upload and Import
                        </button>
                        <a href="{{route('invoice_materials.index')}}" class="btn btn-dark mt-3">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection