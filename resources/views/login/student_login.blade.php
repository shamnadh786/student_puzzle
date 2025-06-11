@extends('app')
@section('content')
   <div class="container-fluid feature py-5" >
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">

            <h2 class="text-center mb-4">Sign in to play</h2>
            <hr>

            <form method="POST" action="{{ route('game.start') }}" >
                @csrf

                <div class="mb-3">
                    <label for="studentName" class="form-label">Name</label>
                    <input type="text" name="studentName" class="form-control" id="studentName" required>
                </div>

                <div class="mb-3">
                    <label for="studentEmail" class="form-label">Email</label>
                    <input type="email" name="studentEmail" class="form-control" id="studentEmail" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
