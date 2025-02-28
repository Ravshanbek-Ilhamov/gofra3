<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Support\Str;

class ProductComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $image;
    public $price;
    public $materials = [];
    public $allMaterials = [];
    public $showModal = false;
    public $products;
    public $editName, $editImage;
    public $editPrice;
    public $productId;
    public $showIngredientsModal = false;
    public $showeditModal = false;
    public $currentImage;
    public $editMaterials = [];
    public $detailproduct=null;
    public function mount()
    {
        
        $this->allMaterials = Material::all();
        $this->materials = [['material' => '', 'quantity' => 1]];
    }
    public function showIngredient($id)
    {
        // dd($id);
        $this->detailproduct=Product::findOrFail($id);
        $this->showIngredientsModal = true; 
    }
    public function addMaterial()
    {
        $this->materials[] = ['material' => '', 'quantity' => 1];
        $this->editMaterials[] = ['material' => '', 'quantity' => 1];
    }

    public function removeMaterial($index)
    {
        unset($this->materials[$index]);
        $this->materials = array_values($this->materials);
        unset($this->editMaterials[$index]);
        $this->editMaterials = array_values($this->editMaterials);
    }

    public function saveProduct()
    {
        $this->showModal = false;

        $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0', 
            'materials.*.material' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|numeric|min:1',
        ]);

        $imagePath = null;

        if ($this->image) {
            $extension = $this->image->getClientOriginalExtension();
            $filename = now()->format("Y-m-d") . '_' . time() . '.' . $extension;
            $imagePath = $this->image->storeAs('img_uploaded', $filename, 'public');
        }
        $slug=Str::slug($this->name);
        $product = Product::create([
            'name' => $this->name,
            'img' => $imagePath,
            'price' => $this->price,
            'slug' => $slug,
        ]);

        foreach ($this->materials as $material) {
            $materialModel = Material::find($material['material']);
            $invoiceMaterial = $materialModel->invoiceMaterials->first();

            if ($invoiceMaterial) {
                $unit = $invoiceMaterial->unit;
            } else {
                $unit = 'No Unit';
            }

            ProductIngredient::create([
                'product_id' => $product->id,
                'material_id' => $material['material'],
                'value' => $material['quantity'],
                'unit' => $unit,
            ]);
        }

        $this->reset(['name', 'image', 'materials']);
        $this->materials = [['material' => '', 'quantity' => 1]];

        session()->flash('success', 'Product successfully created!');
    }
    // app/Http/Livewire/ProductComponent.php

    public function editProduct($productId)
    {
        // Modal oynasini ko'rsatish
        $this->productId = $productId;
        $product = Product::findOrFail($productId);
        $this->showeditModal = true;

        // Mahsulot nomi va rasmi
        $this->editName = $product->name;
        $this->editImage = $product->img;
        $this->editPrice = $product->price;

        // Materiallar (ingredients) tahrirlash uchun
        $this->editMaterials = $product->ingredients->map(function ($ingredient) {
            return [
                'material' => $ingredient->material->id,
                'quantity' => $ingredient->value,
                'unit' => $ingredient->material->unit,
            ];
        })->toArray();
    }
    public function updateProduct(Product $product)
    {
        $product = Product::findOrFail($this->productId);
        $this->showeditModal = false;

        $this->validate([
            'editName' => 'required|string|max:255',
            'image' => 'nullable|max:2048',
            'editPrice' => 'required|numeric|min:0', 
            'editMaterials.*.material' => 'required|exists:materials,id',
            'editMaterials.*.quantity' => 'required|numeric|min:1',
        ]);

        $imagePath = null;
        if ($this->image) {
            $extension = $this->image->getClientOriginalExtension();
            $filename = now()->format("Y-m-d") . '_' . time() . '.' . $extension;
            $imagePath = $this->image->storeAs('img_uploaded', $filename, 'public');
        }

        $product->name = $this->editName;
        $product->slug=Str::slug($this->editName);
        if ($imagePath) {
            $product->img = $imagePath;
        }
        $product->price=$this->editPrice;
        $product->save();

        ProductIngredient::where('product_id', $product->id)->delete();

        foreach ($this->editMaterials as $material) {
            $materialModel = Material::find($material['material']);
            $invoiceMaterial = $materialModel->invoiceMaterials->first();

            $unit = $invoiceMaterial ? $invoiceMaterial->unit : 'No Unit';

            ProductIngredient::create([
                'product_id' => $product->id,
                'material_id' => $material['material'],
                'value' => $material['quantity'],
                'unit' => $unit,
            ]);
        }

        $this->reset(['editName', 'editImage', 'editMaterials']);
        $this->editMaterials = [['material' => '', 'quantity' => 1]];

        session()->flash('success', 'Product successfully updated!');
    }


    public function render()
    {
        $this->products = Product::all();
        return view('livewire.product-component');
    }
}
