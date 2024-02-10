@if ($upcomingEvents->isNotEmpty())
    <ul class="upcoming-agenda">
        <h5 class="agenda-heading">Upcoming Events</h5>
        <hr id="attachmentBorder1">
        @foreach($upcomingEvents as $event)
            <li class="event-list-item" data-event-id="{{ $event->id }}" style="background-color: {{ $colors[array_rand($colors)] }};"
                data-eventid="{{ $event->id }}"
                data-title="{{ $event->title }}"
                data-description="{{ $event->description ? $event->description : '-' }}"
                data-start-time="{{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format('l, d/m/Y H:i:s') }}"
                data-end-time="{{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('l, d/m/Y H:i:s') }}"
                data-created_at="{{ \Carbon\Carbon::parse($event->created_at)->locale('id')->format('l, d/m/Y H:i:s') }}"
                data-created_by="{{ $event->created_by }}">
                <img src="{{ asset('images/events.png') }}" class="events-image"> {{ $event->title }}<br>
                <img src="{{ asset('images/description.png') }}" class="description-image">
                    @if($event->description)
                        {{ $event->description }}
                    @else
                        -
                    @endif
                <br>
                <img src="{{ asset('images/clock.png') }}" class="clock-image"></i> {{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format(('l, d F Y')) }} at {{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format('H:i') }}<br>
                <img src="{{ asset('images/person.png') }}" class="person-image"> {{ $event->created_by }}
            </li>
        @endforeach
    </ul>
    @else
    <ul class="today-agenda" style="margin-top: 20px;">
        <h5 class="agenda-heading">Upcoming Events</h5>
        <hr id="attachmentBorder1">
        <img src="{{ asset('images/noevents.png') }}" class="noevents-image">
        <p class="no-event-message">No Upcoming Events Found!</i></p>
    </ul>
@endif
