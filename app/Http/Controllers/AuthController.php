<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index() {
        $tasks = auth()->user()->todos;

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function store(Request $request){
        dd($request);
    }
}
