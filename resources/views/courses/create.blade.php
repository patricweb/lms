@extends("layout")

@section("main")
    <h3>Create your course</h3>
    <form action="{{ route('saveCourse') }}" method='POST' enctype='multipart/form-data'>
        @csrf
        <label for="title">Title:</label>
        <input type="text" name='title' id='title' required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="price">Price:</label>
        <input type="number" name='price' id='price' min='0'>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="thumbnail">Thumbnail:</label>
        <input type="file" name='thumbnail' id='thumbnail' accept='image/*'>

        <button type='submit'>Create Course</button>
    </form>
@endsection