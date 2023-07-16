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
        $page = 1;
        if($request->has('page'))
        {
            $page = $request->get('page');
        }
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
    
        $users = auth()->user()->suggestions()
        ->skip($offset)
        ->take($perPage)
        ->get();

        $response = view('components.suggestion',compact('users'))->render();
        return response()->json([
            'content' => $response,
        ]);   
    }
}
