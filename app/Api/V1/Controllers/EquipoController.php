<?php

namespace App\Api\V1\Controllers;

use Exception;
use App\Equipo;
use App\EquipoPokemon;
use App\Pokemon;
use App\Entrenador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipoController extends Controller
{
    public function listar(Request $request)
    {
        try {
            $request->validate(['id_entrenador' => 'required|exists:entrenadores,id']);
            $idEntrenador = $request->id_entrenador;
            $equipos = Equipo::where('id_entrenadores', $idEntrenador)->paginate(10);
            return [
                'status' => 'ok',
                'equipos' => $equipos
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function detalle($id)
    {
        $equipo = null;
        try {
            $equipo = Equipo::select(
                'equipos.id as id',
                'equipos.nombre as nombre',
                'pokemones.id as id_pokemones',
                'pokemones.nombre as nombre_pokemones',
                'pokemones.tipo as tipos_pokemones',
                'equipo_pokemones.orden as orden_pokemones'
            )
                ->join('equipo_pokemones', 'equipo_pokemones.id_equipos', 'equipos.id')
                ->join('pokemones', 'pokemones.id', 'equipo_pokemones.id_pokemones')
                ->where('equipos.id', $id)
                ->get()
                ->toArray();


            if (empty($equipo)) {
                throw new Exception("No se encontro el equipo.");
            }

            return [
                'status' => 'ok',
                'equipo' => $equipo
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function crear()
    {
        try {
            // Validacion: Si hay entrenadores en bd
            $entrenador = Entrenador::inRandomOrder()->first();
            if (!$entrenador) {
                throw new Exception("No hay entrenadores disponibles en la base de datos.");
            }

            // Validacion: si hay al menos 3 Pokemon en la base de datos
            $pokemones = Pokemon::inRandomOrder()->limit(3)->get();
            if ($pokemones->count() < 3) {
                throw new Exception("No hay suficientes Pokémon disponibles en la base de datos.");
            }

            $nombreEquipo = $this->generarNombreEquipo($pokemones);


            $equipo = Equipo::create([
                'id_entrenadores' => $entrenador->id,
                'nombre' => $nombreEquipo,
                'created_at' => now(), 
            ]);

            // Pokemon al equipo
            foreach ($pokemones as $orden => $pokemon) {
                EquipoPokemon::create([
                    'id_equipos' => $equipo->id,
                    'id_pokemones' => $pokemon->id,
                    'orden' => $orden + 1,// le sumo 1 para que no empiece en 0
                    'created_at' => now(), 
                ]);
            }

            return [
                'status' => 'ok',
                'mensaje' => 'Equipo creado exitosamente.',
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

        private function generarNombreEquipo($pokemones)
    {
        // Para generar un nombre de equipo uno los nombres de los pokemon que lo conformaran
        $nombresPokemon = $pokemones->pluck('nombre')->toArray();
        $nombreEquipo = implode(' & ', $nombresPokemon);

        return $nombreEquipo;
    }
}
