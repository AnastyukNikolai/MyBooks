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
                            @if($anons==1)
                                <strong>Финансовые операции анонса "{{$chapter->title}}":</strong>
                            @else
                                <strong>Финансовые операции главы "{{$chapter->title}}":</strong>
                            @endif
                        </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2" style="text-align: center"><strong>№ &nbsp; | &nbsp; Плательщик</strong><hr></div>
                <div class="col-md-2" style="text-align: center"><strong>Получатель</strong><hr></div>
                <div class="col-md-1" style="text-align: center"><strong>Статус</strong><hr></div>
                <div class="col-md-2" style="text-align: center"><strong>Тип</strong><hr></div>
                <div class="col-md-2" style="text-align: center"><strong>Время начала</strong><hr></div>
                <div class="col-md-2" style="text-align: center"><strong>Время завершения</strong><hr></div>
                <div class="col-md-1" style="text-align: center"><strong>Сумма</strong><hr></div>
            </div>

            @foreach($operations as $operation)
            @if($n%2==0)
                <div class="row" style="color: snow;background-color: #1d643b">
                    @else
                <div class="row" style="background-color: #71dd8a">
                    @endif
                    <div class="col-md-2" style="text-align: center">{{$n+=1}} &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp; {{$operation->payer->name}} {{$operation->payer->email}}</div>
                    <div class="col-md-2" style="text-align: center">{{$operation->receiver->name}} {{$operation->receiver->email }}</div>
                    <div class="col-md-1" style="text-align: center">{{$operation->status->title}}</div>
                    <div class="col-md-2" style="text-align: center">{{$operation->type->title}}</div>
                    <div class="col-md-2" style="text-align: center">{{$operation->created_at}}</div>
                    <div class="col-md-2" style="text-align: center">
                        @if($operation->status->id==3) Не завершено @else {{$operation->updated_at}} @endif
                    </div>
                    <div class="col-md-1" style="text-align: center">{{$operation->amount}} у.е.</div>
                </div>
                @endforeach


        </div> <!-- /container -->
    </main>

@endsection