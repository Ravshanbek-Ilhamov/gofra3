<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\WarehouseValue;
use Livewire\Component;

class SalesComponent extends Component
{
    public $customers, $products;
    public $selected_customer;
    public $sales = [];
    public $errorMessage = '';
    public $showNewCustomerInput = false;
    public $new_customer_name;
    protected $rules = [
        'selected_customer' => 'required_without:new_customer_name',
        'new_customer_name' => 'required_without:selected_customer',
        'sales.*.product_id' => 'required|exists:products,id',
        'sales.*.quantity' => 'required|integer|min:1',
    ];

    protected $listeners = ['customerSelected', 'updatePrice'];

    public function mount()
    {
        $this->customers = Customer::all();
        $this->products = Product::all();
        $this->addSaleRow();
    }
    public function toggleNewCustomerInput()
    {
        $this->showNewCustomerInput = !$this->showNewCustomerInput;
    }

    
    public function productSelected($index, $productId)
    {
        $this->sales[$index]['product_id'] = $productId;
    }
    public function customerSelected($customerNameOrId)
    {
        if (!is_numeric($customerNameOrId)) {
            $customer = Customer::create(['name' => $customerNameOrId]);
            $this->customers = Customer::all();
            $this->selected_customer = $customer->id;
        } else {
            $this->selected_customer = $customerNameOrId;
        }
    }

    public function addSaleRow()
    {
        $this->sales[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'total' => 0];
        
    }

    public function removeSaleRow($index)
    {
        unset($this->sales[$index]);
        $this->sales = array_values($this->sales);
    }

    public function updatePrice($index)
    {
        if (isset($this->sales[$index]['product_id']) && $this->sales[$index]['product_id']) {
            $product = Product::find($this->sales[$index]['product_id']);
            if ($product) {
                $this->sales[$index]['price'] = $product->price;
                $this->calculateTotal($index);
            }
        }
    }

    public function validateQuantity($index)
    {
        $quantity = (int) ($this->sales[$index]['quantity'] ?? 0);
        if ($quantity < 1) {
            return;
            $this->sales[$index]['quantity'] = 1;
            $this->errorMessage = 'Quantity must be at least 1.';
        } else {
            $this->errorMessage = '';
        }
        $this->calculateTotal($index);
    }

    public function calculateTotal($index)
    {
        $quantity = (int) ($this->sales[$index]['quantity'] ?? 1);
        $price = (float) ($this->sales[$index]['price'] ?? 0);
        $this->sales[$index]['total'] = $quantity * $price;
    }

    public function saveSale()
    {
       $this->validate();
        $total_price = array_sum(array_column($this->sales, 'total'));
    
        if ($this->new_customer_name) {
            $newcustomer = Customer::create([
                'name' => $this->new_customer_name
            ]);
            $customer_id = $newcustomer->id;
        } else {
            $customer_id = $this->selected_customer;
        }
    
        foreach ($this->sales as $saleItem) {
            $warehouseStock = WarehouseValue::where('product_id', $saleItem['product_id'])->sum('value');
    
            if ($saleItem['quantity'] > $warehouseStock) {
                $this->errorMessage = 'Not enough stock for product ID: ' . $saleItem['product_id'];
                return;
            }
        }
    
        $sale = Sale::create([
            'customer_id' => $customer_id,
            'total_price' => $total_price,
        ]);
    
        foreach ($this->sales as $saleItem) {
            if ($saleItem['product_id']) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $saleItem['product_id'],
                    'quantity' => $saleItem['quantity'],
                    'price' => $saleItem['price'],
                    'total' => $saleItem['total'],
                ]);
    
                $warehouseValue = WarehouseValue::where('product_id', $saleItem['product_id'])->first();
                if ($warehouseValue) {
                    $warehouseValue->value -= $saleItem['quantity'];
                    $warehouseValue->save();
                }
            }
        }
    
        $this->errorMessage = 'Sale successfully saved!';
        $this->reset(['selected_customer', 'sales']);
        $this->addSaleRow();
    }
    

    public function render()
    {
        return view('livewire.sales-component');
    }
}
