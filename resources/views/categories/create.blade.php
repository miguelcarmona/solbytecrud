@extends('layouts.myapp')

@section('title', 'Nueva Categoría')

@section('content')
    <h1>Nueva Categoría</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection
