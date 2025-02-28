<?php

namespace App\Http\Controllers;

use App\Http\Requests\Machine\MachineCreateRequest;
use App\Http\Requests\Machine\MachineUpdateRequest;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machines=Machine::orderBy('id','desc')->paginate(10);
        return view('Machine.index',['machines'=>$machines]);
    }
    public function create(MachineCreateRequest $request)
    {
        // dd($request->all());
        $machine=new Machine();
        $machine->name=$request->name;
        $machine->save();
        return redirect()->back()->with('success',"Machine created successfully");
    }
    public function statusupdate(Machine $machine)
    {
        // dd($machine->name);
        if($machine->status)
        {
            $machine->status=0;
        }
        else{
            $machine->status=1;
        }
        $machine->save();
        return redirect()->back()->with('success','Machine status update successfully');
    }
    public function update(MachineUpdateRequest $request,Machine $machine)
    {
        // dd($machine->name);
        $machine->name=$request->name;
        $machine->save();
        return redirect()->back()->with('success','Machine updated successfully');
    }
}
