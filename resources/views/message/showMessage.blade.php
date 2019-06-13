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
                                    @if($message->user->role_id == 1&&$message->type_id != 4)
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
                            @if($message->type_id == 4)
                                <div class="book__description-heading">
                                <strong>Сумма: </strong>{{ $message->text }}
                                </div>
                                <div class="book__description-heading" style="text-align: center;">
                                    <p><strong>Чек </strong></p>
                                    <img alt="{{ $message->image }}"
                                         src="{{ \Storage::disk('public')->url($message->image->image_path) }}"
                                         style="width: 900px">
                                </div>
                                <form method="POST" action="{{ route('updateBalance') }}" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <input type="hidden" name="user_id" value={{ $message->user_id }}>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="sum" value={{ $message->text }}>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="message_id" value={{ $message->id }}>
                                    </div>

                                    <div class="text-right">
                                        <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Подтвердить пополнене баланса</button>
                                    </div>
                                    {{ csrf_field() }}
                                </form>
                            @else
                            <div>
                                <div class="book__description-heading" style="text-align: center">
                                    <strong>Текст </strong>
                                </div>
                                <p>{!! $message->text !!} <br></p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>


        </div> <!-- /container -->
    </main>

@endsection