@extends('layouts.header')

@section('content')

    <div class="container mt-5">
        @include('layouts.sidebar_cluster')
        @include('cluster.shared.submit_category')

        <div class="row">

            @include('cluster.shared.category_card')
        </div>
    </div>
@endsection
