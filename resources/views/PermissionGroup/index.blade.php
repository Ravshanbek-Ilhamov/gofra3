@extends('Layout.main')
@section('title','groups')
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
                        <h3 class="card-title">Groups</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissionGroups as $index => $group)
                                    <tr>
                                        <td class="text-center">{{ ($permissionGroups->currentPage() - 1) * $permissionGroups->perPage() + $loop->iteration }}</td>
                                        <td class="text-center">{{ $group->name }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('group.update', $group->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                        
                                                <button type="submit" class="btn {{ $group->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $group->status == 1 ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $permissionGroups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
