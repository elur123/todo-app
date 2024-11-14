<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Todo\CreateTodo;
use App\Actions\Todo\GetTodoList;
use App\Actions\Todo\RemoveTodo;
use App\Actions\Todo\UpdateTodo;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Requests\Todo\CreateRequest;
use App\Requests\Todo\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function __construct(
        private GetTodoList $getTodoList,
        private CreateTodo $createTodo,
        private UpdateTodo $updateTodo,
        private RemoveTodo $removeTodo,
    )
    {
        
    }

    public function index()
    {
        $todos = $this->getTodoList->list();

        return TodoResource::collection($todos)
            ->additional([
                'status' => Response::HTTP_OK,
                'message' => 'Successfull retrieved todo list'
            ]);
    }

    public function store(CreateRequest $request)
    {
        $todo = $this->createTodo->create($request);

        return TodoResource::make($todo)
            ->additional([
                'status' => Response::HTTP_OK,
                'message' => 'Successfull created todo'
            ]);
    }

    public function update(UpdateRequest $request, Todo $todo)
    {
        $todo = $this->updateTodo->update($request, $todo);

        return TodoResource::make($todo)
            ->additional([
                'status' => Response::HTTP_OK,
                'message' => 'Successfull updated todo'
            ]);
    }

    public function destroy(Todo $todo)
    {
        $this->removeTodo->remove($todo);

        return response()->json([
            'data' => null,
            'status' => Response::HTTP_OK,
            'message' => 'Successfully removed todo'
        ], Response::HTTP_OK);
    }
}
