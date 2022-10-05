<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Show all customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with("agent")->get();

        return response()-> json($customers);
    }

    /**
     * Show a specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where('id', '=', $id)->first();

        return response()-> json($customer);
    }

    /**
     * Create a new customer
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $customer = Customer::create($request->all());

        return response()->json($customer);
    }

    /**
     * Update an customer
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id) {
        $affectedRow = Customer::where('id', '=', $id)->update($request->all());
        $updatedCustomer = Customer::find($id);

        return response()->json($updatedCustomer);
    }

    /**
     * Delete an customer
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Customer::where('id', '=', $id)->delete();

        return response()-> json(array("message" => "Resource deleted successfully"));
    }
}
