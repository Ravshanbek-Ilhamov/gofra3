@extends('Layout.main')
@section('title','Permissions')
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
        
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permissions</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Path</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $index => $permission)
                                    <tr>
                                        <td class="text-center">{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->iteration }}</td>

                                        <td class="text-center">{{ $permission->name }}</td>
                                        <td class="text-center">{{ $permission->path }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                        
                                                <button type="submit" class="btn {{ $permission->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $permission->status == 1 ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#permissionModal{{ $permission->id }}">
                                                Update
                                            </button>
                                        
                                            <!-- Modal -->
                                            <div class="modal fade" id="permissionModal{{ $permission->id }}" tabindex="-1" aria-labelledby="permissionModalLabel{{ $permission->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="permissionModalLabel{{ $permission->id }}">Edit Permission</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form -->
                                                            <form action="{{ route('permission.edit', $permission->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="permission-name-{{ $permission->id }}" class="form-label">Permission Name</label>
                                                                    <input type="text" class="form-control" id="permission-name-{{ $permission->id }}" name="name" value="{{ $permission->name }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
