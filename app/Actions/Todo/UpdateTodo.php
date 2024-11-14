<?php

namespace App\Actions\Todo;

use App\Models\Todo;

class UpdateTodo
{
    public function update($request, Todo $todo)
    {
        $todo->update($request->validated());

        return $todo;
    }
}
