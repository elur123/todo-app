<?php

namespace App\Actions\Todo;

use App\Models\Todo;

class RemoveTodo
{
    public function remove(Todo $todo)
    {
        $todo->delete();
    }
}
