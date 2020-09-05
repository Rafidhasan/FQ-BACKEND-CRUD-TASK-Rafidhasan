<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name', 'check'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function completed($id) {
        $this->check = true;
        $this->save();
        return response()->json([
            'success' => true,
            'message' => "Task is done"
        ]);
    }
}
