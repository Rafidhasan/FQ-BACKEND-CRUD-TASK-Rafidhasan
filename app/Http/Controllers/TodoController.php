<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

use App\User;

use Auth;

class TodoController extends Controller
{
    public function index() {
        $todos = Auth::user()->todos;

        if(! $todos) {
            return response()->json([
                'success' => false,
                'data' => "no todos"
            ]);
        }   else {
            return response()->json([
                'success' => true,
                'data' => "$todos"
            ]);
        }
    }
    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
        ]);

        $todo = new Todo();
        $todo->name = $request->name;
        $todo->user_id = auth()->id();

        if(! $todo) {
            abort(404);
        }   else {
            return response()->json([
                'success' => true,
                'data' => $todo
            ]);
        }
    }

    public function update(Request $request, $id) {
        $tasks = auth()->user()->todos()->find($id);

        if(!$tasks) {
            return response()->json([
                'success' => false,
                'data' => 'Task with id'. $id. 'not found'
            ]);
        }

        $updated = $tasks->fill($request->all())->save();

        if($updated) {
            return response()->json([
                'success' => true,
                'data' => 'Tasks updated'
            ]);
        }   else {
            return response()->json([
                'success' => false,
                'data' => 'Task could not be updated'
            ]);
        }
    }

    public function destroy($id){
        $todo = auth()->user()->todos()->find($id);

        if (!$todo){
           return response()->json([
                   'success' => false,
                   'message' => 'Tasks with id'. $id . 'not found'
           ]);
        }

        if($todo->delete()){
           return response()->json([
                   'success' => true,
                   'message' => "Tasks deleted successfully"
           ]);
        }else{
           return response()->json([
                   'success' => false,
                   'message' => 'Tasks could not be deleted'
            ]);
        }
    }

    public function complete($id) {
        $todo = Todo::find($id);
        $todo->completed($todo->id);

        return redirect('/');
    }
}
