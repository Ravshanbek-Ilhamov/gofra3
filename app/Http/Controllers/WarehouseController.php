<?php

namespace App\Http\Controllers;

use App\Http\Requests\Warehouse\ExportMaterialRequest;
use App\Http\Requests\Warehouse\ExportProductRequest;
use App\Http\Requests\Warehouse\WarehouseCreateRequest;
use App\Http\Requests\Warehouse\WarehouseUpdateRequest;
use App\Models\History;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseValue;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $users=User::all();
        $warehouses=Warehouse::orderBy('id','desc')->paginate(10);
        return view('Warehouse.index',['warehouses'=>$warehouses,'users'=>$users]);
    }
    public function create(WarehouseCreateRequest $request)
    {
        // dd(123);
        $warehouse=new Warehouse();
        $warehouse->name=$request->name;
        $warehouse->user_id=$request->user_id;
        $warehouse->save();
        return redirect()->back()->with('success','Warehouses created successfully');
    }
    public function delete(Warehouse $warehouse)
    {
        // dd($warehouse->name);
        $warehouse->delete();
        return redirect()->back()->with('success','Warehouse deleted successfully');
    }
    public function update(WarehouseUpdateRequest $request,Warehouse $warehouse)
    {
       // dd($warehouse->name);
       $warehouse->name=$request->name;
       $warehouse->save();
       return redirect()->back()->with('success','Warehouse updated successfully');
        
    }
    public function activity(Warehouse $warehouse)
    {
        // dd($warehouse->name);
        if($warehouse->status)
        {
            $warehouse->status=0;
        }
        else
        {
            $warehouse->status=1;
        }
        $warehouse->save();
        return redirect()->back()->with('success','Warehouse status updated successfully');
    }
    public function materialpage(Warehouse $warehouse)
    {
        $WarehouseValue=WarehouseValue::where('warehouse_id',$warehouse->id)->where('type',1)->get();
        $warehouses=Warehouse::where('id','!=',$warehouse->id)->get();
        return view('Warehouse.warehouse_materials',['WarehouseValue'=>$WarehouseValue,'warehouses'=>$warehouses,'id'=>$warehouse->id]);
    }
    public function export(ExportMaterialRequest $request,$warehouse_id)
    {

        $material_id = $request->input('material_id');
        $to_id = $request->input('to_id');
        $quantity = $request->input('quantity');
        $sourceWarehouse = WarehouseValue::where('warehouse_id', $warehouse_id)
            ->where('product_id', $material_id)
            ->first();
            if (!$sourceWarehouse || $sourceWarehouse->value < $quantity) {
                return redirect()->back()->with('success',"ishlamiyapti");
            }
            
            $sourceWarehouse->value -= $quantity;
            $sourceWarehouse->save();
            
        $targetWarehouse = WarehouseValue::where('warehouse_id', $to_id)
            ->where('product_id', $material_id)
            ->first();

        if ($targetWarehouse) {
            $targetWarehouse->value += $quantity;
            $targetWarehouse->save();
        } else {
            WarehouseValue::create([
                'warehouse_id' => $to_id,
                'product_id' => $material_id,
                'value' => $quantity,
            ]);
        }

        History::create([
            'type' => 2,
            'material_id' => $material_id,
            'quantity' => $quantity,
            'previous_value' => $sourceWarehouse->value + $quantity,
            'current_value' => $sourceWarehouse->value,
            'from_id' => $warehouse_id,
            'to_id' => $to_id
        ]);

        History::create([
            'type' => 2,
            'material_id' => $material_id,
            'quantity' => $quantity,
            'previous_value' => $targetWarehouse ? $targetWarehouse->value - $quantity : 0,
            'current_value' => $targetWarehouse ? $targetWarehouse->value : $quantity,
            'from_id' => $warehouse_id,
            'to_id' => $to_id
        ]);

        return redirect()->back()->with('success',"Materail exported successfully");
    }
    public function productpage(Warehouse $warehouse)
    {
        $WarehouseValue=WarehouseValue::where('warehouse_id',$warehouse->id)->where('type',2)->get();
        $warehouses=Warehouse::where('id','!=',$warehouse->id)->get();
        return view('Warehouse.warehouse_products',['WarehouseValue'=>$WarehouseValue,'warehouses'=>$warehouses,'id'=>$warehouse->id]);
    }
    public function productexport(ExportProductRequest $request,$warehouse_id)
    {
        $product_id = $request->input('product_id'); 
        $to_id = $request->input('to_id'); 
        $quantity = $request->input('quantity'); 
    
        $sourceWarehouse = WarehouseValue::where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->where('type','2')
            ->first();
    
        if (!$sourceWarehouse || $sourceWarehouse->value < $quantity) {
            return redirect()->back()->with('error', "Not enough product in the warehouse!");
        }
        // dd(123);
        $sourceWarehouse->value -= $quantity;
        $sourceWarehouse->save();
    
        $targetWarehouse = WarehouseValue::where('warehouse_id', $to_id)
            ->where('product_id', $product_id)
            ->where('type',2)
            ->first();
    
        if ($targetWarehouse) {
            $targetWarehouse->value += $quantity;
            $targetWarehouse->save();
        } else {
            WarehouseValue::create([
                'warehouse_id' => $to_id,
                'product_id' => $product_id,
                'value' => $quantity,
                'type'=>2
            ]);
        }
    
        History::create([
            'type' => 5, 
            'material_id' => $product_id,
            'quantity' => $quantity,
            'previous_value' => $sourceWarehouse->value + $quantity,
            'current_value' => $sourceWarehouse->value,
            'from_id' => $warehouse_id,
            'to_id' => $to_id
        ]);
    
        History::create([
            'type' => 5,
            'material_id' => $product_id,
            'quantity' => $quantity,
            'previous_value' => $targetWarehouse ? $targetWarehouse->value - $quantity : 0,
            'current_value' => $targetWarehouse ? $targetWarehouse->value : $quantity,
            'from_id' => $warehouse_id,
            'to_id' => $to_id
        ]);
    
        return redirect()->back()->with('success', "Product exported successfully");
    }
}
