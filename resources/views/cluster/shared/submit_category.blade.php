<div class="container">
    <div class="row">
        <div class="col">
            <h4>Make a New Category</h4>
            <form action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" id="category" name="category" rows="3"></textarea>
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
</div>
<hr>
