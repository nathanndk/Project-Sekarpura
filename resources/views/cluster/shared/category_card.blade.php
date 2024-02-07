@foreach($threadCategories as $category)
    <div class="col-md-4 mb-4">
        <a href="{{ route('category.show', $category->id) }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title items-center">{{ $category->category }}</h5>
                </div>
            </div>
        </a>
    </div>

    <a class="mx-2" href="{{ route('category.edit', $category->id) }}"> Edit </a>

    @if ($editing ?? false)
        <form action="{{ route('category.update', $category->id) }}" method="post">
            @csrf
            @method('put')
            <div class="mb-3">
                <textarea class="form-control" id="category" name="category" rows="3">{{ $category->category }}</textarea>
                @error('category')
                    <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn btn-dark"> Update </button>
            </div>
        </form>
    @endif
@endforeach
