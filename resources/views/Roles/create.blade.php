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
                    <h4>Create role page</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('role.create')}}" method="POST">
                        @csrf
                        <!-- Role Name Input -->
                        <div class="mb-3">
                            <label for="role_name" class="form-label">Role Name</label>
                            <input type="text" name="name" id="role_name" class="form-control" placeholder="Input role name" >
                        </div>

                        <!-- Permission Groups va Permission'lar -->
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            @foreach ($permissionGroups as $group)
                            <!-- Group nomi alohida chiqadi -->
                            <div class="mb-2">
                                <strong class="d-block bg-info text-white p-2">{{ ucfirst($group->name) }}</strong>
                            </div>
                            

                            <!-- Guruhga tegishli permissionlar 4 ustundan joylashadi -->
                            <div class="row">
                                @foreach ($group->permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}">
                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection