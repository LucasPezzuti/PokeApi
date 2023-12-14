<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    public $timestamps = false;

    public $table = "equipos";

    protected $fillable = ['id_entrenadores', 'nombre', 'created_at'];

    public static function cleanEquipoDetalle($equipoData)
    {
        $equipo = [];
        foreach ($equipoData as $equipoElement) {
            $equipo['id'] = $equipoElement['id'];
            $equipo['nombre'] = $equipoElement['nombre'];

            $pokemones[] =                 [
                'id' => $equipoElement['id_pokemones'],
                'nombre' => $equipoElement['nombre_pokemones'],
                'tipo' => json_decode($equipoElement['tipos_pokemones']),
                'orden' => $equipoElement['orden_pokemones']
            ];
        }
        $equipo['pokemones'] = $pokemones;
        return $equipo;
    }
}
