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
                <div class="col-md-12">
                    <div style="color: snow; background-color: #1e7e34; padding: 20px;margin: 0; font-size: 20px;">
                        <strong>{{ $headline }}</strong>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1" style="text-align: center"><strong></strong></div>
                @if($type_id == null)
                    <div class="col-md-2" style="text-align: center"><strong>Плучатель</strong>
                        <hr>
                    </div>
                    <div class="col-md-1" style="text-align: center"><strong>Тип сообщения</strong>
                        <hr>
                    </div>
                    <div class="col-md-5" style="text-align: center"><strong>Тема сообщения</strong>
                        <hr>
                    </div>
                @else
                    <div class="col-md-3" style="text-align: center"><strong>Отправитель</strong>
                        <hr>
                    </div>
                    <div class="col-md-5" style="text-align: center"><strong>Тема уведомления</strong>
                        <hr>
                    </div>
                @endif
                <div class="col-md-2" style="text-align: center"><strong>Просмотрено</strong>
                    <hr>
                </div>
                <div class="col-md-1" style="text-align: center"><strong></strong></div>
            </div>

            @foreach($messages as $message)
                @if($n%2==0)
                    <div class="row" style="color: snow;background-color: #1d643b;padding-top: 5px;padding-bottom: 5px; border-color: black; border-style: double; margin-bottom: 2px">
                        @else
                            <div class="row" style="background-color: #71dd8a; padding-top: 5px; padding-bottom: 5px; border-color: black; border-style: double; margin-bottom: 2px">
                                @endif
                                <div class="col-md-1" style="font-size: 12px">{{ $message->created_at }}</div>
                                @if($type_id == null)
                                    <div class="col-md-2" style="text-align: center">
                                        @if($message->user->role_id == 1)
                                            Администрация
                                            @elseif($message->user == null)
                                            Система
                                        @else
                                            @foreach($message->users as $recipient)
                                                {{$recipient->name}}
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-md-1" style="text-align: center">{{ $message->type->title }}

                                    </div>
                                    <div class="col-md-5" style="text-align: center">{{ $message->theme }}

                                    </div>
                                @else
                                    <div class="col-md-3" style="text-align: center">
                                        @if($message->user->role_id == 1)
                                            Администрация
                                        @else
                                            {{ $message->user->name }}
                                        @endif
                                    </div>
                                    <div class="col-md-5" style="text-align: center">{{ $message->theme }}</div>
                                @endif
                                <div class="col-md-2" style="text-align: center">
                                    @if($message->seen == true)
                                        Да <img class="book-info-icn" src="/icn/seen.png">
                                    @else
                                        Нет <img class="book-info-icn" src="/icn/no_seen.png">
                                    @endif
                                </div>
                                <div class="col-md-1" style="text-align: center">
                                    <a href="{{ route('showMessage', ['id' => $message->id]) }}">Читать</a>
                                </div>
                            </div>
                            <p style="display: none">{{$n+=1}}</p>
                            @endforeach


                    </div> <!-- /container -->
    </main>

@endsection