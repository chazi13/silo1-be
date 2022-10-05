<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{

    /**
     * Show all agents in a database.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agent = Agent::with("customers")->get();

        return response()-> json($agent);
    }

    /**
     * Show a specified agent.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agent = Agent::where('id', '=', $id)->first();

        return response()-> json($agent);

    }

    /**
     * Create a new agent in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $agent = Agent::create($request->all());

        return response()-> json($agent);
    }

    /**
     * Delete an employee
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Agent::where('id', '=', $id)->delete();

        return response()-> json(array("message" => "Resource deleted successfully"));
    }
}
