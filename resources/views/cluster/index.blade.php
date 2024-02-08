@extends('layouts.header')

@section('content')

<div class="row">
    @include('layouts.sidebar_cluster')
    <div class="col-6">
        @include('shared.success_message')
        <div class="mt-3">
            @include('cluster.shared.submit_category')
        </div>


        @include('cluster.shared.category_card')
        <hr>
    </div>
</div>
@endsection
