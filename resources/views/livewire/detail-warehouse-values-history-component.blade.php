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
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">📊 Warehouse Values</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>🔹 Object Name</th>
                                    <th>📉 Previous Value</th>
                                    <th>📈 Current Value</th>
                                    <th>🚚 From</th>
                                    <th>🏢 To</th>
                                    <th>📅 Date</th>
                                    <th>🔖 Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $h)
                                    <tr>
                                        {{-- Object Name --}}
                                        <td>
                                            @if ($filter == 1)
                                                {{ optional($h->material)->name ?? 'N/A' }}
                                            @elseif($filter == 2)
                                                {{ optional($h->product)->name ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                        {{-- Previous & Current Value --}}
                                        <td>{{ $h->previous_value ?? 0 }}</td>
                                        <td>{{ $h->current_value }}</td>

                                        {{-- From --}}
                                        <td>
                                            @if ($h->type == 1)
                                                🏢 {{ optional($h->invoice)->company_name ?? 'N/A' }}
                                            @elseif(in_array($h->type, [2, 3, 5]))
                                                🏭 {{ optional($h->warehouse)->name ?? 'N/A' }}
                                            @elseif($h->type == 4)
                                                🏭 Manufacturing #{{ optional($h->manufacturing)->id ?? 'N/A' }}
                                            @else
                                                {{ $h->from_id }}
                                            @endif
                                        </td>

                                        {{-- To --}}
                                        <td>
                                            @if (in_array($h->type, [1, 2, 4, 5]))
                                                🏢 {{ optional($h->towarehouse)->name ?? 'N/A' }}
                                            @elseif($h->type == 3)
                                                📦 {{ optional($h->toProduct)->name ?? 'N/A' }}
                                            @else
                                                {{ $h->to_id }}
                                            @endif
                                        </td>
                                        <td><span class="badge bg-secondary">{{ $h->created_at->format('d M Y, H:i') }}</span></td>

                                        {{-- Type --}}
                                        <td>
                                            @php
                                                $typeLabels = [
                                                    1 => ['label' => 'Invoice Material Entry', 'class' => 'bg-success'],
                                                    2 => ['label' => 'Internal Transfer', 'class' => 'bg-primary'],
                                                    3 => ['label' => 'Product Usage', 'class' => 'bg-warning'],
                                                    4 => ['label' => 'Returned to Supplier', 'class' => 'bg-danger'],
                                                    5 => ['label' => 'Product Internal Transfer', 'class' => 'bg-info']
                                                ];
                                            @endphp

                                            @if (isset($typeLabels[$h->type]))
                                                <span class="badge {{ $typeLabels[$h->type]['class'] }}">
                                                    {{ $typeLabels[$h->type]['label'] }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Footer qismi (pastda back tugma va total records) --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('history.material') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <span class="badge bg-dark p-2">
                                <strong>Total Records: {{ count($history) }}</strong>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
