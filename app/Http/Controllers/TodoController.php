<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

use App\User;

use Auth;

class TodoController extends Controller
{
    public function index() {
        dd(Auth::user());
        $todos = Auth::user()->todos;

        if(! $todos) {
            return response()->json([
                'success' => false,
                'data' => "no todos"
            ]);
        }   else {
            return response()->json()([
                'success' => true,
                'data' => $todos
            ]);
        }
    }
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            // 'check' => 'accepted'
        ]);

        $todo = new Todo();
        $todo->name = $request->name;
        $todo->check = $request->check;

        if(auth()->todos()->save($todos)) {
            return response()->json()([
                'success' => true,
                'data' => $todos
            ]);
        }   else {
            return response()->json()([
                'success' => false,
                'data' => 'no tasks for you'
            ]);
        }
    }

    public function update(Request $request, $id) {
        $tasks = auth()->user()->todos()->find($id);

        if(!$tasks) {
            return response()->json([
                'success' => false,
                'data' => 'Product with id'. $id. 'not found'
            ], 500);
        }

        $updated = $tasks->fill($request->all())->save();

        if($updated) {
            return response()->json([
                'success' => true,
                'data' => 'Tasks updated'
            ], 200);
        }   else {
            return $response()->json([
                'success' => false,
                'data' => 'product could not be updated'
            ], 500);
        }
    }

    public function destroy($id) {
        $tasks = auth()->user()->todos()->find($id);

        if(!$tasks) {
            return response()->json([
                'success' => true,
                'message' => 'task deleted'
            ]);
        }   else {
            return response()->json([
                'success' => false,
                'message' => 'product could not be deleted'
            ], 500);
        }
    }
}
