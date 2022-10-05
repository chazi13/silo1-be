<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

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
        return $customers;
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
        return $customer;
    }

    /**
     * Create a new customer
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        $res = $this->microgen->service('customers')->create($request->all());

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        $customer = Customer::create($request->all());

        return $customer;
    }

    /**
     * Update an customer
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id) {
        $res = $this->microgen->service('customers')->updateById($id, $request->all());

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        $affectedRow = Customer::where('id', '=', $id)->update($request->all());
        $updatedCustomer = Customer::find($id);

        return $updatedCustomer;
    }

    /**
     * Delete an customer
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $res = $this->microgen->service('customers')->deleteById($id);

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        Customer::where('id', '=', $id)->delete();

        return array("message" => "Resource deleted successfully");
    }
}
