<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceMaterialController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Middleware\Check;
use App\Livewire\DetailWarehouseValuesHistoryComponent;
use App\Livewire\ManufacturingComponent;
use App\Livewire\MaterialHistoryComponent;
use App\Livewire\ProductComponent;
use App\Livewire\ProductionComponent;
use App\Livewire\SalesComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Login.login');
});
Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/check', [LoginController::class, 'check'])->name('login.check');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
});
Route::middleware([Check::class])->group(function () {

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create-page', [RoleController::class, 'page'])->name('role.create-page');
        Route::post('/create', [RoleController::class, 'create'])->name('role.create');
        Route::put('/update/{role}', [RoleController::class, 'update'])->name('role.update');
        Route::get('/update-page/{role}', [RoleController::class, 'updatepage'])->name('role.update-page');
        Route::delete('/delete/{role}', [RoleController::class, 'delete'])->name('role.delete');
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/create', [UserController::class, 'create'])->name('user.create');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('user.delete');
    });
    Route::prefix('group')->group(function () {
        Route::get('/', [PermissionGroupController::class, 'index'])->name('group.index');
        Route::put('/update/{group}', [PermissionGroupController::class, 'update'])->name('group.update');
    });
    Route::prefix('permission')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
        Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('permission.update');
        Route::put('/edit/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
    });
    Route::prefix('department')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
        Route::post('/create', [DepartmentController::class, 'create'])->name('department.create');
        Route::put('/update/{department}', [DepartmentController::class, 'update'])->name('department.update');
    });
    Route::prefix('employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/create-page', [EmployeeController::class, 'page'])->name('employee.create-page');
        Route::post('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::delete('/delete/{employee}', [EmployeeController::class, 'delete'])->name('employee.delete');
        Route::get('/update-page/{employee}', [EmployeeController::class, 'updatepage'])->name('employee.update-page');
        Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    });
    Route::prefix('salarytype')->group(function(){
        Route::get('/',[SalaryTypeController::class,'index'])->name('salarytype.index');
        Route::post('/create',[SalaryTypeController::class,'create'])->name('salarytype.create');
        Route::put('/update/{salarytype}',[SalaryTypeController::class,'update'])->name('salarytype.update');
        Route::delete('/delete/{salarytype}',[SalaryTypeController::class,'delete'])->name('salarytype.delete');
    });
    Route::prefix('warehouse')->group(function() {
        Route::get('/',[WarehouseController::class,'index'])->name('warehouse.index');
        Route::get('/materials/{warehouse}',[WarehouseController::class,'materialpage'])->name('warehouse.materials');
        Route::get('/products/{warehouse}',[WarehouseController::class,'productpage'])->name('warehouse.products');
        Route::post('/create',[WarehouseController::class,'create'])->name('warehouse.create');
        Route::delete('/delete/{warehouse}',[WarehouseController::class,'delete'])->name('warehouse.delete');
        Route::put('/update/{warehouse}',[WarehouseController::class,'update'])->name('warehouse.update');
        Route::put('/activity/{warehouse}',[WarehouseController::class,'activity'])->name('warehouse.activity');
        Route::post('/transfer/{warehouse_id}',[WarehouseController::class,'export'])->name('warehouse.transfer');
        Route::post('/producttransfer/{warehouse_id}',[WarehouseController::class,'productexport'])->name('warehouse.producttransfer');
    });
    Route::prefix('invoice_materials')->group(function(){
        Route::get('/',[InvoiceMaterialController::class,'index'])->name('invoice_materials.index');
        Route::post('/create',[InvoiceMaterialController::class,'create'])->name('invoice_materials.create');
        Route::get('/create-page',[InvoiceMaterialController::class,'page'])->name('invoice_materials.create-page');
        Route::get('/detail/{invoice_material}',[InvoiceMaterialController::class,'show'])->name('invoice_materials.detail');
    });
    Route::prefix('products')->group(function(){
        Route::get('/',ProductComponent::class)->name('products.index');
    });
    Route::prefix('machines')->group(function() {
        Route::get('/',[MachineController::class,'index'])->name('machines.index');
        Route::post('/create',[MachineController::class,'create'])->name('machines.create');
        Route::put('/status/{machine}',[MachineController::class,'statusupdate'])->name('machines.status');
        Route::put('/update/{machine}',[MachineController::class,'update'])->name('machines.update');
    });
    Route::prefix('manufacturing')->group(function(){
        Route::get('/',ManufacturingComponent::class)->name('manufacturing.index');
    });
    Route::prefix('productions')->group(function(){
        Route::get('/',ProductionComponent::class)->name('productions.index');
    });
    Route::prefix('history')->group(function(){
        Route::get('/materials',MaterialHistoryComponent::class)->name('history.material');
        Route::get('/detail', DetailWarehouseValuesHistoryComponent::class)->name('history.detail');
    });
    Route::prefix('customer')->group(function(){
        Route::get('/',[CustomerController::class,'index'])->name('customer.index');
        Route::get('/createpage',[CustomerController::class,'createpage'])->name('customer.createpage');
        Route::post('/store',[CustomerController::class,'store'])->name('customer.store');
        Route::get('/updatepage/{customer}',[CustomerController::class,'updatepage'])->name('customer.updatepage');
        Route::put('/update/{customer}',[CustomerController::class,'update'])->name('customer.update');
        Route::delete('/delete/{customer}',[CustomerController::class,'delete'])->name('customer.delete');
    });
    Route::prefix('sale')->group(function(){
        Route::get('/',SalesComponent::class)->name('sale.index');
    });
});
