  @extends('app')

  @section('hero')
      <!-- Hero Start -->
      <div class="container-fluid py-5 mb-5 hero-header">
          <div class="container py-5">
              <div class="row g-5 align-items-center">
                  <div class="col-md-12 col-lg-7">
                      <h4 class="mb-3 text-secondary">Let's play and learn</h4>
                      <h1 class="mb-5 display-3 text-primary">Word Puzzle</h1>
                      <a href="{{ route('login') }}" class="btn btn-success">Start Game</a>
                  </div>

              </div>
          </div>
      </div>

      <!-- Hero End -->
  @endsection
