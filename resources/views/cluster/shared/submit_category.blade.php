@auth
<h4> Make a New Category </h4>
<div class="row">
    <form action="{{ route('category.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <textarea class="form-control" id="category" name="category" rows="3"></textarea>
            @error('category')
            <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
            @enderror
        </div>
        <div class="">
            <button type="submit" class="btn btn-dark"> Create </button>
        </div>
    </form>
</div>
<hr>
@endauth
@guest
<h4>Login to share your ideas</h4>
@endguest
