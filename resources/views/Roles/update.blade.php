@extends('Layout.main')
@section('title','title')
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
        <div class="col-md-12 offset-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Role Page</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <div class="mb-3">
                            <label for="role_name" class="form-label">Role Name</label>
                            <input type="text" name="name" id="role_name" class="form-control" value="{{ $role->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_status" class="form-label">Role Status</label>
                            <div class="form-check form-switch">
                                <!-- Agar status active bo'lsa, checked qo'yiladi -->
                                <input class="form-check-input m-2" type="checkbox" name="status" id="role_status" 
                                       @if($role->status) checked @endif>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            @foreach ($permissionGroups as $group)
                                <div class="mb-2">
                                    <strong class="d-block bg-info text-white p-2">{{ ucfirst($group->name) }}</strong>
                                </div>

                                <div class="row">
                                    @foreach ($group->permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}" 
                                            @if($role->permissions->contains($permission->id)) checked @endif>
                                            <label class="form-check-label" for="permission{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection