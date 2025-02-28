<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\EmployeeCreateRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\SalaryType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->paginate(10);
        return view('Employee.index', ['employees' => $employees]);
    }
    public function page()
    {
        $departments = Department::all();
        $users = User::all();
        $salarytype=SalaryType::all();
        return view('Employee.create', ['departments' => $departments, 'users' => $users,'salarytype'=>$salarytype]);
    }
    public function create(EmployeeCreateRequest $request)
    {
        $path = null;
        if ($request->hasFile('img')) {
            $extension = $request->img->getClientOriginalExtension();
            $filename = now()->format("Y-m-d") . '_' . time() . '.' . $extension;
            $path = $request->img->storeAs('img_uploaded', $filename, 'public');
        }

        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);

        $dailyHours = $startTime->diffInHours($endTime);
        $monthlyHours = $dailyHours * 5 * 4;

        Employee::create([
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : null,
            'phone' => $request->phone,
            'address' => $request->address,
            'img' => $path,
            'work_schedule' => $request->work_schedule,
            'salary_type' => $request->salary_type,
            'salary' => $request->salary ?: null,
            'hourly_rate' => $request->hourly_rate ?: null,
            'task_rate' => $request->task_rate ?: null,
            'advance' => $request->advance ?: 0,
            'fine' => $request->fine ?: 0,
            'bonus' => $request->bonus ?: 0,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'daily_hours' => $dailyHours,
            'monthly_hours' => $monthlyHours,
        ]);
        return redirect()->route('employee.index')->with('success','Employee created successfully');
    }

    public function updatepage(Employee $employee)
    {
        // dd($employee->id);
        $departments = Department::all();
        $users = User::all();
        $salarytype=SalaryType::all();
        return view('Employee.update', ['employee' => $employee, 'users' => $users, 'departments' => $departments,'salarytype'=>$salarytype]);
    }
    public function delete(Employee $employee)
    {
        // dd($employee->img);
        $employee->delete();
        Storage::disk('public')->delete($employee->img);
        return redirect()->back()->with('success', 'Employee deleted successfully');
    }
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        // dd($request->salary_type);
        $path = $employee->img;

        if ($request->hasFile('img')) {
            if ($employee->img) {
                Storage::disk('public')->delete($employee->img);
            }

            $extension = $request->img->getClientOriginalExtension();
            $filename = date("Y-m-d") . '_' . time() . '.' . $extension;
            $path = $request->img->storeAs('img_uploaded', $filename, 'public');
        }

        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);

        $dailyHours = $startTime->diffInHours($endTime);

        $monthlyHours = $dailyHours * 5 * 4;

        $employee->update([
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : null,
            'phone' => $request->phone,
            'address' => $request->address,
            'img' => $path,
            'work_schedule' => $request->work_schedule,
            'salary_type' => $request->salary_type,
            'salary' => $request->salary ?: null,
            'hourly_rate' => $request->hourly_rate ?: null,
            'task_rate' => $request->task_rate ?: null,
            'advance' => $request->advance ?: 0,
            'fine' => $request->fine ?: 0,
            'bonus' => $request->bonus ?: 0,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'daily_hours' => $dailyHours,
            'monthly_hours' => $monthlyHours,
        ]);

        return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
    }
}
