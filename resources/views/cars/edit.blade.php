@extends('layouts.myapp')

@section('title', 'Editar Coche')

@section('content')
    <h1>Editar Coche</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}/{{$car->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Seleccionar Categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $car->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nombre">Marca</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $car->nombre) }}" required>
        </div>

        <div class="form-group">
            <label for="model">Modelo</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ old('model', $car->model) }}" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" id="matricula" class="form-control" value="{{ old('matricula', $car->matricula) }}" required>
        </div>

        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color', $car->color) }}" required>
        </div>

        <div class="form-group images mt-5 main_image">
            <h4>Imagen principal:</h3>
            @if($car->main_image)
                <figure class="" id="image-{{ $car->id }}">
                    <img aria-img-delete src="{{ asset('storage/' . $car->main_image) }}" alt="Imagen principal">
                    <figcaption><button type="button" style="width: 100%;" class="btn btn-danger btn-sm" data-car_id="{{ $car->id }}" data-image_id="null" data-image_src="{{ asset('storage/' . $car->main_image) }}" data-toggle="modal" data-target="#modalDeleteImage">Eliminar imagen</button></figcaption>
                    <!-- onclick="carDeleteImage({{$car->id}},false)" -->
                </figure>
            @else
                <p style="padding: 5%;">Sin imagen</p>
            @endif
        </div>

        <div class="form-group">
            <div>
                <label for="main_image">Subir imagen principal</label>
                <input type="file" name="main_image" id="main_image" class="form-control">
            </div>
        </div>

        <div class="form-group mt-5">
            <h4>Galería:</h3>
            <div class="gallery">
                @foreach($car->images as $image)
                <figure class="border" id="image-{{ $car->id }}-{{ $image->id }}">
                    <img aria-img-delete src="{{ asset('storage/' . $image->image_path) }}" alt="Imagen de galería">
                    <figcaption><button type="button" style="width: 100%;" class="btn btn-danger btn-sm" data-car_id="{{ $car->id }}" data-image_id="{{ $image->id }}" data-image_src="{{ asset('storage/' . $image->image_path) }}" data-toggle="modal" data-target="#modalDeleteImage" >Eliminar imagen</button></figcaption>
                    <!-- onclick="carDeleteImage({{ $car->id }},{{$image->id}})" -->
                </figure>
                    @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="gallery_images">Añadir imágenes a la galería</label>
            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple>
        </div>


        <br>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
        <a href="{{ route('cars.index') }}" class="btn btn-secondary">Cancelar y volver</a>
    </form>

    <!-- Modal delete image-->
    <div class="modal fade modalConfirm" id="modalDeleteImage" tabindex="-1" aria-labelledby="modalDeleteImage" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar imagen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5>¿Está seguro que desea eliminar esta imagen?</h5>
            <img src="">
            <div class="alert alert-warning text-center" role="alert">¡Precaución! Esta acción no se puede deshacer.</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">No, mantener</button>
            <button type="button" class="btn btn-warning" aria-borrar onclick="">Sí, borrar</button>
        </div>
        </div>
    </div>
    </div>

<script>



    function carDeleteImage(carId, imageId) {
        
        $('#modalDeleteImage').modal('hide');

        let url;
        let figureId;
        if( !imageId ) {
            url = `/cars/${carId}/destroymainimage`;
            figureId = `image-${carId}`;
        } else {
            url = `/cars/${carId}/images/${imageId}`;
            figureId = `image-${carId}-${imageId}`;
        }
    
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'  
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(figureId).remove();
            } else {
                alert('Error al eliminar la imagen');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
