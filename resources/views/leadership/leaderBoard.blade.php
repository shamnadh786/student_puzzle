@extends('app')
@section('content')
<div class="container-fluid feature py-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Leader Board</h3>
            <hr>
            <table class="table table-striped table-hovered">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Word</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaderScore as $scoreVal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $scoreVal->student->name ?? 'N/A' }}</td>
                        <td>{{ $scoreVal->word }}</td>
                        <td>{{ $scoreVal->score }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center mt-3">
           <a  href="{{ route('game.start') }}" class="btn btn-primary">Start Game</a>
        </div>
    </div>
</div>
@endsection
