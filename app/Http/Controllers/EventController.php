<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function media(string $path)
    {
        $path = ltrim($path, '/');

        // Evita path traversal y rutas inválidas.
        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }

    public function index(Request $request)
    {
        // Ahora filtramos por category (porque sport NO existe en tu tabla)
        $category = $request->query('category');

        $query = Event::query();

        if (!empty($category)) {
            $query->where('category', $category);
        }

        $events = $query->orderBy('start_at', 'asc')->paginate(12);

        $sponsors = Sponsor::orderBy('created_at', 'desc')->take(4)->get();

        return view('principal.evento', compact('events', 'category', 'sponsors'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function listado()
    {
        // Mejor paginado (si quieres dejar all(), puedes, pero esto es más sano)
        $eventos = Event::orderBy('start_at', 'desc')->paginate(20);

        return view('events.listado-eventos', compact('eventos'));
    }

    public function create()
    {
        return view('events.crear-evento');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255', // puede venir vacío
            'category'    => 'required|string',
            'start_at'    => 'required|date',
            'end_at'      => 'nullable|date|after_or_equal:start_at',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:activo,inactivo,cerrado',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        // ✅ Slug limpio + único (desde slug o title)
        $baseSlug = Str::slug($request->slug ?: $request->title);
        $slug = $baseSlug;
        $i = 2;

        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        // ✅ Subir imagen si existe
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('eventos', 'public');
        }

        // ✅ Guardar en BD
        $evento = new Event();
        $evento->title       = $request->title;
        $evento->slug        = $slug;
        $evento->description = $request->description;
        $evento->category    = $request->category;
        $evento->location    = $request->location;
        $evento->start_at    = $request->start_at;
        $evento->end_at      = $request->end_at;
        $evento->image       = $imagePath;
        $evento->status      = $request->status;
        $evento->save();

        return redirect()->back()->with('success', 'El evento fue creado correctamente.');
    }

    public function destroy(Request $request, Event $event)
    {
        // ✅ Borrar imagen del storage si existe
        if (!empty($event->image) && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        if ($request->filled('redirect_to')) {
            return redirect()->to($request->input('redirect_to'))
                ->with('success', 'Evento eliminado correctamente.');
        }

        return redirect()->back()->with('success', 'Evento eliminado correctamente.');
    }
    public function eliminarEvento(Request $request, $id)
{
    $event = Event::findOrFail($id);
    $event->delete(); // Eliminar evento

    // Volver a la misma vista con un mensaje flash
    return back()->with('success', 'Evento eliminado correctamente.');
}
}
