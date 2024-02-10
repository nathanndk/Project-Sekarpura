<div class="card">
    <div class="card-body">
        <h4 class="card-title">Make a New Category</h4>
        <form action="{{ route('categories.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <textarea class="form-control" id="category" name="category" rows="3" placeholder="Enter Category"></textarea>
                @error('category')
                <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-dark">Create</button>
            </div>
        </form>
    </div>
</div>
