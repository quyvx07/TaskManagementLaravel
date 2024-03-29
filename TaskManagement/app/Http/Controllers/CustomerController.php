<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(6);
        return view("index", compact('customers'));
    }

    public function create()
    {
        return view("create");
    }

    public function store(Request $request)
    {
        $customer = new  Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $file = $request->inputFile;
        if (!$request->hasFile('inputFile')) {
            $customer->image = $file;
        } else {
//          php artisan storage:link
            $path = $file->store('images', 'public');
            $customer->image = $path;
        }
        $customer->save();
        $message = "Tạo Customer $request->inputTitle thành công!";
        return redirect()->route('customers.index', compact('message'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('detail', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $file = $request->inputFile;
        if (!$request->hasFile('inputFile')) {
            $customer->image = $file;
        } else {
//          php artisan storage:link
            $path = $file->store('images', 'public');
            $customer->image = $path;
        }
        $customer->save();
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route("customers.index");
    }
}
