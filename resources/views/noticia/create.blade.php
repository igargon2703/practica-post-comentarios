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

            <form action="{{ route('noticia.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                           value="{{ old('titulo') }}" id="titulo" name="titulo" required maxlength="25" 
                           placeholder="Introduce el título de la noticia">
                    @error('titulo')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="resumen" class="form-label">Resumen</label>
                    <input type="text" class="form-control @error('resumen') is-invalid @enderror" 
                           value="{{ old('resumen') }}" id="resumen" name="resumen" required maxlength="350" 
                           placeholder="Introduce el resumen de la noticia">
                    @error('resumen')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="texto" class="form-label">Texto</label>
                    <textarea class="form-control @error('texto') is-invalid @enderror" 
                              id="texto" name="texto" rows="5" required maxlength="1000" 
                              placeholder="Introduce el texto de la noticia">{{ old('texto') }}</textarea>
                    @error('texto')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Crear noticia
                </button>
            </form>
        </div>
    </div>
</div>
@endsection