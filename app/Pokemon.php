<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    public $timestamps = false;

    public $table = "pokemones";

    protected $fillable = ['nombre', 'tipo', 'created_at'];
}
