<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        return Event::withCount('interests')->get()->map(function ($event) use ($userId) {
            return [
                'id'            => $event->id,
                'title'         => $event->title,
                'description'   => $event->description,
                'image_url'     => $event->image ? asset('storage/' . $event->image) : null,
                'user_id'       => $event->user_id,
                'interested'    => $event->interests_count,
                'is_interested' => $userId ? $event->interests()->where('user_id', $userId)->exists() : false,
                'created_at'    => $event->created_at,
            ];
        });
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:10240'
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
        ]);

        return response()->json([
            'id'          => $event->id,
            'title'       => $event->title,
            'description' => $event->description,
            'image_url'   => $event->image ? asset('storage/' . $event->image) : null,
            'user_id'     => $event->user_id,
            'interested'  => 0,
            'is_interested' => false,
            'created_at'  => $event->created_at,
        ]);
    }

    public function interested($id)
    {
        $event = Event::findOrFail($id);
        $userId = Auth::id();

        $exists = $event->interests()->where('user_id', $userId)->exists();

        if ($exists) {
            $event->interests()->detach($userId);
        } else {
            $event->interests()->attach($userId);
        }

        return response()->json([
            'interested'    => $event->interests()->count(),
            'is_interested' => !$exists,
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $data = $request->only(['title', 'description']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $data['image'] = $path;
        }

        $event->update($data);

        return response()->json([
            'success' => true,
            'event'   => [
                'id'          => $event->id,
                'title'       => $event->title,
                'description' => $event->description,
                'image_url'   => $event->image ? asset('storage/' . $event->image) : null,
                'user_id'     => $event->user_id,
                'interested'  => $event->interests()->count(),
                'is_interested' => $event->interests()->where('user_id', Auth::id())->exists(),
                'created_at'  => $event->created_at,
            ]
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $event->delete();

        return response()->json(['success' => true]);
    }
}
