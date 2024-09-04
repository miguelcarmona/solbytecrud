@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Coches</h2>
    <a href="{{ route('cars.create') }}" class="btn btn-primary mb-3">Nuevo Coche</a>
    <a href="/api/cars" class="btn btn-secondary mb-3">Mostrar JSON</a>
    <a href="{{ route('cars.exportCsv') }}" class="btn btn-success mb-3">Exportar CSV</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Matrícula</th>
                <th>Color</th>
                <th style="width: 300px;">Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
            <tr>
                <td>{{ $car->id }}</td>
                <td>{{ $car->category->name }}</td>
                <td>{{ $car->nombre }}</td>
                <td>{{ $car->model }}</td>
                <td>{{ $car->matricula }}</td>
                <td>{{ $car->color }}</td>
                <td>@if($car->main_image)
                    <img src="{{ asset('storage/' . $car->main_image) }}" aria-img-modal alt="Imagen Principal" class="img-fluid" style="max-width: 300px;">
                @endif</td>
                <td>
                    <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                    <a href="/api/cars/{{ $car->id }}" class="btn btn-sm btn-secondary">JSON</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cars->links() }}
</div>
@endsection
