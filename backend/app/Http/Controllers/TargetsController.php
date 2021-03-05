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
use Illuminate\Auth;
use JWTAuth;

class TargetsController extends Controller
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
    public function index(TargetIndexUseCase $useCase)
    {
        $allTargets = $useCase->handle($this->currentUserId);
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
        $useCase->handle($request, $this->currentUserId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TargetShowUseCase $useCase, $id)
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
    public function update(TargetUpdateUseCase $useCase, Request $request, $id)
    {
        $useCase->handle($id, $this->currentUserId, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetDestroyUseCase $useCase, $id)
    {
        $useCase->handle($id, $this->currentUserId);
    }
}
