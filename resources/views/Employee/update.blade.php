@extends('Layout.main')
@section('title', 'Employee Update')
@section('contents')
    <div class="container-fluid mt-3">
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
                        <h3 class="card-title">Update Employee</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employee.update', $employee->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- User -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">Select User</label>
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value="" disabled>Tanlang</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $user->id == $employee->user_id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Department -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value="" disabled>Tanlang</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $department->id == $employee->department_id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $employee->name ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}">
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
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ old('phone', $employee->phone) }}" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="{{ old('address', $employee->address) }}">
                                    </div>
                                </div>

                                <!-- Work Schedule -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="work_schedule">Work Schedule</label>
                                        <select name="work_schedule" id="work_schedule" class="form-control">
                                            <option value="" disabled>-- Select Work Schedule --</option>
                                            <option value="full_time"
                                                {{ $employee->work_schedule == 'full_time' ? 'selected' : '' }}>Full Time
                                            </option>
                                            <option value="part_time"
                                                {{ $employee->work_schedule == 'part_time' ? 'selected' : '' }}>Part Time
                                            </option>
                                            <option value="shift"
                                                {{ $employee->work_schedule == 'shift' ? 'selected' : '' }}>Shift</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Salary Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_type">Salary Type</label>
                                        <select name="salary_type" id="salary_type" class="form-control">
                                            <option value="" disabled {{ empty($employee->salary_type) ? 'selected' : '' }}>
                                                -- Select Salary Type --
                                            </option>
                                            @foreach ($salarytype as $value)
                                                <option value="{{ $value->name }}" {{ isset($employee) && $employee->salary_type == $value->name ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                
                                

                                <!-- Salary -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input type="number" step="0.01" name="salary" id="salary"
                                            class="form-control" value="{{ old('salary', $employee->salary) }}">
                                    </div>
                                </div>

                                <!-- Rate -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate">Hourly Rate</label>
                                        <input type="number" step="0.01" name="rate" id="rate"
                                            class="form-control" value="{{ old('rate', $employee->rate) }}">
                                    </div>
                                </div>

                                <!-- Task Rate -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="task_rate">Task Rate</label>
                                        <input type="number" step="0.01" name="task_rate" id="task_rate"
                                            class="form-control" value="{{ old('task_rate', $employee->task_rate) }}">
                                    </div>
                                </div>

                                <!-- Advance -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="advance">Advance</label>
                                        <input type="number" step="0.01" name="advance" id="advance"
                                            class="form-control" value="{{ old('advance', $employee->advance) }}">
                                    </div>
                                </div>

                                <!-- Fine -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fine">Fine</label>
                                        <input type="number" step="0.01" name="fine" id="fine"
                                            class="form-control" value="{{ old('fine', $employee->fine) }}">
                                    </div>
                                </div>

                                <!-- Bonus -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bonus">Bonus</label>
                                        <input type="number" step="0.01" name="bonus" id="bonus"
                                            class="form-control" value="{{ old('bonus', $employee->bonus) }}">
                                    </div>
                                </div>

                                <!-- Image -->
                                <!-- Image -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="img">Profile Image</label>
                                        @if ($employee->img)
                                            <div>
                                                <img src="{{ asset('storage/' . $employee->img) }}" alt="Profile Image"
                                                    width="100" height="100">
                                            </div>
                                        @endif
                                        <input type="file" name="img" id="img" class="form-control-file">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the
                                            image.</small>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Employee</button>
                                <a href="{{ route('employee.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
