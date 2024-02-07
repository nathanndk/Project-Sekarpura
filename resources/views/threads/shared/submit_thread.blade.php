@extends('layouts.header')

@section('content')
    <div class="container py-4">
        <h4>Share Your Thread</h4>
        <hr>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('threads.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        @error('title')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Description</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        @error('content')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Thread Category</label>
                        <select name="thread_category_id" id="category_id" required class="form-control" style="border: 1px solid;">
                            <option value="">Select Category</option>
                            @foreach ($threadCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                            <option value="custom">Custom</option>
                        </select>


                        <div id="custom_category_form" style="display: none;">
                            <label for="custom_thread_category" class="form-label">Custom Category</label>
                            <input type="text" class="form-control" id="custom_thread_category" name="custom_thread_category">
                        </div>
                        @error('thread_category_id')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('category_id').addEventListener('change', function () {
                            var customForm = document.getElementById('custom_category_form');
                            if (this.value === 'custom') {
                                customForm.style.display = 'block';
                                customForm.querySelector('input').setAttribute('required', 'required');
                            } else {
                                customForm.style.display = 'none';
                                customForm.querySelector('input').removeAttribute('required');
                            }
                        });
                    </script>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-dark">Create Thread</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
@endsection
