<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loadMore       = 1;
        $loadMorePage   = 1;
        $page           = 1;
        $perPage        = 10;
        $offset         = ($page - 1) * $perPage;
        $connections = auth()->user()->connections()
                        ->skip($offset)
                        ->take($perPage)
                        ->get();
        $response    = view('components.connection',compact('connections','loadMorePage'))->render();
        return response()->json([
            'content' => $response,
            'page'      => $page,
            'loadMore'  => $loadMore
        ]); 
    }
    
    public function getMoreConnections(Request $request)
    {
        $page           = 1;
        $loadMorePage   = 0;
        if($request->has('page'))
        {
            $page = $request->get('page');
        }
        $perPage    = 10;
        $offset     = ($page - 1) * $perPage;

        $totalRecords = aauth()->user()->connections()->count();
        $loadMore = 1;
        if($perPage + $offset >=$totalRecords)
        {
            $loadMore = 0;
        }
        $users          = auth()->user()->connections()
        ->skip($offset)
        ->take($perPage)
        ->get();
        $response    = view('components.connection',compact('connections','loadMorePage'))->render();
        return response()->json([
            'content' => $response,
            'page'      => $page,
            'loadMore'  => $loadMore
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $connection = Connection::where('id',$id)->delete();
        if($connection)
        {
            $response = [
                'status' => true,
                'message' => 'Connection deleted successfully!'
            ];
        }
        else
        {
            $response = [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
        }
        return response()->json($response); 
    }
}
