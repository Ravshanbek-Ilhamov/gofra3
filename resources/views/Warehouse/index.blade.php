@extends('Layout.main')
@section('title','groups')
@section('contents')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 m-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('warehouse.create') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Warehouse Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Input warehouse name" value="{{ old('name') }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label">Select User</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="" selected disabled>Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                            </form>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Warehoues</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Materials</th>
                                    <th class="text-center">Products</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $index => $warehouse)
                                    <tr>
                                        <td class="text-center">{{ ($warehouses->currentPage() - 1) * $warehouses->perPage() + $loop->iteration }}</td>
                                        <td class="text-center">{{ $warehouse->name }}</td>
                                        
                                        <td class="text-center">
                                            <form action="{{ route('warehouse.activity', $warehouse->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                        
                                                <button type="submit" class="btn {{ $warehouse->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $warehouse->status == 1 ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('warehouse.materials',$warehouse->id)}}" class="btn btn-warning">
                                                <i class="fas fa-box-open"></i> 
                                            </a>
                                            
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('warehouse.products',$warehouse->id)}}" class="btn btn-warning">
                                                <i class="fas fa-warehouse"></i> 
                                            </a>
                                        </td>
                                        
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$warehouse->id}}">
                                                Update
                                            </button>
                                
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{$warehouse->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$warehouse->id}}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$warehouse->id}}">Modal title</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('warehouse.update',$warehouse->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="userName" class="form-label">Warehouse Name</label>
                                                                    <input type="text" class="form-control" id="userName" name="name" placeholder="Input warehouse name" value="{{$warehouse->name}}">
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="user_id" class="form-label">Select User</label>
                                                                    <select name="user_id" id="user_id" class="form-control">
                                                                        <option value="" disabled>Select User</option>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}" {{ old('user_id', $warehouse->user_id) == $user->id ? 'selected' : '' }}>
                                                                                {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                </div>
                                                            </form>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form method="POST" action="{{route('warehouse.delete',$warehouse->id)}}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $warehouses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
