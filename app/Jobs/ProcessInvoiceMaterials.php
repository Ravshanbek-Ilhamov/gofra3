<?php

namespace App\Jobs;

use App\Imports\InvoiceImport;
use App\Models\History;
use App\Models\Invoice;
use App\Models\InvoiceMaterial;
use App\Models\Material;
use App\Models\WarehouseValue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;


class ProcessInvoiceMaterials implements ShouldQueue
{
    use Queueable;
    protected $companyName;
    protected $warehouseId;
    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($companyName, $warehouseId, $filePath)
    {
        $this->companyName = $companyName;
        $this->warehouseId = $warehouseId;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = $this->filePath; // "private/invoice_files/file.xlsx"

        if (!Storage::disk('local')->exists($filePath)) {
            Log::error("topilmadi storage/app/private: " . $filePath);
            return;
        }

        // To‘liq fayl yo‘lini olish
        $fullPath = Storage::disk('local')->path($filePath);

        // Excel faylini o'qish
        try {
            $rows = Excel::toCollection(new InvoiceImport(), $fullPath);
        } catch (\Exception $e) {
            Log::error("Error reading Excel file: " . $e->getMessage());
            return;
        }

        $row1 = $rows[0][5] ?? null;
        $row2 = $rows[0][6] ?? null;

        if ($row1 && $row2) {
            $invoice = Invoice::create([
                'company_name' => $this->companyName,
                'date' => $row1[2] ?? null,
                'text' => $row2[2] ?? null,
            ]);
        }

        for ($i = 11; $i <= 22; $i++) {
            $row = $rows[0][$i] ?? null;

            if (!$row || !isset($row[1])) {
                continue;
            }

            $slug = Str::slug($row[1]);

            if ($slug) {
                $material = Material::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $row[1]]
                );

                $previousValue = WarehouseValue::where('warehouse_id', $this->warehouseId)
                    ->where('product_id', $material->id)
                    ->value('value') ?? 0;

                $currentValue = $previousValue + ($row[3] ?? 0);

                InvoiceMaterial::create([
                    'invoice_id' => $invoice->id,
                    'material_id' => $material->id,
                    'unit' => $row[2] ?? null,
                    'quantity' => $row[3] ?? null,
                    'price' => $row[4] ?? null,
                    'summa' => (isset($row[3], $row[4]) && is_numeric($row[3]) && is_numeric($row[4]))
                        ? $row[3] * $row[4] : 0,
                ]);

                WarehouseValue::updateOrCreate(
                    ['warehouse_id' => $this->warehouseId, 'product_id' => $material->id],
                    ['value' => $currentValue]
                );

                History::create([
                    'type' => 1,
                    'material_id' => $material->id,
                    'quantity' => $row[3] ?? null,
                    'previous_value' => $previousValue,
                    'current_value' => $currentValue,
                    'from_id' => $invoice->id,
                    'to_id' => $this->warehouseId
                ]);
            }
        }
    }
}
