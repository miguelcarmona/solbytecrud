@extends('layouts.myapp')

@section('title', 'Listado de Categorías')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1>Listado de Categorías</h1>
        @if(auth()->user()->isEditor())
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Nueva Categoría</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                @if(auth()->user()->isEditor())
                    <th>Acciones</th>
                @endif
                </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    @if(auth()->user()->isEditor())
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                            
                            <button type="button" class="btn btn-danger btn-sm mb-1" data-category_id="{{ $category->id }}"
                            data-car_name="{{ $category->name }}  "
                            data-form_action="{{ route('categories.destroy', $category->id) }}"
                            data-toggle="modal" data-target="#modalDeleteCategory">Eliminar</button>
                        </td>
                    @endif
                    </tr>
            @endforeach
        </tbody>
    </table>
    <form id="form-destroy" action="" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
    </form>

    {{ $categories->links() }}

    <!-- Modal delete car-->
    <div class="modal fade modalConfirm" id="modalDeleteCategory" tabindex="-1" aria-labelledby="modalDeleteCategory" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar categoría</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5>¿Está seguro que desea eliminar esta categoría?</h5>
            <p></p>
            <div class="alert alert-warning text-center" role="alert">¡Precaución! Esta acción no se puede deshacer.</div>
            <div class="alert alert-danger   text-center mt-4" role="alert">¡Alerta! Se eliminarán todos los coches de esta categoría.</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">No, mantener</button>
            <button type="button" class="btn btn-warning" aria-borrar onclick="">Sí, borrar</button>
        </div>
        </div>
    </div>
    </div>

@endsection