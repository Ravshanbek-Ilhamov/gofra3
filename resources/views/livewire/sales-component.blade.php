<div>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
    
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
    
                    </div>
                </div>
                <div class="row">
                    <!-- Xatolik xabari -->

                    <!-- Mijoz tanlash -->
                    <div>
                        <div class="col-md-5">
                            <label>Select Customer</label>
                            <select id="customer-select" class="form-control" wire:model="selected_customer">
                                <option value="">-- Select or Enter Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary mt-2" wire:click="toggleNewCustomerInput">
                                {{ $showNewCustomerInput ? 'Close' : '+New customer' }}
                            </button>
                            @if($showNewCustomerInput)
                                <div class="mt-2">
                                    <input type="text" class="form-control" wire:model="new_customer_name" placeholder="Enter customer name">
                                </div>
                            @endif
                        </div>
                    
                    
                    </div>
                    

                    <!-- Mahsulot qo‘shish qismi -->
                    <div class="col-md-12 mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $index => $sale)
                                <tr>
                                    <td>
                                        <select class="form-control select2" wire:model="sales.{{ $index }}.product_id" wire:change="updatePrice({{ $index }})">
                                            <option value="">-- Select Product --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model="sales.{{ $index }}.quantity" min="1" wire:input="validateQuantity({{ $index }})">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="sales.{{ $index }}.price" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="sales.{{ $index }}.total" readonly>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" wire:click="removeSaleRow({{ $index }})">X</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button class="btn btn-primary" wire:click="addSaleRow">+ Add Product</button>
                        <button class="btn btn-success" wire:click="saveSale">Save Sale</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


