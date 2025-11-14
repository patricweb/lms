@extends("layout")

@section("main")
    <h2>Course admin page!</h2>

    @foreach ($courses as $course)
        <h3><a href="{{ route('showCourse', $course) }}">{{ $course->title }}</a></h3>
        <p>{{ $course->description }}</p>
        <p>{{ $course->teacher->name }}</p>
        <p>{{ $course->category->name }}</p>
        <p>{{ $course->price }}</p>
    @endforeach
    
@endsection