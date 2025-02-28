<?php

namespace App\Livewire;

use App\Models\History;
use Illuminate\Http\Request;
use Livewire\Component;

class DetailWarehouseValuesHistoryComponent extends Component
{
    public $id; 
    public $filter;
    public $product_id;
    public $history = [];
    public function mount(Request $request)
    {
        $this->id = $request->query('id');
        $this->product_id = $request->query('material_id');
        $this->filter = $request->query('filter', 'ByMaterials');
        // dd($this->product_id);
    }
    public function render()
    {
        if ($this->filter == 1) {
            $this->history = History::where('material_id', $this->product_id)
                ->whereIn('type', [1, 2,3])
                ->get();
        } elseif ($this->filter == 2) {
            $this->history = History::where('material_id', $this->product_id)
                ->whereIn('type', [3, 4,5])
                ->get();
        } else {
            $this->history = []; // Agar noto‘g‘ri filter bo‘lsa, bo‘sh array qaytarish
        }

        return view('livewire.detail-warehouse-values-history-component');
    }
}
