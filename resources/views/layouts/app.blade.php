<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplicación CRUD')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    /* Galería de imágenes */
    .gallery {
        display: flex;
        justify-content: flex-start;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 10px
    }

    .main_image figure, .gallery figure {
        padding: 5px;
        margin: 0px;
        text-align: center;
    }

    .main_image img, .gallery img {
        max-width: 100%;
        height: auto;
        vertical-align: bottom;
    }

    .main_image figcaption, .gallery figcaption {
        margin-top: 8px;
        font-size: 14px;
        color: #666;
    }

    .images img {
        border: 1px solid #dee2e6;
        padding: 5px;
        max-width: 100%;
    }

    nav>div:first-child {
        display: none;
    }

    nav svg{
        width: 20px;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-nombre" href="#">CRUD App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cars.index') }}">Coches</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
    <br>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
