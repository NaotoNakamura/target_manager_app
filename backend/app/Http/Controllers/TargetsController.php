<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Target;
use App\Models\Task;
use App\Models\User;
use packages\UseCase\TargetIndexUseCase;
use packages\UseCase\TargetStoreUseCase;
use packages\UseCase\TargetShowUseCase;
use packages\UseCase\TargetUpdateUseCase;
use packages\UseCase\TargetDestroyUseCase;

class TargetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TargetIndexUseCase $useCase)
    {
        $allTargets = $useCase->handle();
        return $allTargets;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TargetStoreUseCase $useCase, Request $request)
    {
        $useCase->handle();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TargetShowUseCase $useCase, $id)
    {
        return $useCase->handle();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TargetUpdateUseCase $useCase, Request $request, $id)
    {
        $useCase->handle();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetDestroyUseCase $useCase, $id)
    {
        $useCase->handle();
    }
}
