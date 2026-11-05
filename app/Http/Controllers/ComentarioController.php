<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ComentarioController extends Controller
{
    private const Messages = [
        'noticia_id.required' => 'No existe esa noticia',
        'noticia_id.numeric' => 'La noticia no se ha seleccionado bien',
        'noticia_id.exists' => 'La noticia no existe',
        'mensaje.min' => 'El mensaje es demasiado corto',
        'mensaje.max' => 'El mensaje es demasiado largo',
        'valoracion.in' => 'La valoración no es válida',
    ];

    private const RULES = [
        'noticia_id' => 'required|numeric|exists:noticia,id',
        'mensaje' => 'nullable|string|min:2|max:200',
        'valoracion' => 'required|in:1,2,3,4,5',
    ];

    public function index(): View
    {
        return view('comentario.index', ['comentarios' => Comentario::all()]);
    }

   public function create(Request $request): View
{
    return view('comentario.create', [
        'noticias' => Noticia::all(),
        'noticia_id' => $request->query('noticia_id')
    ]);
}

public function store(Request $request): RedirectResponse
{
    $validator = Validator::make($request->all(), self::RULES, self::Messages);

    if ($validator->fails()) {
        return back()->withInput()->withErrors($validator);
    }

    try {
        Comentario::create($validator->validated());
    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'error' => 'No se ha podido crear el comentario.',
        ]);
    }

    return redirect()->route('noticia.index')->with('success', 'Comentario creado correctamente.');
}

    public function show(Comentario $comentario): View
    {
        return view('comentario.show', compact('comentario'));
    }

    public function edit(Comentario $comentario): View
    {
        return view('comentario.edit', compact('comentario'));
    }

    public function update(Request $request, Comentario $comentario): RedirectResponse
    {
        $validator = Validator::make($request->all(), self::RULES, self::Messages);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        try {
            $comentario->update($validator->validated());
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Error al editar el comentario.',
            ]);
        }

        return redirect()->route('noticia.index')->with('success', 'Comentario actualizado correctamente.');
    }

    public function destroy(Comentario $comentario): RedirectResponse
    {
        try {
            $comentario->delete();
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'No se ha podido eliminar el comentario.',
            ]);
        }

        return redirect()->route('comentario.index')->with('success', 'Comentario eliminado correctamente.');
    }
}