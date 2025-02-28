<?php

namespace App\Livewire;

use App\Models\History;
use App\Models\MachineProduct;
use App\Models\Manufacturing;
use App\Models\WarehouseValue;
use Livewire\Component;

class ProductionComponent extends Component
{
    public $permission1 = false;
    public $permission2 = false;
    public $permission3 = false;
    public $machineproducts;
    public $manufactured;
    public $waste;
    public $showModal = false;
    public $dones;

    public function render()
    {
        $userId = auth()->user()->id;
        $this->machineproducts = MachineProduct::where('user_id', $userId)->where('status', '1')->get();
        $this->manufactured = MachineProduct::where('user_id', $userId)->where('status', '2')->get();
        $this->dones = MachineProduct::where('status', 3)
            ->where('user_id', $userId)
            ->get();
        // dd($machineproducts);

        return view('livewire.production-component');
    }
    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function givepermission($id)
    {
        if ($this->permission1 == $id) {
            $this->permission1 = false;
        } else {
            $this->permission1 = $id;
        }
    }
    public function acceptRequest($id)
    {
        $machineproduct = MachineProduct::findOrFail($id);
        if ($machineproduct) {
            $machineproduct->status = 2;
            $machineproduct->save();
        }
    }
    public function allowance($id)
    {
        if ($this->permission2 == $id) {
            $this->permission2 = false;
        } else {
            $this->permission2 = $id;
        }
    }
    public function givingpermit($id)
    {
        if ($this->permission3 == $id) {
            $this->permission3 = false;
        } else {
            $this->permission3 = $id;
        }
    }
    public function saveData($id)
    {
        $this->closeModal();
        $this->validate([
            'waste' => 'nullable|numeric|min:0'
        ]);

        $userId = auth()->user()->id;

        $currentMachine = MachineProduct::where('id', $id)
            ->where('user_id', $userId)
            ->where('status', 2)
            ->first();

        if (!$currentMachine) {
            return;
        }

        if ($this->waste > $currentMachine->total_count) {
            $this->addError('error', 'The waste count cannot be greater than the total count.');
            return;
        }

        $currentMachine->waste_count = $this->waste;
        $currentMachine->quality_count = $currentMachine->total_count - $this->waste;
        $currentMachine->status = 3;
        $currentMachine->save();

        $otherMachinesCompleted = !MachineProduct::where('manufacturing_id', $currentMachine->manufacturing_id)
            ->where('id', '!=', $currentMachine->id)
            ->where('status', '<', 3)
            ->exists();

        $nextMachine = MachineProduct::where('manufacturing_id', $currentMachine->manufacturing_id)
            ->where('status', '<', 3)
            ->first();

        if ($nextMachine) {
            $nextMachine->total_count = $currentMachine->quality_count;
            $nextMachine->status = 1;
            $nextMachine->save();
        } else {
            $produce = Manufacturing::where('id', $currentMachine->manufacturing_id)->first();
            $produce->quality_count = $currentMachine->total_count - $this->waste;
            $produce->waste_count = MachineProduct::where('manufacturing_id', $produce->id)->sum('waste_count');
            $produce->save();

            if ($otherMachinesCompleted) {
                $warehouseEntry = WarehouseValue::where('warehouse_id', 1)
                    ->where('product_id', $produce->product_id)
                    ->where('type',2)
                    ->first();

                if ($warehouseEntry) {
                    // Agar mahsulot omborda mavjud bo‘lsa, mavjud qiymatga qo‘shamiz
                    $warehouseEntry->value += $produce->quality_count;
                    $warehouseEntry->save();
                } else {
                    // Agar mahsulot omborda bo‘lmasa, yangi yozuv qo‘shamiz
                    WarehouseValue::create([
                        'warehouse_id' => 1,
                        'product_id' => $produce->product_id,
                        'value' => $produce->quality_count,
                        'type' => 2,
                    ]);
                }
                History::create([
                    'type' => 4,
                    'material_id' => $produce->product_id,
                    'quantity' => $produce->quality_count,
                    'previos_value' => 0,
                    'current_value' => $produce->quality_count,
                    'from_id' => $produce->id,
                    'to_id' => 1
                ]);
            }
        }

        $this->waste = 0;
    }
}
