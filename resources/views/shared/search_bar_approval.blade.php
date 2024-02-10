<div class="card">
    <div class="card-header pb-0 border-0">
        <h5 class="">Search</h5>
    </div>
    <div class="card-body">
        <form action="{{ route ('admin.approval')}}" method="GET">
            <input value="{{request('search', '')}}" name="search" placeholder="..." class="form-control w-100" type="text" id="search">
            <div class="mb-3 d-none">
                <label for="forum_type_id" class="form-label">forum_type_id</label>
                <input type="hidden" class="form-control" id="forum_type_id" name="forum_type_id" value="{{$forum_type_id}}">
            </div>
            <button class="btn btn-dark mt-2"> Search</button>
        </form>
    </div>
</div>
