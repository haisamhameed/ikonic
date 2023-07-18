<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;
use App\Models\ConnectionRequest;

class ConnectRequestController extends Controller
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
        $sendRequest = auth()->user()->sentConnectionRequests()
                        ->with('userReceiver')
                        ->skip($offset)
                        ->take($perPage)
                        ->get();
        $response    = view('components.request',compact('sendRequest','loadMorePage'))->render();
        return response()->json([
            'content' => $response,
            'page'      => $page,
            'loadMore'  => $loadMore
        ]); 
    }
    public function getMoreRequests(Request $request)
    {
        $page           = 1;
        $loadMorePage   = 0;
        if($request->has('page'))
        {
            $page = $request->get('page');
        }
        $perPage    = 10;
        $offset     = ($page - 1) * $perPage;

        $totalRecords = auth()->user()->suggestions()->count();
        $loadMore = 1;
        if($perPage + $offset >=$totalRecords)
        {
            $loadMore = 0;
        }
        $sendRequest = auth()->user()->sentConnectionRequests()
                        ->with('userReceiver')
                        ->skip($offset)
                        ->take($perPage)
                        ->get();
        $response    = view('components.request',compact('sendRequest','loadMorePage'))->render();
        return response()->json([
            'content' => $response,
            'page'      => $page,
            'loadMore'  => $loadMore
        ]);
    }
    public function receivedRequests()
    {
        $receiveRequest = auth()->user()->receivedConnectionRequests()->with('userSender')->get();
        $response    = view('components.receive-request',compact('receiveRequest'))->render();
        return response()->json([
            'content' => $response,
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
        if($request->has('suggestionId'))
        {
            ConnectionRequest::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->suggestionId,
                'status' => 0
            ]);
            $response = [
                'status' => true,
                'message' => 'Connection Request sent successfully!'
            ];
        }
        else
        {
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong',
                'id' =>$request->suggestionId
            ];
        }
        return response()->json($response); 
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
        $request = ConnectionRequest::where('id',$id)->get()->first();
        if($request)
        {
            $request->status = 1;
            $request->save();
            Connection::create([
                'user_id_1' => $request->receiver_id,
                'user_id_2' => $request->sender_id
            ]);
            $response = [
                'status' => true,
                'message' => 'Connection Request accepted successfully!'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = ConnectionRequest::where('id',$id)->delete();
        if($request)
        {
            $response = [
                'status' => true,
                'message' => 'Connection Request withdraw successfully!'
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
