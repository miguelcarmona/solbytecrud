@extends('layouts.myapp')

@section('title', 'Crear Coche')

@section('content')
    <h1>Crear Coche</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Seleccionar Categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nombre">Marca</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" id="matricula" class="form-control" value="{{ old('matricula') }}" required>
        </div>

        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}" required>
        </div>

        <div class="form-group">
            <label for="main_image">Imagen Principal</label>
            <input type="file" name="main_image" id="main_image" class="form-control">
        </div>

        <div class="form-group">
            <label for="gallery_images">Galería de Imágenes</label>
            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('cars.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection
