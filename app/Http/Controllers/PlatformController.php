<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platform;

class PlatformController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:platforms,name'
        ]);

        $platform = Platform::create($validated);
        return response()->json($platform, 201);
    }

    public function update(Request $request, Platform $platform)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:platforms,name,' . $platform->id_platform . ',id_platform'
        ]);
        $platform->update($validated);
        return response()->json($platform);
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
