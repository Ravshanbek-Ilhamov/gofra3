<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryType\SalaryTypeCreateRequest;
use App\Http\Requests\SalaryType\SalaryTypeUpdateRequest;
use App\Models\SalaryType;
use Illuminate\Http\Request;

class SalaryTypeController extends Controller
{
    public function index()
    {
        $salarytypes=SalaryType::orderBy('id','desc')->paginate(10);
        return view('SalaryType.index',['salarytypes'=>$salarytypes]);
    }
    public function create(SalaryTypeCreateRequest $request)
    {
        $salarytype=new SalaryType();
        $salarytype->name=$request->name;
        $salarytype->save();
        return redirect()->back()->with('success','Salarytype created successfully');
    }
    public function update(SalaryTypeUpdateRequest $request,SalaryType $salarytype)
    {
        // dd($salarytype->name);
        $salarytype->name=$request->name;
        $salarytype->save();
        return redirect()->back()->with('success','SalaryType updated successfully');
    }
    public function delete(SalaryType $salarytype)
    {
        //dd(123);
        $salarytype->delete();
        return redirect()->back()->with('success','SalaryType deleted successfully');
    }
}
