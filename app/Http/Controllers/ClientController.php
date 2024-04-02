<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
    }
    public function index()
    {
        //
        return response()->json(Client::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if ($request->user()->can('create-clients')) {
            $client = new Client();
            $client->name = $request->input('name');
            $client->email= $request->input('email');
            $client->detail = $request->input('detail');
            $client->phone_number = $request->input('phone_number');
            $client->address = $request->input('address');
            $client->gender_type = $request->input('gender_type');
            $client->save();

            return response()->json($client);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create client!'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, string $id)
    {
        //
        $client = Client::find($id);
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $client = Client::find($id);
        $client->update($request->all());

        return response()->json('Client successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-clients')) {
            $client = Client::find($id);
            $client->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete client!'
        ], 200);
    }
}
