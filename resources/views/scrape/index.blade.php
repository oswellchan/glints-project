@extends('master')

@section('title')
    Scrape
@endsection

@section('maincontent')
<style>
    .glyphicon-refresh-animate {
        -animation: spin .7s infinite linear;
        -webkit-animation: spin2 .7s infinite linear;
    }

    @-webkit-keyframes spin2 {
        from { -webkit-transform: rotate(0deg);}
        to { -webkit-transform: rotate(360deg);}
    }

    @keyframes spin {
        from { transform: scale(1) rotate(0deg);}
        to { transform: scale(1) rotate(360deg);}
    }
</style>
<div class="row">
    <div class="col-xs-12 col-md-6 col-xs-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Amazon Scrape</h3>
            </div>
            <div class="panel-body">
                <form id="scrape-form" class="form-group" action="/scrape" method="get">
                    <div class="form-group">
                        <input type="text" name="skill" class="form-control" placeholder="Scrape By Skill">
                    </div>
                    <button id="submitBtn" type="submit" class="btn btn-default">Scrape</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#scrape-form').submit(function(event) {
            if ($('#submitBtn').has('span').length < 1) {
                $('#submitBtn').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Scraping...');                
            } else {
                event.preventDefault();
            }
        });
    }); 
</script>
@endsection

