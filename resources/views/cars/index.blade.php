@extends('layouts.myapp')

@section('title', 'Listado de Categorías')

@section('content')
    <div class="d-flex align-items-center justify-content-around mb-3">
        <h1>Coches</h1>
        <div class="text-center">
            @if(auth()->user()->isEditor()) <a href="{{ route('cars.create') }}" class="btn btn-primary mb-2">Nuevo Coche</a> @endif
            <a href="/api/cars" class="btn btn-secondary mb-2">Mostrar JSON</a>
            <a href="{{ route('cars.exportCsv') }}" class="btn btn-success mb-2">Exportar CSV</a>
        </div>
    </div>
    <form method="GET" action="{{ route('cars.index') }}">
        <div class="mb-4 d-flex justify-content-center" style="width: 80%; margin: auto;">
            
                <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}" style="margin-right: 5px;">
                <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <div class="container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th><a href="{{ route('cars.index', ['sort' => 'id', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">ID</a></th>
                <th><a href="{{ route('cars.index', ['sort' => 'category_id ', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Categoría</a></th>
                <th><a href="{{ route('cars.index', ['sort' => 'nombre', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Marca</a></th>
                <th><a href="{{ route('cars.index', ['sort' => 'model', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Modelo</a></th>
                <th><a href="{{ route('cars.index', ['sort' => 'matricula', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Matrícula</a></th>
                <th><a href="{{ route('cars.index', ['sort' => 'color', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Color</a></th>
                <th style="width: 300px;"><a href="{{ route('cars.index', ['sort' => 'id', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Foto</a></th>
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
                    <img src="{{ asset('storage/' . $car->main_image) }}"        aria-img-modal alt="Imagen Principal" class="img-fluid" style="max-width: 300px;">
                @endif</td>
                <td>
                    <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info mb-1">Ver</a>
                    @if(auth()->user()->isEditor())
                        <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-warning mb-1">Editar</a>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-car_id="{{ $car->id }}"
                            data-car_name="{{ $car->nombre }} {{ $car->model }} con matrícula {{ $car->matricula }}"
                            data-form_action="{{ route('cars.destroy', $car) }}"
                            data-toggle="modal" data-target="#modalDeleteCar">Eliminar</button>
                    @endif
                    <a href="/api/cars/{{ $car->id }}" class="btn btn-sm btn-secondary mb-1">JSON</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form id="form-car-destroy" action="" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
    </form>


    {{ $cars->links() }}
</div>


    <!-- Modal delete car-->
    <div class="modal fade modalConfirm" id="modalDeleteCar" tabindex="-1" aria-labelledby="modalDeleteCar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar Coche</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5>¿Está seguro que desea eliminar este coche?</h5>
            <p></p>
            <div class="alert alert-warning text-center" role="alert">¡Precaución! Esta acción no se puede deshacer.</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">No, mantener</button>
            <button type="button" class="btn btn-warning" aria-borrar onclick="">Sí, borrar</button>
        </div>
        </div>
    </div>
    </div>

@endsection
