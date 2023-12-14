<?php

namespace App\Api\V1\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entrenador;

class EntrenadorController extends Controller
{
    public function crear(Request $request)
    {
        try {
            // Validacion del request, debe existir nombre 
            $request->validate([
                'nombre' => 'required|max:255',
            ]);
    
            // lo mando en formato json
            $nombre = $request->json('nombre');
    
            // Creo el entrenador
            $entrenador = Entrenador::create([
                'nombre' => $nombre,
                'created_at' => now(),
            ]);
    
            return [
                'status' => 'ok',
                'id_entrenador' => $entrenador->id
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
    

    public function detalle($id)
    {
        try {
            $entrenador = Entrenador::with('equipos')->find($id);

            if (!$entrenador) {
                throw new Exception("No se encontró el entrenador.");
            }

            return [
                'status' => 'ok',
                'entrenador' => $entrenador
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function listar()
    {
        try {
            $entrenadores = Entrenador::all();
    
            if ($entrenadores->isEmpty()) {
                throw new Exception("No hay entrenadores disponibles.");
            }
    
            return [
                'status' => 'ok',
                'entrenadores' => $entrenadores
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}
