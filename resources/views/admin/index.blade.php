@php
    $forum_type_id = request()->get('forum_type_id');
@endphp

@extends('layouts.header')

@section('content')
<div class="container py-4">
    <div class="row">
 @include('layouts.sidebar_approval')
        <div class="col-lg-6">
            @include('shared.success_message')
            {{-- hilangkan tombol submit thread jika role admin --}}
            @guest
            <h4 class="text-center">Login to share your ideas</h4>
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
        </div> <!-- End Main Content -->

        <div class="col-lg-3"> <!-- Sidebar -->
            @include('shared.search_bar_approval')
        </div> <!-- End Sidebar -->
    </div>
</div>
@endsection
