<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    protected $productos = [
        ['id' => 1, 'nombre' => 'Producto 1', 'precio' => 10.00],
        ['id' => 2, 'nombre' => 'Producto 2', 'precio' => 20.00],
        ['id' => 3, 'nombre' => 'Producto 3', 'precio' => 30.00],
    ];

    public function index()
    {
        return response()->json($this->productos);
    }

    public function show($id)
    {
        $producto = collect($this->productos)->firstWhere('id', $id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    public function store(Request $request)
    {
        $nuevoId = count($this->productos) + 1; // Asignar un nuevo ID
        $producto = [
            'id' => $nuevoId,
            'nombre' => $request->input('nombre'),
            'precio' => $request->input('precio'),
        ];
        
        $this->productos[] = $producto; // Agregar el nuevo producto al array

        return response()->json($producto, 201);
    }

    public function update(Request $request, $id)
    {
        $productoIndex = collect($this->productos)->search(fn ($producto) => $producto['id'] === $id);

        if ($productoIndex === false) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $this->productos[$productoIndex]['nombre'] = $request->input('nombre', $this->productos[$productoIndex]['nombre']);
        $this->productos[$productoIndex]['precio'] = $request->input('precio', $this->productos[$productoIndex]['precio']);

        return response()->json($this->productos[$productoIndex]);
    }

    public function destroy($id)
    {
        $productoIndex = collect($this->productos)->search(fn ($producto) => $producto['id'] === $id);

        if ($productoIndex === false) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        array_splice($this->productos, $productoIndex, 1); // Eliminar el producto del array

        return response()->json(null, 204);
    }
}

{
    //
}
