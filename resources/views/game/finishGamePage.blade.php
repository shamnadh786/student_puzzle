@extends('app')
@section('content')
    <div class="container-fluid feature py-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Game Over !</h2>
                <h3>Your Total Score</h3>
                <hr>
                <h1>{{$totalScore}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center mt-3">
                    <a  href="{{ route('game.start') }}" class="btn btn-primary" >Restart Game</a>
                    <a  href="{{ route('game.leaderBoard') }}" class="btn btn-info" style="margin-left: 5px;">Show Leader Board</a>
            </div>
        </div>
    </div>
@endsection