<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\people;
use Illuminate\Http\Request;

class peoplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = people::all();

        return response()->json([
            'status' => 'success',
            'data' => $people
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_humans' => 'required|string|max:255',
            'gender_humans' => 'required|string|max:255',
            'address_humans' => 'required|string|max:255',
        ]);

        $people = people::create([
            'name_humans' => $request->name_humans,
            'gender_humans' => $request->gender_humans,
            'address_humans' => $request->address_humans,
        ]);

        if($people) {
            return response()->json([
                'status' => 'success',
                'message' => 'humans create successfully',
                'data' => $people
            ]);
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'humans create failed',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\people  $people
     * @return \Illuminate\Http\Response
     */
    public function show(people $people)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\people  $people
     * @return \Illuminate\Http\Response
     */
    public function edit(people $people)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\people  $people
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, people $people)
    { 
        $people->update($request->all());

        if($people) {
            return response()->json([
                'status' => 'success',
                'message' => 'humans update successfully',
                'data' => $people
            ]);
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'humans update failed',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\people  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy(people $people)
    {

        $people->delete();
        return response()->json([
            'status' => 'sucess',
            'message' => 'humans delete success'
        ]);

    }
}
