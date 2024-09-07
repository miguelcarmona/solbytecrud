@extends('layouts.myapp')

@section('title', 'Listado de Categorías')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3 header-title listado">
        <h1>Coches</h1>
        <div class="text-right d-flex buttons">
            @if(auth()->user()->isEditor()) <a href="{{ route('cars.create') }}" class="btn btn-primary mb-2">Nuevo</a> @endif
            <div class="dropdown" id="extra-buttons-compressed">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-gear"></i></a>
                <div class="dropdown-menu dropdown-menu-right   " aria-labelledby="dropdownMenuLink">
                    <a href="/api/cars" class="" target="_blank">Mostrar JSON</a>
                    <a href="{{ route('cars.exportCsv') }}" class="">Exportar CSV</a>
                </div>
            </div>      
            <div id="extra-buttons">
                <a href="/api/cars" class="btn btn-secondary mb-2" target="_blank">JSON</a>
                <a href="{{ route('cars.exportCsv') }}" class="btn btn-success mb-2">CSV</a>
            </div>
        </div>
    </div>
    
    <form id="carSearch" method="GET" action="{{ route('cars.index') }}">

    <div id="search-order-container">
        <div class="input-group">
            <!-- Input de búsqueda -->
            <input type="text" id="search_input_id" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
            
            <!-- Botón para borrar texto -->
            <div class="input-group-prepend">
                <button class="btn btn-secondary" type="button"><i class="fa-regular fa-trash-can"></i></button>
            </div>
            <!-- Botón de buscar -->
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
        <button id="order-button" class="btn btn-dark" type="button" data-toggle="collapse" data-target="#form_order" aria-controls="form_order" aria-expanded="false" aria-label="Toggle navigation">
            <img src="{{ asset('css/icons/order_icon.svg') }}" width="16" >
        </button>
    </div>
    
    <div class="navbar-collapse collapse" id="form_order">
        <div class="row form_order">
            <div class="col-md-6">
                <label for="sort">Ordenar por:</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>ID</option>
                    <option value="category_id" {{ request('sort') == 'category_id' ? 'selected' : '' }}>Categoría</option>
                    <option value="nombre" {{ request('sort') == 'nombre' ? 'selected' : '' }}>Marca</option>
                    <option value="modelo" {{ request('sort') == 'modelo' ? 'selected' : '' }}>Modelo</option>
                    <option value="matricula" {{ request('sort') == 'matricula' ? 'selected' : '' }}>Matrícula</option>
                    <option value="color" {{ request('sort') == 'color' ? 'selected' : '' }}>Color</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="direction">Orden:</label>
                <select name="direction" id="direction" class="form-control">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>
            </div>
        </div>
    </div>
    </form>
    
    <div style="height: 1rem;"></div>
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-hover car-list">
            <thead>
                <tr>
                    <th><a style="gap: 5px;" class="d-flex align-items-center" href="{{ route('cars.index', ['sort' => 'id', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                            @if ($sortColumn === 'id')
                            <i class="fa fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif <span>ID</span></a></th>
                    <th><a style="gap: 5px;" class="d-flex align-items-center" href="{{ route('cars.index', ['sort' => 'category_id ', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                        @if ($sortColumn === 'category_id')
                            <i class="fa fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif <span>Categoría</span></a></th>
                    <th><a style="gap: 5px;" class="d-flex align-items-center" href="{{ route('cars.index', ['sort' => 'nombre', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                        @if ($sortColumn === 'nombre')
                            <i class="fa fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif <span>Marca</span></a></th>
                    <th><a style="gap: 5px;" class="d-flex align-items-center" href="{{ route('cars.index', ['sort' => 'model', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                        @if ($sortColumn === 'model')
                            <i class="fa fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif <span>Modelo</span></a></th>
                    <th><a style="gap: 5px;" class="d-flex align-items-center" href="{{ route('cars.index', ['sort' => 'matricula', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                        @if ($sortColumn === 'matricula')
                            <i class="fa fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif <span>Matrícula</span></a></th>
                    <th><a style="gap: 5px;" class="d-flex align-items-center" href="{{ route('cars.index', ['sort' => 'color', 'direction' => $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                        @if ($sortColumn === 'color')
                            <i class="fa fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif <span>Color</span></a></th>
                    <th>Foto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td data-label="ID: ">{{ $car->id }}</td>
                    <td data-label="Categoría: ">{{ $car->category->name }}</td>
                    <td data-label="Marca: ">{{ $car->nombre }}</td>
                    <td data-label="Modelo: ">{{ $car->model }}</td>
                    <td data-label="Matrícula: ">{{ $car->matricula }}</td>
                    <td data-label="Color: ">{{ $car->color }}</td>
                    <td>@if($car->main_image)
                        <img src="{{ asset('storage/' . $car->main_image) }}" aria-img-modal alt="Imagen Principal" class="img-fluid" style="max-width: 300px;">
                    @endif</td>
                    <td class="text-right">
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info mb-1">Ver ficha</a>
                        @if(auth()->user()->isEditor())
                            <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-warning mb-1">Editar</a>
                            <button type="button" class="btn btn-danger btn-sm mb-1" data-car_id="{{ $car->id }}"
                                data-car_name="{{ $car->nombre }} {{ $car->model }} con matrícula {{ $car->matricula }}"
                                data-form_action="{{ route('cars.destroy', $car) }}"
                                data-toggle="modal" data-target="#modalDeleteCar">Eliminar</button>
                        @endif
                        <a href="/api/cars/{{ $car->id }}" class="btn btn-sm btn-secondary mb-1" target="_blank"    >JSON</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <form id="form-destroy" action="" method="POST" class="d-inline">
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
