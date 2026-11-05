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

            <form action="{{ route('comentario.update', $comentario) }}" method="POST">
                @method('put')
                @csrf

                <input type="hidden" name="noticia_id" value="{{ old('noticia_id', $comentario->noticia_id) }}">

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control @error('mensaje') is-invalid @enderror" 
                              id="mensaje" name="mensaje" rows="4" required maxlength="200" 
                              placeholder="Introduce el mensaje">{{ old('mensaje', $comentario->mensaje) }}</textarea>
                    @error('mensaje')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="valoracion" class="form-label">Valoración</label>
                    <select class="form-select @error('valoracion') is-invalid @enderror" id="valoracion" name="valoracion" required>
                        <option value="" disabled>Selecciona una opción</option>
                        @foreach(['1', '2', '3', '4', '5'] as $val)
                            <option value="{{ $val }}" @selected(old('valoracion', $comentario->valoracion) == $val)>
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

                <button type="submit" class="btn btn-secondary">
                    Editar comentario
                </button>
            </form>
        </div>
    </div>
</div>
@endsection