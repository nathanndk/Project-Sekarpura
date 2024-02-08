@section('content')
<ul class="today-agenda">
    <h5 class="agenda-heading">Today's Agenda</h5>
    @foreach($todayEvents as $event)
        <li class="event-list-item" data-event-id="{{ $event->id }}" style="background-color: {{ $colors[array_rand($colors)] }};"
            data-eventid="{{ $event->id }}"
            data-title="{{ $event->title }}"
            data-description="{{ $event->description ? $event->description : '-' }}"
            data-start-time="{{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format('l, d/m/Y H:i:s') }}"
            data-end-time="{{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('l, d/m/Y H:i:s') }}"
            data-created_at="{{ \Carbon\Carbon::parse($event->created_at)->locale('id')->format('l, d/m/Y H:i:s') }}"
            data-created_by="{{ $event->created_by }}">
            <i class="bi bi-calendar-event"></i> {{ $event->title }}<br>
            <i class="bi bi-bookmark-check"></i>
                @if($event->description)
                    {{ $event->description }}
                @else
                    -
                @endif
            <br>
            <i class="bi bi-alarm"></i> {{ \Carbon\Carbon::parse($event->start_time)->locale('id')->format('l, d/m/Y H:i:s') }} -
                @if(\Carbon\Carbon::parse($event->start_time)->format('Y-m-d') !== \Carbon\Carbon::parse($event->end_time)->format('Y-m-d'))
                    {{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('l, d/m/Y H:i:s') }}
                @else
                    {{ \Carbon\Carbon::parse($event->end_time)->locale('id')->format('H:i:s') }}
                @endif
        </li>
    @endforeach
</ul>
@endsection
