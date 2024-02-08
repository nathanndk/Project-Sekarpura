<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $data = $this->getEventsData();

        return view('event.dashboard', $data);
    }

    public function getEventsData()
    {
        $events = array();
        $files = array();
        $colors = ['#3498DB', '#2ECC71', '#EB6557', '#FABC5A', '#C983E6', '#6AA1D9', '#1ABC9C', '#D9534F', '#F57C36', '#8E44AD'];

        $bookings = Event::all();
        $attachments = Attachment::all();

        foreach ($bookings as $key => $booking) {
            $events[] = [
                'id' => $booking->id,
                'title' => $booking->title,
                'description' => $booking->description,
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'created_at' => $booking->created_at,
                'created_by' => $booking->created_by,
                'color' => $colors[$key % count($colors)],
            ];
        }

        foreach ($attachments as $key => $attachment) {
            $files[] = [
                'id' => $attachment->id,
                'file' => $attachment->file,
                'path' => $attachment->path,
                'created_at' => $attachment->created_at,
                'created_by' => $attachment->created_by,
                'user_id' => $attachment->user_id,
                'events_id' => $attachment->events_id,
            ];
        }

        $todayEvents = Event::whereDate('start_time', now())->get();
        $todayEvents = $todayEvents->sortBy('start_time')->sortBy('end_time');

        $upcomingEvents = Event::where('start_time', '>=', now()->addDays(1)->startOfDay())
            ->where('start_time', '<=', now()->addDays(2)->endOfDay())
            ->get();
        $upcomingEvents = $upcomingEvents->sortBy('start_time')->sortBy('end_time');

        $now = now();
        $startTwoMonthsBefore = $now->copy()->subMonths(2)->startOfMonth();
        $endTwoMonthsAfter = $now->copy()->addMonths(2)->endOfMonth();

        $attachmentOptions = Event::whereBetween('start_time', [$startTwoMonthsBefore, $endTwoMonthsAfter])
            ->get()
            ->sortBy('start_time')
            ->sortBy('end_time');

        return [
            'events' => $events,
            'files' => $files,
            'todayEvents' => $todayEvents,
            'upcomingEvents' => $upcomingEvents,
            'attachmentOptions' => $attachmentOptions,
            'colors' => $colors,
        ];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:30',
            'description' => 'nullable|max:50',
            'startTime' => 'required|date_format:Y-m-d\TH:i',
            'endTime' => 'required|date_format:Y-m-d\TH:i|after:startTime',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $event = Event::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_time' => $request->input('startTime'),
            'end_time' => $request->input('endTime'),
            'created_at' => now(),
            'created_by' => Auth::user()->name,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json(['message' => 'Event Created Successfully', 'event' => $event]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:events,id',
            'title' => 'required|max:30',
            'description' => 'nullable|max:50',
            'startTime' => 'required|date_format:Y-m-d\TH:i',
            'endTime' => 'required|date_format:Y-m-d\TH:i|after:startTime',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $event = Event::find($request->input('id'));

        if (!$event) {
            return response()->json(['error' => 'Event not found.'], 404);
        }

        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->start_time = $request->input('startTime');
        $event->end_time = $request->input('endTime');
        $event->updated_at = now();
        $event->updated_by = Auth::user()->id;
        $event->save();

        return response()->json(['message' => 'Event Updated Successfully', 'event' => $event]);
    }

    public function destroy(Event $event)
    {
        if ($event) {
            $event->delete();
            return response()->json(['message' => 'Event Deleted Successfully']);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }

    public function dragEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eventId' => 'required|exists:events,id',
            'newStart' => 'required|date_format:Y-m-d H:i:s',
            'newEnd' => 'required|date_format:Y-m-d H:i:s|after:newStart',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $eventId = $request->input('eventId');
        $newStart = $request->input('newStart');
        $newEnd = $request->input('newEnd');

        $event = Event::findOrFail($eventId);
        $event->start_time = $newStart;
        $event->end_time = $newEnd;
        $event->updated_at = now();
        $event->updated_by = Auth::user()->id;
        $event->save();

        return response()->json(['message' => 'Event Updated Successfully']);
    }

}
