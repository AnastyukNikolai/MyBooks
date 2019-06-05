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

    <style>
        .dropdown-submenu {
            position: relative;
            background-color: #818182;
            color: snow;

        }

        .third-lvl  {

        }

        .dropdown-menu {
            background-color: #999999;
            color: snow;
        }

        .dropdown-menu-right > a {
            padding: 5px;
            border-radius: 20%;
            color: snow;

        }

        .dropdown-submenu > a {
            border-radius: 30%;
            margin-left: 25px;
            margin-top: 5px;
            padding-top: 1px;
            text-decoration: none;
            color: snow;
        }

        .dropdown-menu > li > a {
            border-radius: 30%;
            margin-left: 25px;
            margin-top: 5px;
            padding: 3px;
            text-decoration: none;
            color: snow;

        }

        .dropdown-menu > li > a:hover {
            color: white;
            background-color: black;
            padding: 6px;
            margin-right: 30px;
            margin-left: 30px;
            margin-top: 2px;
            margin-bottom: 2px;
            transition: 0.3s;
        }


        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px 6px;
            border-radius: 0 6px 6px 6px;
        }

        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }

        .dropdown-submenu > a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #cccccc;
            margin-top: 5px;
            margin-right: -10px;
        }

        .dropdown-submenu:hover > a:after {
            border-left-color: #ffffff;
        }

        .dropdown-submenu.pull-left {
            float: none;
        }

        .dropdown-submenu.pull-left > .dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }

        a.admin:hover {
            color: white;
        }
    </style>

</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="background-color: #31373e">
    <a class="navbar-brand" href="/">BookMake</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">

        @if(Auth::check()&&Auth::user()->role_id == 1)
            <div style="margin-right: 2%; margin-left: 1%">
            <ul class="navbar-nav mr-auto">
                <li class="divider"></li>
                <a style="color: snow" class="nav-link dropdown-toggle btn btn-outline-primary admin" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">Администрирование</a>
                <li class="dropdown">
                    <ul style="width: content-box" class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a class="btn-outline-primary" href="{{ url('admin') }}">Админ. панель</a>
                            <hr  style="margin: 0; padding: 0">
                        </li>
                        <li class="dropdown-submenu">
                            <a class="btn-outline-dark" href="#">Сообщения</a>
                            <hr  style="margin: 0; padding: 0">
                            <ul class="dropdown-menu">
                                <li class="third-lvl"><a href="{{ route('messagesIndex', ['id'=>Auth::id(), 'type'=>'2']) }}">Жалобы</a></li>
                                <li class="third-lvl"><a href="{{ route('messagesIndex', ['id'=>Auth::id(), 'type'=>'3']) }}">Предложения</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            </div>
        @endif

        @if(Request::url() !== '/login/google/callback')
            @if(Auth::check()&&Auth::user()->role_id == 1)
                <div style="margin-right: 10%; margin-left: 1%" class="log-reg">
            @else
                <div style="margin-right: 20%; margin-left: 5%" class="log-reg">
            @endif
            <ul class="navbar-nav mr-auto">
                <li class="divider"></li>
                <a style="color: #218838;padding: 4px;border-radius: 5%;font-size: 17px" class="nav-link dropdown-toggle btn-outline-light"
                   href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false"><strong>Книги</strong></a>
                <li class="dropdown">
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a class="btn-outline-dark" href="#">Категории</a>
                            <hr  style="margin: 0; padding: 0">
                            <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                <li class="third-lvl">
                                    <a href="{{ route('filterAndSort', ['table'=>'categories', 'id'=>$category->id, 'search'=>null, 'sort_param'=>'created_at']) }}">{{$category->title}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="btn-outline-dark" href="#">Жанры</a>
                            <hr  style="margin: 0; padding: 0">
                            <ul class="dropdown-menu">
                                @foreach($genres as $genre)
                                    <li class="third-lvl"><a href="{{ route('filterAndSort', ['table'=>'genres', 'id'=>$genre->id, 'search'=>null, 'sort_param'=>'created_at']) }}">{{$genre->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="btn-outline-dark" href="#">Языки</a>
                            <hr style="margin: 0; padding: 0">
                            <ul class="dropdown-menu">
                                @foreach($languages as $language)
                                    <li class="third-lvl"><a href="{{ route('filterAndSort', ['table'=>'languages', 'id'=>$language->id, 'search'=>null, 'sort_param'=>'created_at']) }}">{{$language->title}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        @endif
        <form class="form-inline my-2 my-lg-0 mr-auto typeahead" role="search" action="{{ route('search') }}">
            <input  value="{{ old('q') }}" class="form-control mr-sm-2" type="search" name="q" placeholder="Поиск..." aria-label="Search" autocomplete="off">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
        </form>
        @if(Auth::check())
            <div class="log-reg">
                <ul class="list-inline" style="margin-bottom: 0;padding-bottom: 0;border-radius: 20%">
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
                        <a style="color: black;border-radius: 20%" class="nav-link dropdown-toggle btn-light"
                           href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}}</a>
                        <div style="text-align: center;text-decoration: none" id="drop-menu-items" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="{{ route('showUser', ['id'=>Auth::id()]) }}">
                                Мой профиль</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ route('artworksShow', ['id'=>Auth::id()]) }}">
                                Мои произвидения</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ route('likedShow', ['id'=>Auth::id()]) }}">
                                Понравившееся</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ route('favoritesShow', ['id'=>Auth::id()]) }}">
                                Избранное</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ route('messagesIndex', ['id'=>Auth::id(), 'type'=>1]) }}">
                                Уведомления</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ route('addMessage', ['id'=>Auth::id()]) }}">
                                Написать администрации</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ route('userFinancialOperations', ['id'=>Auth::id()]) }}">
                                Мои финансовые операции</a>
                            <hr style="margin: 5px">
                            <a class="dropdown-item" href="{{ url('logout') }}">
                                Выход</a>
                            <hr style="margin: 5px">
                        </div>
                    </li>
                </ul>
            </div>
        @else
            <div class="log-reg">
                <a class="btn btn-warning" href="{{ url('/login/google') }}" style="margin-left: 10px">Вход (Google
                    account)</a>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="../../../../assets/js/vendor/popper.min.js"></script>
<script src="../../../../dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

</body>
</html>
