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

        return response()->json($agent);
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
        $res = $this->microgen->service('agents')->create($request->all()); 
        
        if (array_key_exists('error', $res)) {

            return response()->json($res['error'], $res['status']);
        };

        $res = $res['data'];

        Agent::where('id', '=', $res["_id"])->delete();
 
        $agent = Agent::create(array(
            'id' => $res['_id'],
            'name' => $res['name'],
        ));

        
        return response()->json($agent);
    }

    /**
     * Update an customer
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id) {
        $res = $this->microgen->service('agents')->updateById($id, $request->all());

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        $affectedRow = Agent::where('id', '=', $id)->update($request->all());
        $updatedAgent = Agent::find($id);

        return response()->json($updatedAgent);
    }

    /**
     * Delete an employee
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $res = $this->microgen->service('agents')->deleteById($id);

        if (array_key_exists('error', $res)) {
            return response()->json($res['error'], $res['status']);
        };

        Agent::where('id', '=', $id)->delete();

        return response()-> json(array("message" => "Resource deleted successfully"));
    }
}
