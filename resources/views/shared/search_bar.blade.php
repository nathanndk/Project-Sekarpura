<div class="card">
    <div class="card-header pb-0 border-0">
        <h5 class="">Search</h5>
    </div>
    <div class="card-body">
        <form action="{{ route ('forum')}}" method="GET">
            <div class="input-group">
                <input value="{{request('search', '')}}" name="search" placeholder="..." class="form-control" type="text" id="search">
                <button class="btn btn-dark" type="submit">Search</button>
            </div>
            <div class="mb-3 d-none">
                <label for="forum_type_id" class="form-label">forum_type_id</label>
                <input type="hidden" class="form-control" id="forum_type_id" name="forum_type_id" value="{{$forum_type_id}}">
            </div>
        </form>
    </div>
</div>
