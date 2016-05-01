@extends('master')

@section('title')
    Skills
@endsection

@section('maincontent')
@if (isset($skills) && count($skills) > 0)
<div class="row">
    <div class="col-xs-12 col-md-6 col-xs-offset-3">
        <h1>Skills</h1>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Skill</th>
                    <th>Scraped At</th>
                </tr>
            </thead>
            <tbody>
            @foreach($skills as $skill)
            <tr><td><a href='/book?skill={{$skill->name}}'>{{$skill->name}}</a></td>
                <td>{{$skill->crawled_at}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <h1>Skills</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>No skills scraped yet</h3>
    </div>
</div>
@endif
@endsection

