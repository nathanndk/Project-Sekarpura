<div class="card mt-3">
    <div class="card-body">
        <div class="mt-3">
            <h1 class="card-title">Category</h1>
            <form id="searchForm" action="{{ route('thread-categories.search') }}" method="post">
                @csrf

                    @php
                    $threadCategories = [
                        1 => 'Book',
                        2 => 'Life',
                        3 => 'Sports',
                        4 => 'Food',
                        5 => 'Music',
                        6 => 'Movie',
                        7 => 'Game',
                        8 => 'Programming',
                        9 => 'Custom',
                    ];
                    @endphp

                    @foreach($threadCategories as $id => $name)
                    <div class="form-check">
                        <input id="category-{{ $id }}" name="categories[]" value="{{ $id }}" type="checkbox" class="form-check-input">
                        <label for="category-{{ $id }}" class="form-check-label">{{ $name }}</label>
                    </div>
                    @endforeach

                    <!-- Search Category button -->
                    <button type="submit" class="btn btn-primary mt-3">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
