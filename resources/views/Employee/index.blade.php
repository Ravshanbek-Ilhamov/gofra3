@extends('Layout.main')
@section('title','Employees')
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
                <a href="{{ route('employee.create-page') }}" class="btn btn-primary">Create</a>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Employees</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Tel</th>
                                        <th class="text-center">Adress</th>
                                        <th class="text-center">Department</th>
                                        <th class="text-center">Salary Type</th>
                                        <th class="text-center">Img</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $index => $employee)
                                        <tr>
                                            <td class="text-center">{{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}</td>

                                            <td class="text-center">{{ optional($employee->user)->name ?? $employee->name }}</td>

                                            <td class="text-center">{{ $employee->phone }}</td>
                                            <td class="text-center">{{ $employee->address }}</td>
                                            <td class="text-center">{{ $employee->department->name }}</td>
                                            <td class="text-center">{{ $employee->salary_type }}</td>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('storage/' . $employee->img) }}" alt="{{$employee->img}}"
                                                width="100px" height="100px">
                                            </td>
                                            <td class="text-center">
                                                
                                            <a href="{{route('employee.update-page',$employee->id)}}" class="btn btn-warning">Update</a>
                                            <form method="POST" action="{{ route('employee.delete', $employee->id) }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
