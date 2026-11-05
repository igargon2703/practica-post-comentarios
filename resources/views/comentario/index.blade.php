@extends('template.base')

@section('content')
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            {{-- Mensajes de confirmación o error --}}
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

            @foreach($comentarios as $comentario)
                <div class="post-preview">
                    <p class="post-meta">
                        {{ $comentario->mensaje }}
                    </p>
                    <p class="small text-muted">
                        Valoración: <strong>{{ $comentario->valoracion }} / 5★</strong>
                    </p>

                    <div class="d-flex gap-2 my-2">
                        <a href="{{ route('comentario.edit', ['comentario' => $comentario->id]) }}" class="btn btn-secondary btn-sm">Edit</a>

                        <form class="confirm-dialog" action="{{ route('comentario.destroy', ['comentario' => $comentario->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
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
                const message = '¿Seguro que quieres borrar este comentario?';
                if(!confirm(message)){
                    e.preventDefault();
                }
            });
        }
    );
</script>
@endsection