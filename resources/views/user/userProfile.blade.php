@extends('layouts.site')

@section('content')
    <main role="main">

        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-lg-9">

                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{Session::get('success')}}</li>
                            </ul>
                        </div>
                    @endif

                        <div class="book__cont col-md-7">
                                @if(Auth::check()&&Auth::id() == $user->id)
                                <h4 style="color: #008080; text-align: center; margin-top: 5px"
                                    class="book-heading">Мой профиль</h4>
                            @else
                                <h4 style="color: #008080; text-align: center; margin-top: 5px"
                                    class="book-heading">Профиль пользователя {{ $user->name }}</h4>
                                @endif
                            <hr color="green" height="bold">
                            <div class="book__info default">
                                <div class="book__block-item book__block-star clearfix">
                                    <div class="book__block-name">Зарегестрирован:</div>
                                    <div align="right"
                                         class="book__block-time time-green pull-right">{{$user->created_at}}</div>
                                </div>
                                <hr color="green">

                                <div class="book__block-name">Произведения:</div>
                                <div align="right" class="book__block-time pull-right">
                                    <div style="display: inline-block">
                                    <a class="btn btn-sm btn-block btn-info" href="{{ route('artworksShow', ['id'=>$user->id]) }}">
                                        @if(Auth::check()&&Auth::id() == $user->id)
                                            Мои произведения
                                        @else
                                            Произведения пользователя {{ $user->name }}
                                        @endif
                                    </a>
                                    </div>
                                    <div style="display: inline-block">
                                    <a class="btn btn-sm btn-block btn-info" href="{{ route('favoritesShow', ['id'=>$user->id]) }}">
                                        @if(Auth::check()&&Auth::id() == $user->id)
                                            Мое избранное
                                        @else
                                            Избранное пользователя {{ $user->name }}
                                        @endif
                                    </a>
                                    </div>

                                </div>
                                <hr color="green">

                            </div>
                        </div>

                </div>
            </div>
        </div>

    </main>

@endsection