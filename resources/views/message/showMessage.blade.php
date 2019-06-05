@extends('layouts.site')

@section('content')
    <main role="main" class="content">

        <div class="container">
            <!-- row of columns -->
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger text-center msg" id="error">
                    <strong>{{ session('error') }}</strong>
                </div>
            @endif

            @if(Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{Session::get('success')}}</li>
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-10">
                    <div class="book_content-title">
                        <strong>Сообщение</strong>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

                <div class="row">
                    <div class="col-md-10" style="padding: 0">
                        <div class="book__description default">
                            <div class="book__description-heading">
                                <strong>Тема: </strong>@if ($message->type_id == 2&&$message->theme == 'complaint'&&$message->artwork_id != null)
                                   Пользователь <a href="#">{{ $message->user->name }}</a> пожаловался на книгу <a href="{{ route('bookShow', ['id'=>$message->artwork_id]) }}">{{ $message->artwork->title }}</a>
                                @else
                                    {{ $message->theme }}
                                @endif
                            </div>
                            <div class="book__description-heading">
                                <strong>Отправитель: </strong>
                                    @if($message->user->role_id == 1)
                                        Администрация
                                @elseif ($message->user == null)
                                        Система
                                        @else
                                        {{ $message->user->name }}
                                    @endif
                            </div>
                            @if(Auth::user()->role_id == 1)
                            <div class="book__description-heading">
                                <strong>Получатели: </strong>
                                @if($message->user->role_id == 1)
                                    Администрация
                                @elseif ($message->user == null)
                                    Система
                                @else
                               @foreach($message->users as $recipient)
                                    |{{$recipient->name}}|
                                   @endforeach
                                    @endif
                            </div>
                            @endif
                            <div class="book__description-heading">
                                <strong>Тип сообщения: </strong>{{$message->type->title}}
                            </div>
                            <div>
                                <div class="book__description-heading" style="text-align: center">
                                    <strong>Текст </strong>
                                </div>
                                <p>{{ $message->text }}<br></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>


        </div> <!-- /container -->
    </main>

@endsection