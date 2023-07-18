<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function stats()
    {
        $response['suggestions']        = auth()->user()->suggestions()->get()->count();
        $response['sent_requests']      = auth()->user()->sentConnectionRequests()->count();
        $response['recieved_requests']  = auth()->user()->receivedConnectionRequests()->count();
        $response['connections']        = auth()->user()->connections()->count();
        return response()->json($response);  
    }
    public function suggestions(Request $request)
    {
        $loadMore       = 1;
        $loadMorePage   = 1;
        $page           = 1;
        $perPage        = 10;
        $offset         = ($page - 1) * $perPage;
        $users          = auth()->user()->suggestions()
        ->skip($offset)
        ->take($perPage)
        ->get();

        $response = view('components.suggestion',compact('users','loadMorePage'))->render();
        return response()->json([
            'content'   => $response,
            'page'      => $page,
            'loadMore'  => $loadMore
        ]);   
    }

    public function getMoreSuggestions(Request $request)
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
        $users          = auth()->user()->suggestions()
        ->skip($offset)
        ->take($perPage)
        ->get();
        $response = view('components.suggestion',compact('users','loadMorePage'))->render();
        return response()->json([
            'content'   => $response,
            'page'      => $page,
            'loadMore'  => $loadMore
        ]);  
    }
}
