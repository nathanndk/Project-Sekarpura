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
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        @error('content')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file">
                        @error('file')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="thread_category_id" class="form-label">Thread Category</label>
                        <select class="form-select" id="thread_category_id" name="thread_category_id" required>
                            <option value="1">Book</option>
                            <option value="2">Sport</option>
                            <option value="custom">Custom</option>
                        </select>
                        <input type="text" class="form-control mt-2" id="custom_thread_category" name="custom_thread_category" style="display: none;">
                        @error('thread_category_id')
                        <span class="d-block fs-6 text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <script>
                        document.getElementById('thread_category_id').addEventListener('change', function () {
                            var customInput = document.getElementById('custom_thread_category');
                            if (this.value === 'custom') {
                                customInput.style.display = 'block';
                                customInput.setAttribute('required', 'required');
                            } else {
                                customInput.style.display = 'none';
                                customInput.removeAttribute('required');
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
