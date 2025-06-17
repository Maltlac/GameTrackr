<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name'
        ]);

        $genre = Genre::create($validated);
        return response()->json($genre, 201);
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name,' . $genre->id_genre . ',id_genre'
        ]);
        $genre->update($validated);
        return response()->json($genre);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
