<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use packages\UseCase\TaskIndexUseCase;
use packages\UseCase\TaskStoreUseCase;
use packages\UseCase\TaskShowUseCase;
use packages\UseCase\TaskUpdateUseCase;
use packages\UseCase\TaskDestroyUseCase;

class TasksController extends Controller
{
    private $currentUserId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->currentUserId = auth()->user()->id;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskIndexUseCase $useCase)
    {
        return $useCase->handle($this->currentUserId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreUseCase $useCase,Request $request)
    {
        $useCase->handle($request, $this->currentUserId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TaskShowUseCase $useCase, $id)
    {
        return $useCase->handle($id, $this->currentUserId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateUseCase $useCase,Request $request, $id)
    {
        $useCase->handle($request, $id, $this->currentUserId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskDestroyUseCase $useCase,$id)
    {
        $useCase->handle($id, $this->currentUserId);
    }
}
