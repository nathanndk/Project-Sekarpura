@extends('layouts.header')

@section('content')

<div class="container py-4">
    @include('layouts.sidebar_cluster')
    <div class="col-6">
        @include('shared.success_message')
        <div class="mt-3">
            @include('cluster.shared.submit_category')
        </div>
    </div>
</div>
<hr>
@include('cluster.shared.category_edit_card')
<hr>
</div>
@endsection
