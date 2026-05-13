<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTramiteRequest;
use App\Http\Requests\UpdateTramiteRequest;
use App\Http\Resources\TramiteResource;
use App\Models\Tramite;
use App\Services\TramiteService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    public function __construct(private TramiteService $service) {}

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->getPaginated($request->only(['institucion_id', 'nombre']));
        
        return response()->json([
            'success' => true,
            'data' => TramiteResource::collection($paginator),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ]
        ]);
    }

    public function show(int $id): JsonResponse
    {
        try{
            $tramite = $this->service->findById($id);
            return response()->json([
                'success' => true,
                'data' => new TramiteResource($tramite)
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Trámite no encontrado'
            ], 404);
        }
    }

    public function store(StoreTramiteRequest $request): JsonResponse
    {
        $tramite = $this->service->create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Trámite creado exitosamente',
            'data' => new TramiteResource($tramite)
        ], 201);
    }

    public function update(UpdateTramiteRequest $request, Tramite $tramite): JsonResponse
    {
        $updated = $this->service->update($tramite, $request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Trámite actualizado exitosamente',
            'data' => new TramiteResource($updated)
        ]);

    }

    public function destroy(Tramite $tramite): JsonResponse
    {
        $this->service->desactivate($tramite);
        return response()->json([
            'success' => true,
            'message' => 'Trámite desactivado exitosamente'
        ]);
    }
}
