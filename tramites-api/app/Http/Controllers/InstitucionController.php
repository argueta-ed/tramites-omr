<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstitucionRequest;
use App\Http\Resources\InstitucionResource;
use App\Services\InstitucionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstitucionController extends Controller
{
    public function __construct(private InstitucionService $service) {}

    public function index(): JsonResponse
    {
        $instituciones = $this->service->getAll();
        return response()->json([
            'success' => true,
            'data' => InstitucionResource::collection($instituciones)
        ]);
    }

    public function store(StoreInstitucionRequest $request): JsonResponse
    {
        $institucion = $this->service->create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Institución creada exitosamente',
            'data' => new InstitucionResource($institucion)
        ], 201);
    }
}
