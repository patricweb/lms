@extends("layout")

@section("main")
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-2xl bg-[#182023] border border-gray-700 rounded-2xl p-8">
            <h3 class="text-3xl font-bold text-white mb-6">Create your course</h3>
            <form action="{{ route('saveCourse') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label for="title" class="block text-gray-300 mb-1">Title:</label>
                    <input type="text" name="title" id="title" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600">
                </div>
                <div>
                    <label for="description" class="block text-gray-300 mb-1">Description:</label>
                    <textarea name="description" id="description" required rows="4" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600"></textarea>
                </div>
                <div>
                    <label for="price" class="block text-gray-300 mb-1">Price:</label>
                    <input type="number" name="price" id="price" min="0" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600">
                </div>
                <div>
                    <label for="category_id" class="block text-gray-300 mb-1">Category:</label>
                    <select name="category_id" id="category_id" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="thumbnail" class="block text-gray-300 mb-1">Thumbnail:</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full text-gray-300">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
