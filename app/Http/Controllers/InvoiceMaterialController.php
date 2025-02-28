<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceMaterial\InvoiceMaterialCreateRequest;
use App\Imports\InvoiceImport;
use App\Jobs\ProcessInvoiceMaterials;
use App\Models\History;
use App\Models\Invoice;
use App\Models\InvoiceMaterial;
use App\Models\Material;
use App\Models\Warehouse;
use App\Models\WarehouseValue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceMaterialController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        $invoices = Invoice::orderBy('id', 'desc')->paginate(10);
        return view('Invoice_Material.index', ['warehouses' => $warehouses, 'invoices' => $invoices]);
    }
    public function page()
    {
        $warehouses = Warehouse::all();
        return view('Invoice_Material.create', ['warehouses' => $warehouses]);
    }
    public function create(InvoiceMaterialCreateRequest $request)
    {
        $file = $request->file('excel_file');
        $filePath = $file ? $file->store('invoice_files') : null;

        $companyName = $request->company_name;
        $warehouseId = $request->warehouse_id;

        ProcessInvoiceMaterials::dispatch($companyName,$warehouseId, $filePath);

        return redirect()->route('invoice_materials.index')->with('success', 'Shift has been set successfully');


        // $rows = Excel::toCollection(new InvoiceImport(), $request->file('excel_file'));

        // $row1 = $rows[0][5] ?? null;
        // $row2 = $rows[0][6] ?? null;

        // if ($row1 && $row2) {
        //     $invoice = Invoice::create([
        //         'company_name' => $request->company_name,
        //         'date' => $row1[2] ?? null,
        //         'text' => $row2[2] ?? null,
        //     ]);
        // }

        // for ($i = 11; $i <= 22; $i++) {
        //     $row = $rows[0][$i] ?? null;

        //     if (!$row || !isset($row[1])) {
        //         continue;
        //     }

        //     $slug = Str::slug($row[1]);

        //     if ($slug) {
        //         $material = Material::firstOrCreate(
        //             ['slug' => $slug],
        //             ['name' => $row[1]]
        //         );

        //         $previousValue = WarehouseValue::where('warehouse_id', $request->warehouse_id)
        //             ->where('product_id', $material->id)
        //             ->value('value') ?? 0;

        //         $currentValue = $previousValue + ($row[3] ?? 0);

        //         InvoiceMaterial::create([
        //             'invoice_id' => $invoice->id,
        //             'material_id' => $material->id,
        //             'unit' => $row[2] ?? null,
        //             'quantity' => $row[3] ?? null,
        //             'price' => $row[4] ?? null,
        //             'summa' => (isset($row[3], $row[4]) && is_numeric($row[3]) && is_numeric($row[4]))
        //                 ? $row[3] * $row[4] : 0,
        //         ]);

        //         WarehouseValue::updateOrCreate(
        //             ['warehouse_id' => $request->warehouse_id, 'product_id' => $material->id],
        //             ['value' => $currentValue]
        //         );

        //         History::create([
        //             'type' => $request->transfer_type,
        //             'material_id' => $material->id,
        //             'quantity' => $row[3] ?? null,
        //             'previous_value' => $previousValue,
        //             'current_value' => $currentValue,
        //             'from_id' => $invoice->id,
        //             'to_id' => $request->warehouse_id
        //         ]);
        //     }
        // }
        
    }
    public function show(Invoice $invoice_material)
    {
        return view('Invoice_Material.show',['invoice'=>$invoice_material]);
    }
}
