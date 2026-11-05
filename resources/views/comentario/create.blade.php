@extends('template.base')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-6 mx-auto">

            @if($errors->has('error'))
                <div class="alert alert-danger mb-3">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <form action="{{ route('comentario.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="noticia_id" class="form-label">Noticia</label>
                    <select class="form-select @error('noticia_id') is-invalid @enderror" id="noticia_id" name="noticia_id" required>
                        <option value="" disabled @selected(!old('noticia_id', $noticia_id))>Selecciona una noticia</option>
                        @foreach($noticias as $noticiaItem)
                            <option value="{{ $noticiaItem->id }}" @selected(old('noticia_id', $noticia_id) == $noticiaItem->id)>
                                {{ $noticiaItem->titulo }}
                            </option>
                        @endforeach
                    </select>
                    @error('noticia_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control @error('mensaje') is-invalid @enderror" 
                              id="mensaje" name="mensaje" rows="4" required maxlength="200" 
                              placeholder="Introduce el mensaje del comentario">{{ old('mensaje') }}</textarea>
                    @error('mensaje')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="valoracion" class="form-label">Valoración</label>
                    <select class="form-select @error('valoracion') is-invalid @enderror" id="valoracion" name="valoracion" required>
                        <option value="" disabled @selected(old('valoracion') == '')>Selecciona una valoración</option>
                        @foreach(['1', '2', '3', '4', '5'] as $val)
                            <option value="{{ $val }}" @selected(old('valoracion') == $val)>
                                {{ $val }} @if($val == '1') estrella @else estrellas @endif
                            </option>
                        @endforeach
                    </select>
                    @error('valoracion')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Crear comentario
                </button>
            </form>
        </div>
    </div>
</div>
@endsection