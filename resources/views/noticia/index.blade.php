@extends('template.base')

@section('content')
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->has('error'))
                <div class="alert alert-danger mb-4">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-secondary" href="{{ route('noticia.create') }}">Crear noticia</a>
            </div>

            @foreach($noticias as $noticia)
                <div class="post-preview">

                    <h2 class="post-title">{{ $noticia->titulo }}</h2>
                    <h3 class="post-subtitle">{{ $noticia->resumen }}</h3>
                    <p class="post-meta">
                        {{ $noticia->texto }}
                    </p>

                    <div class="d-flex gap-2 my-2">
                        <a href="{{ route('noticia.edit', $noticia->id) }}" class="btn btn-secondary btn-sm">Edit</a>

                        @if($noticia->comentarios->isEmpty() && $noticia->created_at->diffInMinutes(now()) <= 20)
                            <form class="confirm-dialog" data-message="la noticia &quot;{{ $noticia->titulo }}&quot;" action="{{ route('noticia.destroy', $noticia->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif

                        <a href="{{ route('comentario.create', ['noticia_id' => $noticia->id]) }}" class="btn btn-outline-primary btn-sm">Crear comentario</a>
                    </div>

                    @if($noticia->comentarios && $noticia->comentarios->count() > 0)
                        <div class="mt-3 p-3 bg-light rounded">
                            <h5 class="mb-3">Comentarios:</h5>
                            @foreach($noticia->comentarios as $comentario)
                                <div class="border-bottom pb-2 mb-2">
                                    <p class="mb-1">{{ $comentario->mensaje }}</p>
                                    <small class="text-muted">Valoración: {{ $comentario->valoracion }}/5★</small>

                                    @if($comentario->created_at->diffInMinutes(now()) <= 5)
                                        <div class="d-flex gap-2 mt-1">
                                            <a href="{{ route('comentario.edit', $comentario->id) }}" class="btn btn-sm btn-link p-0 text-secondary">Editar</a>
                                            <form class="confirm-dialog" data-message="este comentario" action="{{ route('comentario.destroy', $comentario->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-link p-0 text-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
                <hr class="my-4" />
            @endforeach

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('form.confirm-dialog').forEach(
        form => {
            form.addEventListener('submit', e => {
                const message = '¿Seguro que quieres borrar ' + form.dataset.message + '?';
                if(!confirm(message)){
                    e.preventDefault();
                }
            });
        }
    );
</script>
@endsection