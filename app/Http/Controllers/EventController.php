<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;       // <-- IMPORT NECESARIO
use Carbon\Carbon; 

class EventController extends Controller
{
    public function index(Request $request)
    {
        $sport = $request->query('sport'); // ?sport=futbol
        $query = Event::query();
        if($sport) $query->where('sport', $sport);
        $events = $query->orderBy('start_at','asc')->paginate(12);
        return view('events.index', compact('events','sport'));
    }

    public function bySport($sport)
    {
        $events = Event::where('sport',$sport)->orderBy('start_at')->paginate(12);
        return view('events.index', compact('events','sport'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function create()
    {
        return view('events.crear-evento');
    }

    public function store(Request $request)
    {
        // Validaci�n
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events,slug',
            'category' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:activo,inactivo,cerrado',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        // Subir imagen si existe
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('eventos', 'public');
        }

        // Crear registro en BD
        $evento = new \App\Models\Event();
        $evento->title = $request->title;
        $evento->slug = $request->slug;
        $evento->description = $request->description;
        $evento->category = $request->category;
        $evento->location = $request->location;
        $evento->start_at = $request->start_at;
        $evento->end_at = $request->end_at;
        $evento->image = $imagePath;
        $evento->status = $request->status;
        $evento->save();

        return redirect()->back()->with('success', 'El evento fue creado correctamente.');
    }

    



}

