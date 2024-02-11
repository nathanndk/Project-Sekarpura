@extends('layouts.header')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $threadCategory->category }}</h5>
                <p class="card-text">Threads in this category:</p>

                @if($threads && count($threads) > 0)
                    <ul>
                        @foreach($threads as $thread)
                            <li>
                                <a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No threads in this category.</p>
                @endif
            </div>
        </div>


@endsection
