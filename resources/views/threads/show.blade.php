@php
    $forum_type_id = request()->get('forum_type_id');
@endphp

@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row">
 @include('layouts.sidebar')
        <div class="col-lg-6">
            @include('shared.success_message')
            <div class="mt-3">
                @include('threads.shared.thread_card')
                @include('threads.shared.comment_box')
            </div>
        </div>
        <div class="col-lg-3"> <!-- Sidebar -->
            @include('shared.search_bar')
            @include('forum.shared.category')
        </div>
    </div>
</div>
@endsection
