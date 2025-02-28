@extends('Layout.main')
@section('title')
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
            <div class="col-12 m-3">
                <a href="{{route('customer.createpage')}}" class="btn btn-primary">Create</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customers</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Balance</th>
                                        <th class="text-center">Adress</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $index => $customer)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                            </td>

                                            <td class="text-center">{{ $customer->name }}</td>
                                            <td class="text-center">{{ $customer->phone }}</td>
                                            <td class="text-center">{{ $customer->balance }}</td>
                                            <td class="text-center">{{ $addresses[$customer->id] ?? 'Manzil topilmadi' }}</td>
                                            <td class="text-center">
                                                <a href="{{route('customer.updatepage',$customer->id)}}" class="btn btn-warning">Update</a>
                                                <form method="POST" action="{{ route('customer.delete', $customer->id) }}"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form></td>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection
