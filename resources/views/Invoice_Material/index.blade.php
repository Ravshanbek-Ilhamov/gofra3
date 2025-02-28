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
    <div class="row">
        <div class="row m-3">
            <div class="col-12">
                <a href="{{ route('invoice_materials.create-page') }}" class="btn btn-primary">Create</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Invoices</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">date</th>
                                    <th class="text-center">text</th>
                                    <th class="text-center">invoiceMaterials</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $index => $invoice)
                                    <tr>
                                        <td class="text-center">{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}</td>
                                        <td class="text-center">{{ $invoice->company_name }}</td>
                                        <td class="text-center">{{ $invoice->created_at->format('d M Y') }}</td>
                                        <td class="text-center">{{ $invoice->text }}</td>
                                        <td class="text-center">
                                            <a href="{{route('invoice_materials.detail',$invoice->id)}}" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                              </svg></a>
                                            
                                        </td>
                                        
                                        
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection