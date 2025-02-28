<?php

namespace App\Livewire;

use App\Models\History;
use App\Models\Warehouse;
use App\Models\WarehouseValue;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MaterialHistoryComponent extends Component
{
    public $warehousevalues;
    public $id=1;
    public $name;
    public $warehouses;
    public $filter=1;
    public function render()
    {
        $this->warehouses=Warehouse::all();
        $this->name=Warehouse::findOrFail($this->id)->name;
        $this->warehousevalues=WarehouseValue::where('warehouse_id',$this->id)->where('type',$this->filter)->get();
        return view('livewire.material-history-component');
    }
    public function updateStatistics()
    {
        // dd($this->id);
        $this->warehousevalues=WarehouseValue::where('warehouse_id',$this->id)->where('type',$this->filter)->get();
        $this->name=Warehouse::findOrFail($this->id)->name;
    }
}
