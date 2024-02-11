<div class="container">
    <div class="row justify-content">
        @foreach($threadCategories as $category)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    @if ($editing ?? false)
                    <form action="{{ route('categories.update', $category->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <textarea class="form-control form-control-sm" style="height: auto; min-height: 38px;" id="category" name="category" rows="1">{{ $category->category }}</textarea>
                            @error('category')
                            <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark btn-sm">Update</button>
                        </div>
                    </form>
                    @else
                    <h5 class="card-title">{{ $category->category }}</h5>
                    <a class="btn btn-sm btn-dark" href="{{ route('categories.edit', $category->id) }}">Edit</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('categories.show', $category->id) }}">Show</a>

                    <form method="post" action="{{ route('categories.destroy', $category->id) }}"  class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">X</button>
                    </form>

                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
