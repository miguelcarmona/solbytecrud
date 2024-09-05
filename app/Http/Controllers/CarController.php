<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Orden
        $sortColumn = $request->input('sort', 'id'); // Columna por defecto es 'id'
        $sortDirection = $request->input('direction', 'asc'); // Dirección por defecto es 'asc'

        // Validar que la columna de ordenación es válida
        $validColumns = ['id', 'category_id', 'nombre', 'model', 'matricula', 'color'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'id'; // Valor por defecto si la columna no es válida
        }

        // Validar la dirección de ordenación
        $sortDirection = $sortDirection === 'desc' ? 'desc' : 'asc';



        // Obtener el término de búsqueda y dividirlo en palabras
        $searchTerm = $request->input('search', '');
        $searchTerms = array_filter(explode(' ', $searchTerm)); // Eliminar términos vacíos
        
        // Obtener las categorías para el filtro de búsqueda
        $categories = Category::all();

        // Consultar los coches aplicando los filtros
        $cars = Car::with('category')
            ->when($searchTerms, function ($query, $searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where(function ($query) use ($term) {
                        $query->where('nombre', 'like', "%{$term}%")
                            ->orWhere('model', 'like', "%{$term}%")
                            ->orWhere('matricula', 'like', "%{$term}%")
                            ->orWhere('color', 'like', "%{$term}%")
                            ->orWhereHas('category', function ($query) use ($term) {
                                $query->where('name', 'like', "%{$term}%");
                            });
                    });
                }
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);
            
        // Agregar los parámetros de búsqueda y ordenación a los enlaces de paginación
        $cars->appends([
            'search' => $searchTerm,
            'sort' => $sortColumn,
            'direction' => $sortDirection
        ]);

        return view('cars.index', compact('cars', 'sortColumn', 'sortDirection', 'searchTerm', 'categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('cars.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'nombre' => 'required|max:50',
            'model' => 'required|max:50',
            'matricula' => 'required|max:10|unique:cars',
            'color' => 'required|max:25',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $car = Car::create($request->except(['main_image', 'gallery_images']));

        // Save main image
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('cars', 'public');
            $car->main_image = $mainImagePath;
            $car->save();
        }

        // Save gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryImagePath = $image->store('cars/gallery', 'public');
                $car->images()->create(['image_path' => $galleryImagePath]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'Coche creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */     
    public function edit(Car $car)
    {
        $categories = Category::all();
//echo '<pre>'; print_r($car); exit;
        return view('cars.edit', compact('car', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'category_id' => 'required',
            'nombre' => 'required|max:50',
            'model' => 'required|max:50',   
//            'matricula' => 'required|max:10|uniq  ue:cars,matricula,' . $car->id,
            'matricula' => 'required|max:10|',
            'color' => 'required|max:25',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $car->update($request->except(['main_image', 'gallery_images']));

        // Update main image
        if ($request->hasFile('main_image')) {
            if ($car->main_image) {
                Storage::disk('public')->delete($car->main_image);
            }
            $mainImagePath = $request->file('main_image')->store('cars', 'public');
            $car->main_image = $mainImagePath;
            $car->save();
        }

        // Save gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryImagePath = $image->store('cars/gallery', 'public');
                $car->images()->create(['image_path' => $galleryImagePath]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'Coche actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        if ($car->main_image) {
            Storage::disk('public')->delete($car->main_image);
        }

        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Coche eliminado con éxito.');
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroyMainImage(Car $car)
    {
        if (!$car->main_image) {
            return response()->json(['error' => 'Este coche no tiene una imagen principal a eliminar.'], 404);
        }

        Storage::disk('public')->delete($car->main_image);
        
        $car->main_image = null;
        $car->save();

        return response()->json(['success' => 'Imagen principal eliminada correctamente']);
    }

    /**
     * Eliminar una imagen de la galería
     *
     */
    public function destroyGalleryImage(Car $car, CarImage $image)
    {
        if ($car->id !== $image ->car_id) {
            return response()->json(['error' => 'La imagen no pertenece al coche'], 403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => 'Imagen eliminada correctamente']);
    }


    /**
     * Export cars data to CSV.
     */
    public function exportCSV()
    {
        $cars = Car::with('category', 'images')->get();
        $csvData = [];
        $csvData[] = ['Categoría', 'Marca', 'Modelo', 'Matrícula', 'Color', 'Imagen Principal'];

        foreach ($cars as $car) {
            $csvData[] = [
                $car->category->name,
                $car->nombre,
                $car->model,
                $car->matricula,
                $car->color,
                $car->main_image ? asset('storage/' . $car->main_image) : 'N/A'
            ];
        }

        $filename = "cars_" . date('Ymd_His') . ".csv";
        $file = fopen(storage_path('app/public/' . $filename), 'w');

        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend(true);
    }
}
