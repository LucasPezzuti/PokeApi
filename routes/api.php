<?php
Route::prefix('entrenadores')->group(function () {
    Route::post('crear', 'EntrenadorController@crear');
    Route::get('{id}', 'EntrenadorController@detalle')
        ->where('id', '[0-9]+');
});
Route::prefix('pokemones')->group(function () {
    Route::get('listar', 'PokemonController@listar');
    Route::get('{id}', 'PokemonController@detalle')
        ->where('id', '[0-9]+');
    Route::get('fromapi', 'PokemonController@get_15_pokemones');
});
Route::prefix('equipos')->group(function () {
    Route::get('listar', 'EquipoController@listar');
    Route::post('crear', 'EquipoController@crear');
    Route::get('{id}', 'EquipoController@detalle')
        ->where('id', '[0-9]+');
});
Route::prefix('app')->group(function () {
    Route::post('get-pokemones', 'AppController@getPokemones');
});
