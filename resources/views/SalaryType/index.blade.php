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
                            <form method="POST" action="{{ route('salarytype.create') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="userName" class="form-label">SalaryType Name</label>
                                    <input type="text" class="form-control" id="userName" name="name" placeholder="Input salarytype name" value="{{ old('name') }}">
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
                        <h3 class="card-title">SalaryTypes</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salarytypes as $index => $salarytype)
                                    <tr>
                                        <td class="text-center">{{ ($salarytypes->currentPage() - 1) * $salarytypes->perPage() + $loop->iteration }}</td>
                                        <td class="text-center">{{ $salarytype->name }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$salarytype->id}}">
                                                Update
                                            </button>
                                
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{$salarytype->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$salarytype->id}}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$salarytype->id}}">Modal title</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('salarytype.update',$salarytype->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="userName" class="form-label">SalaryType Name</label>
                                                                    <input type="text" class="form-control" id="userName" name="name" placeholder="Input salarytype name" value="{{$salarytype->name}}">
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
                                            <form method="POST" action="{{route('salarytype.delete',$salarytype->id)}}"
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
                        {{ $salarytypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
