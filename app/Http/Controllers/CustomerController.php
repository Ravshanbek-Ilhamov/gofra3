<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function index()
    {
        // dd(123);
        $customers=Customer::orderBy('id','desc')->paginate(10);

        $addresses = [];

        foreach ($customers as $customer) {
            if (!empty($customer->latitude) && !empty($customer->longitude)) {
                $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$customer->latitude}&lon={$customer->longitude}";
    
                $response = Http::withHeaders([
                    'User-Agent' => 'MyLaravelApp/1.0 (contact@mywebsite.com)'
                ])->get($url);
    
                if ($response->successful()) {
                    $data = $response->json();
                    $addressData = $data['address'] ?? [];
    
                    // **Faqat tuman (county) ni olish**
                    $district = $addressData['county'] ?? 'Tuman topilmadi';
    
                    $addresses[$customer->id] = $district;
                } else {
                    $addresses[$customer->id] = 'API xatosi';
                }
            } else {
                $addresses[$customer->id] = 'Koordinatalar mavjud emas';
            }
        }
        return view('Customer.index',['customers'=>$customers,'addresses'=>$addresses]);
    }
    public function createpage()
    {
        return view('Customer.create');
    }
    public function store(CustomerCreateRequest $request)
    {
        // dd($request->all());
        $customer=new Customer();
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->balance=$request->balance;
        $customer->longitude=$request->longitude;
        $customer->latitude=$request->latitude;
        $customer->save();
        return redirect()->route('customer.index')->with('success','Customer Created successfully');
    }
    public function updatepage(Customer $customer)
    {
        // dd($customer->name);
        return view('Customer.update',['customer'=>$customer]);
    }
    public function update(CustomerUpdateRequest $request,Customer $customer)
    {
        // dd($request->all());
        $customer->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'balance'   => $request->balance,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    
        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }
    public function delete(Customer $customer)
    {
        // dd($customer->name);
        $customer->delete();
        return redirect()->back()->with('success','Customer deleted successfully');
    }
}
