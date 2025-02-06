<?php

namespace App\Interfaces;

use App\Http\Requests\DeleteRequest;
use Illuminate\Http\JsonResponse;

interface ControllerInterface
{
    public function create();
    public function store();
    public function show();
    public function edit();
    public function update();
    public function destroy(DeleteRequest $request): JsonResponse;
}