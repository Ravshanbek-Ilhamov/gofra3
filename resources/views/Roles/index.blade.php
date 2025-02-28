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
                <!-- Button trigger modal -->
                <a href="{{ route('role.create-page') }}" class="btn btn-primary">Create</a>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Roles</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Activity</th>
                                        <th class="text-center">Permissions</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $index => $role)
                                        <tr>
                                            <td class="text-center">{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</td>
                                            <td class="text-center">{{ $role->name }}</td>
                                            <td class="text-center">
                                                @if ($role->status)
                                                    <span
                                                        style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 1rem; color: white; background-color: #28a745;">Active</span>
                                                @else
                                                    <span
                                                        style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 1rem; color: white; background-color: #dc3545;">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center"><!-- Button trigger modal -->
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $role->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                        <path
                                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                    </svg>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $role->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel{{ $role->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalLabel{{ $role->id }}">Modal title
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @foreach ($permissionGroups as $group)
                                                                    <details class="permission-group"
                                                                        style="border: 1px solid #ddd; border-radius: 8px; margin: 8px 0; overflow: hidden; transition: all 0.3s ease-in-out;">
                                                                        <summary
                                                                            style="cursor: pointer; padding: 10px; font-size: 16px; font-weight: bold; background: #1045bf; color: solid #dddddd; list-style-type: none;">
                                                                            {{ $group->name }}
                                                                        </summary>
                                                                        <div class="permissions"
                                                                            style="padding: 10px; background: #f1f3f5;">
                                                                            @foreach ($group->permissions as $permission)
                                                                                <label
                                                                                    style="display: block; 
                                                                            @if ($role->permissions->contains($permission->id)) color: #007bff; @else color: #6c757d; @endif">
                                                                                    <input type="checkbox"
                                                                                        name="permissions[]"
                                                                                        value="{{ $permission->id }}"
                                                                                        @if ($role->permissions->contains($permission->id)) checked @endif
                                                                                        disabled>
                                                                                    {{ $permission->name }}
                                                                                </label>
                                                                            @endforeach
                                                                        </div>
                                                                    </details>
                                                                @endforeach
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <td class="text-center">
                                                <a href="{{ route('role.update-page', $role->id) }}"
                                                    class="btn btn-warning">Update</a>
                                                <!-- Delete Form -->
                                                <form method="POST" action="{{ route('role.delete', $role->id) }}"
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
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
