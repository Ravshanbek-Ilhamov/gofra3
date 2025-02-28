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
                            <form method="POST" action="{{ route('user.create') }}">
                                @csrf
                            
                                <!-- Role tanlash (Select2) -->
                                <div class="mb-3">
                                    <label>Role ni tanlang</label>
                                    <select class="form-control" data-placeholder="roleni tanlang" style="" name="role_id">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- User name -->
                                <div class="mb-3">
                                    <label for="userName" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="userName" name="name" placeholder="Input username" value="{{ old('name') }}">
                                </div>
                            
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="userEmail" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                </div>
                            
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="userPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="userPassword" name="password" placeholder="Enter password">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Roles</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>

                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">
                                            @foreach ($user->roles as $role)
                                                {{ $role->name }}@if (!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        
                                        {{-- <td>{{ $permission->group->name }}</td> --}}
                                        <td class="text-center">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal{{$user->id}}">
                                                    Update
                                                </button>
                                    
                                                <!-- Modal -->
                                                <div class="modal fade" id="updateModal{{$user->id}}" tabindex="-1" aria-labelledby="updateModalLabel{{$user->id}}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="updateModalLabel">Modal title</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{route('user.update',$user->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <!-- Role tanlash (Select2) -->
                                                                    <div class="mb-3">
                                                                        <label for="role_id" class="form-label">Role tanlang</label>
                                                                        <select class="form-control" name="role_id" id="role_id">
                                                                            @foreach($roles as $role)
                                                                                <option value="{{ $role->id }}" 
                                                                                        @if($user->role && $user->role->id == $role->id) selected @endif>
                                                                                    {{ $role->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    <!-- User name -->
                                                                    <div class="mb-3">
                                                                        <label for="userName" class="form-label">User Name</label>
                                                                        <input type="text" class="form-control" id="userName" name="name" placeholder="Input username" value="{{$user->name}}">
                                                                    </div>
                                                                
                                                                    <!-- Email -->
                                                                    <div class="mb-3">
                                                                        <label for="userEmail" class="form-label">Email</label>
                                                                        <input type="email" class="form-control" id="userEmail" name="email" placeholder="Enter email" value="{{$user->email}}">
                                                                    </div>
                                                                
                                                                    <!-- Password -->
                                                                    <div class="mb-3">
                                                                        <label for="userPassword" class="form-label">Password</label>
                                                                        <input type="password" class="form-control" id="userPassword" name="password" placeholder="Enter password">
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
                                            <!-- Delete Form -->
                                            <form method="POST" action="{{route('user.delete',$user->id)}}"
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
@endsection
