<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\AgentsCostumers;
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

        $input = array(
            "address" => $request->address,
            "agent" => array($request->agent_id),
            "city" => $request->city,
            "zip" => $request->zip,
            "name"=> $request->name,
        );        
        
        $res = $this->microgen->service('customers')->create($input);
        
        if (array_key_exists('error', $res)) { 
            return response()->json($res['error'], $res['status']);
        };

        $response = $res['data'];
        $input = array(
            "address" => $request->address,
            "agent_id" => $request->agent_id,
            "city" => $request->city,
            "zip" => $request->zip,
            "id" => $response["_id"],            
            "name"=> $request->name,
        );


        Customer::where('id', '=', $response["_id"])->delete();

        $customer = Customer::create($input);

        $agentCustomer = AgentsCostumers::create(array(
            "customer_id" => $response["_id"],
            "agent_id" => $request->agent_id
        ));


        return response()->json($input);
    }

    /**
     * Update an customer
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id) {
        $input = array(
            "address" => $request->address,
            "agent" => array($request->agent_id),
            "city" => $request->city,
            "zip" => $request->zip,
            "name"=> $request->name,
        );


        $res = $this->microgen->service('customers')->updateById($id, $input);

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        AgentsCostumers::where('customer_id', '=', $id)->update(array(
            "agent_id" => $request->agent_id
        ));

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
