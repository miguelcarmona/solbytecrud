@extends('layouts.myapp')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3 header-title">
        <h1>{{ $car->nombre }} {{ $car->model }}</h1>
        <div class="buttons">
            <a href="{{ route('cars.index') }}" class="btn btn-secondary">Volver</a>
            @if(auth()->user()->isEditor()) <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Editar</a> @endif
        </div>
    </div>


    <!-- Detalles del coche -->
    <div class="">
        <dl class="row">
            <dt class="col-sm-3">Marca</dt>
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
                <img src="{{ asset('storage/' . $car->main_image) }}" aria-img-modal alt="Imagen Principal" class="img-fluid" style="max-width: 100%;">
            </div>
        @endif

        <!-- Galería de imágenes -->
        @if($car->images->count())
            <div class="images gallery">
                <h5 style="display: block;">Galería de Imágenes</h5>
                <div class="row">
                    @foreach($car->images as $image)
                        <div class="col-md-3 mb-2">
                            <img src="{{ asset('storage/' . $image->image_path) }}" aria-img-modal alt="Imagen de Galería" class="img-fluid" style="max-width: 100%;">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
