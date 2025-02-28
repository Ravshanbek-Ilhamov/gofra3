@extends('Layout.main')
@section('title', 'Employeecreate')
@section('contents')
    <div class="container-flued mt-3">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Employee</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('employee.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- User -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">Select User</label>
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value="" selected disabled>Tanlang</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                

                                <!-- Department -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value="" selected disabled>Tanlang</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                </div>

                                <!-- Work Schedule -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="work_schedule">Work Schedule</label>
                                        <select name="work_schedule" id="work_schedule" class="form-control">
                                            <option value="" selected disabled>-- Select Work Schedule --</option>
                                            <option value="full_time">Full Time</option>
                                            <option value="part_time">Part Time</option>
                                            <option value="shift">Shift</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <!-- Salary Type -->
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_type">Salary Type</label>
                                        <select name="salary_type" id="salary_type" class="form-control">
                                            <option value="" selected disabled>-- Select Salary Type --</option>
                                            <option value="fixed">Fixed</option>
                                            <option value="hourly">Hourly</option>
                                            <option value="per_task">Per Task</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_type">Salary Type</label>
                                        <select name="salary_type" id="salary_type" class="form-control">
                                            <option value="" selected disabled>-- Select Salary Type --</option>
                                            @foreach ($salarytype as $value)
                                                <option value="{{ $value->name }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                

                                <!-- Salary -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input type="number" step="0.01" name="salary" id="salary"
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- Rate -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate">Hourly Rate</label>
                                        <input type="number" step="0.01" name="rate" id="rate"
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- Task Rate -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="task_rate">Task Rate</label>
                                        <input type="number" step="0.01" name="task_rate" id="task_rate"
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- Advance -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="advance">Advance</label>
                                        <input type="number" step="0.01" name="advance" id="advance"
                                            class="form-control" value="0">
                                    </div>
                                </div>

                                <!-- Fine -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fine">Fine</label>
                                        <input type="number" step="0.01" name="fine" id="fine"
                                            class="form-control" value="0">
                                    </div>
                                </div>

                                <!-- Bonus -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bonus">Bonus</label>
                                        <input type="number" step="0.01" name="bonus" id="bonus"
                                            class="form-control" value="0">
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="img">Profile Image</label>
                                        <input type="file" name="img" id="img" class="form-control-file">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Employee</button>
                                <a href="{{ route('employee.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
