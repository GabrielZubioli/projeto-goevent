<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
        }

        $event = Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $path,
            'user_id'     => Auth::id(),
            'interested'  => 0
        ]);

        return response()->json($event);
    }

    public function interested($id)
    {
        $event = Event::findOrFail($id);
        $event->interested += 1;
        $event->save();

        return response()->json(['interested' => $event->interested]);
    }
}
