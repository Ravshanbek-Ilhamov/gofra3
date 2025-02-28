<div class="content-wrapper kanban">
    <section class="content-header">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-sm-6">
                    <h1>Kanban Board</h1>
                </div>
                <div class="col-sm-6 d-none d-sm-block">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kanban Board</li>
                    </ol>
                </div>
            </div>
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
        </div>
    </section>

    <section class="content pb-3">
        <div class="container-fluid h-100">
            <div class="card card-row card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        Pending
                    </h3>
                </div>
                <div class="card-body">
                    <div class="card card-info card-outline">
                        @foreach ($machineproducts as $machineproduct)
                            <div class="card-header">
                                <h5 class="card-title">{{ $machineproduct->manufacturing->product->name }}</h5>
                                <div class="card-tools">
                                    <a wire:click="givepermission({{ $machineproduct->id }})" class="btn btn-tool">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                            @if ($permission1 == $machineproduct->id)
                                <div class="card-body">
                                    <div class="p-3 mb-2 bg-primary text-white rounded">
                                        <strong>Product Name:</strong> {{ $machineproduct->manufacturing->product->name }}
                                    </div>
                                    <div class="p-3 mb-2 bg-secondary text-white rounded">
                                        <strong>Total Count:</strong> {{ $machineproduct->manufacturing->total_count }}
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button class="btn btn-sm btn-success" wire:click="acceptRequest({{ $machineproduct->id }})">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    

                </div>
            </div>
            <div class="card card-row card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Manufactured
                    </h3>
                </div>
                <div class="card-body">
                    <div class="card card-primary card-outline">
                        @foreach ($manufactured as $manufacture)
                            <div class="card-header">
                                <h5 class="card-title">{{ $manufacture->manufacturing->product->name }}</h5>
                                <div class="card-tools">
                                    <a wire:click="allowance({{ $manufacture->id }})" class="btn btn-tool">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                            @if ($permission2 == $manufacture->id)
                                <div class="card-body">
                                    <div class="p-3 mb-2 bg-primary text-white rounded">
                                        <strong>Product Name:</strong> {{ $manufacture->manufacturing->product->name }}
                                    </div>
                                    <div class="p-3 mb-2 bg-secondary text-white rounded">
                                        <strong>Total Count:</strong> {{ $manufacture->manufacturing->total_count }}
                                    </div>
                    
                                    <!-- Tugatish Tugmasi -->
                                    <div class="d-flex justify-content-end mt-2">
                                        <button class="btn btn-sm btn-success" wire:click="openModal">
                                            <i class="fas fa-flag-checkered"></i> Tugatish
                                        </button>
                                    </div>
                    
                                    <!-- Modal -->
                                    @if($showModal)
                                        <div class="modal fade show d-block" style="background: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Ishni Tugatish</h5>
                                                        <button type="button" class="close" wire:click="closeModal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <form wire:submit.prevent="saveData({{ $manufacture->id }})">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="waste">Brak</label>
                                                                <input type="text" id="waste" class="form-control" wire:model="waste">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Bekor qilish</button>
                                                            <button type="submit" class="btn btn-success">Saqlash</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                </div>
            </div>
            <div class="card card-row card-default">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        Dones
                    </h3>
                </div>
                <div class="card-body">
                    <div class="card card-light card-outline">
                        @foreach ($dones as $done)
                            <div class="card-header">
                                <h5 class="card-title">{{ $done->manufacturing->product->name }}</h5>
                                <div class="card-tools">
                                    <a wire:click="givingpermit({{ $done->id }})" class="btn btn-tool">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </div> 
                            @if ($permission3 == $done->id)
                                <div class="card-body">
                                    <div class="p-3 mb-2 bg-primary text-white rounded">
                                        <strong>Product Name:</strong> {{ $done->manufacturing->product->name }}
                                    </div>
                                    <div class="p-3 mb-2 bg-secondary text-white rounded">
                                        <strong>Total Count:</strong> {{ $done->manufacturing->total_count }}
                                    </div>
                                </div>
                            @endif  
                        @endforeach
                    </div>
                </div>
                
            </div>

        </div>
    </section>
</div>





