<?php

namespace App\Actions\Todo;

use App\Models\Todo;

class CreateTodo
{
    public function create($request)
    {
        $todo = Todo::create($request->validated());

        return $todo;
    }
}
