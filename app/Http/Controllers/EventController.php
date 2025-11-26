<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

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
}
