<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\ComentarioController;


Route::resource('noticia', NoticiaController::class)->parameters(['noticia' => 'noticia']); 
Route::resource('comentario', ComentarioController::class)->parameters(['comentario' => 'comentario']); 
Route::resource('/', MainController::class);