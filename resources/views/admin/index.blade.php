@php
    $forum_type_id = request()->get('forum_type_id');
@endphp

@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row">
        @include('layouts.sidebar_approval')
        <div class="col-6">
            @include('shared.success_message')
            @guest
            <h4>Login to share your ideas</h4>
            @endguest
            @forelse ($threads as $thread)
            <div class="mt-3">
                @include('admin.shared.approval')
            </div>
            @empty
            <p class="text-center my-3">No results found</p>
            @endforelse
            <div class="mt-3">
                {{ $threads->withQueryString()->links() }}
            </div>
        </div>
        <div class="col-3">
            @include('shared.search_bar_approval')
            @include('forum.shared.category')
        </div>
    </div>
</div>
@endsection
