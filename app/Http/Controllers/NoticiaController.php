<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class NoticiaController extends Controller
{
      private const Messages = [
            'texto.required' => 'El texto es obligatorio',
            'texto.min' => 'El texto debe tener de minimo 400 caracteres ',
            'texto.max' => 'El texto debe tener de maximo 1000 caracteres ',
            'resumen.min' => 'El resumen es demasiado corto',
            'resumen.max' => 'El mensaje es demasiado largo, supera los 350 caracteres',
            'titulo.required' => 'El titullo es obligatorio',
            'titulo.min' => 'El titulo es demasiado corto',
            'titulo.max' => 'El titulo es demasiado largo, supera los 25 caracteres',




        ];
    
    private const RULES = [
            'titulo' => 'required|string|min:5|max:25',
            'texto' => 'required|string|min:400|max:1000',
            'resumen' => 'required|string|min:50|max:350',
        ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('noticia.index', [
        'noticias' => Noticia::with('comentarios')->get()
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('noticia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request): RedirectResponse
{
    $validator = Validator::make($request->all(), self::RULES, self::Messages);

    if ($validator->fails()) {
        return back()->withInput()->withErrors($validator);
    }

    try {
        Noticia::create($validator->validated());
    } catch (UniqueConstraintViolationException $e) {
        return back()->withInput()->withErrors([
            'error' => 'Ya existe una noticia con ese título.',
        ]);
    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'error' => 'No se ha podido crear la noticia.',
        ]);
    }

    return redirect()->route('noticia.index')->with('success', 'Se ha creado la noticia correctamente.');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticia $noticia)
    {
        return view('noticia.edit', ['noticia' => $noticia]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Noticia $noticia): RedirectResponse
{
    $validator = Validator::make($request->all(), self::RULES, self::Messages);

    if ($validator->fails()) {
        return back()->withInput()->withErrors($validator);
    }

    try {
        $noticia->update($validator->validated());
    } catch (UniqueConstraintViolationException $e) {
        return back()->withInput()->withErrors([
            'error' => 'Ya existe una noticia con ese título.',
        ]);
    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'error' => 'Error al editar la noticia.',
        ]);
    }

    return redirect()->route('noticia.index')->with('success', 'Noticia actualizada correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        try {
            $noticia->delete();
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'No se ha podido borrar la noticia.',
            ]);
        }

        return redirect()->route('noticia.index')->with('success', 'Se ha borrado la noticia.');
    }
    
}
