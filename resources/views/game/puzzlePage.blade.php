@extends('app')
@section('content')
    <div class="container-fluid feature py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 text-center">
                    <h4>Puzzle String</h4>
                    <h1 class="text-success fw-900" id="puzzleString">{{ $session->puzzle_string }}</h1>

                </div>
                <hr>
                <div class="col-md-12 mt-5 text-center">
                    <span><b> Your word score :</b></span>
                    <span class="text-danger ml-2" style="font-size: 20px" id="score"><b>0</b></span>
                </div>

                <div class="text-center mt-3">
                    <input name="puzzleWord" id="puzzleWord" placeholder="Enter a word" class="form-control mx-auto" style="max-width: 500px;" >
                </div>
                <div class="col-md-12 d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success" onclick="submitGame()">Submit</button>
                    <button type="submit" class="btn btn-danger" style="margin-left: 5px;" onclick="finishGame()">Finish Game</button>
                </div>

                <div class="col-md-12 mt-3 text-center">
                    <h4>Submitted Words:</h4>
                </div>
                <div class="col-md-12 text-center">
                   <ul id="submissionList" style="list-style: none"></ul>
                </div>

            </div>
        </div>
    </div>

<script>
    const gameSubmitRoute = "{{route('game.storeWord')}}"
    const gameFinishRoute = "{{route('game.finish')}}"
</script>
<script src="{{asset('js/puzzlePage.js')}}"></script>
@endsection
