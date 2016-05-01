@extends('master')

@section('title')
    Books
@endsection

@section('maincontent')
<div class="row">
    <div class="col-md-12">
        @if (isset($skill))
        <h1>Skill: {{ $skill->name }}</h1>
            @if (isset($skill->crawled_at))
            <h2>Last Scraped At: {{$skill->crawled_at}}</h2>
            @endif
        @elseif (isset($resultlessSkill))
            <h1>Skill: {{$resultlessSkill}}</h1>
        @else
        <h1>All Books</h1>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if (isset($books) && count($books) > 0)
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Author Bio</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
            <tr><td><img src='{{$book->img_url}}'></td>
                <td><a href='{{$book->book_url}}'>{{$book->title}}</a></td>
                <td>{{$book->author}}</td>
                <td>{{$book->author_bio}}</td>
                <td>{{$book->description}}</td>
                <td>${{$book->price}}</td>
                <td>{{$book->rating}}/5</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @else
        <h3>No books found</h3>
        @endif
    </div>
</div>
@endsection

