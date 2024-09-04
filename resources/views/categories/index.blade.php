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
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    @endif
                    </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection