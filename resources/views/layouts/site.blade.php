
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Book Make</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->


    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="background-color: #31373e">
      <a class="navbar-brand" href="/">BookMake</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>

        </ul>
        <form class="form-inline my-2 my-lg-0 mr-auto">
          <input class="form-control mr-sm-2" type="text" placeholder="Поиск по названию" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
        </form>
        @if(Auth::check())
          <div class="log-reg">
          <ul class="list-inline" style="margin-bottom: 0;padding-bottom: 0;">
            <li class="list-group-item-dark d-flex justify-content-between align-items-center">
              Баланс:
              <span class="badge badge-success badge-pill">{{Auth::user()->balance - Auth::user()->sale_transactions->where('status_id', 3)->sum('amount') }}</span>
            </li>
            <li class="list-group-item-dark d-flex justify-content-between align-items-center">
              Возможный заработок:
              <span class="badge badge-warning badge-pill">{{ Auth::user()->sale_transactions->where('status_id', 3)->sum('amount') }}</span>
            </li>
          </ul>
          </div>
          <div class="log-reg">
          <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown dropdown-header">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="{{ route('artworksShow', ['id'=>Auth::user()->id]) }}">Мои Произвидения</a>
            <a class="dropdown-item" href="{{ route('userFinancialOperations', ['id'=>Auth::id()]) }}">Мои финансовые операции</a>
            <a class="dropdown-item" href="{{ url('logout') }}">Выход</a>
          </div>
          </li>
          </ul>
          </div>
        @else
              <div class="log-reg">
                  <a class="btn btn-warning" href="{{ url('/login/google') }}" style="margin-left: 10px">Вход (Google account)</a>
              </div>
        @endif
      </div>
    </nav>

    <hr>

@yield('content')

    <hr>
    <footer style="background-color: #31373e; margin-top: 25px">
        <p style="color: oldlace; text-align: center; padding: 12px">&copy; Company 2019</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
