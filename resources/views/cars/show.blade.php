@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Coche</h1>

    <!-- Detalles del coche -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">{{ $car->nombre }} {{ $car->model }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $car->nombre }}</dd>

                <dt class="col-sm-3">Modelo</dt>
                <dd class="col-sm-9">{{ $car->model }}</dd>

                <dt class="col-sm-3">Categoría</dt>
                <dd class="col-sm-9">{{ $car->category->name }}</dd>

                <dt class="col-sm-3">Matrícula</dt>
                <dd class="col-sm-9">{{ $car->matricula }}</dd>

                <dt class="col-sm-3">Color</dt>
                <dd class="col-sm-9">{{ $car->color }}</dd>
            </dl>

            <!-- Imagen principal del coche -->
            @if($car->main_image)
                <div class="mb-4 images">
                    <h5>Imagen Principal</h5>
                    <a href="{{ asset('storage/' . $car->main_image) }}"><img src="{{ asset('storage/' . $car->main_image) }}" alt="Imagen Principal" class="img-fluid" style="max-width: 600px;"></a>
                </div>
            @endif

            <!-- Galería de imágenes -->
            @if($car->images->count())
                <div class="images">
                    <h5>Galería de Imágenes</h5>
                    <div class="row">
                        @foreach($car->images as $image)
                            <div class="col-md-3 mb-2">
                            <a href="{{ asset('storage/' . $image->image_path) }}"><img src="{{ asset('storage/' . $image->image_path) }}" alt="Imagen de Galería" class="img-fluid" style="max-width: 100%;"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('cars.index') }}" class="btn btn-secondary">Volver a la lista</a>
            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
</div>
@endsection
