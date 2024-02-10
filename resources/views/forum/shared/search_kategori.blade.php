@php
    $forum_type_id = request()->get('forum_type_id');
@endphp

@extends('layouts.header')

@section('content')
    <div class="container py-4">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-6">
            <div class="mt-3">
                <h1>Search Results</h1>

                @foreach($threads as $thread)
                @include('threads.shared.thread_card', ['thread' => $thread])
                @endforeach
            </div>
        <hr>
        </div>
        <div class="col-3">
            @include('shared.search_bar')
            @include('forum.shared.category')
        </div>
    </div>
@endsection
