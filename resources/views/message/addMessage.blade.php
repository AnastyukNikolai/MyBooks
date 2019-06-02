@extends('layouts.site')

@section('content')
    <main role="main">

        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Сообщение администрации</h3>
                    </div>
                    <hr>
                </div>
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

                    <form method="POST" action="{{ route('storeMessage') }}" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputTitle">Тема</label>
                            <input type="text" class="form-control" name="theme" value="{{ old('theme') }}" aria-describedby="emailHelp" placeholder="Введите тему сообщения">
                        </div>

                        <div class="form-group">
                            <label for="InputDescription">Текст</label>
                            <textarea name="text" class="form-control" placeholder="Текст сообщения"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Тип собщения</label>
                            <select name="type" class="custom-select mr-sm-2">
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value={{ $user->id }}>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="uve" value="adm">
                        </div>

                        <div class="text-right">
                            <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Отправить сообщение</button>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>

        </div>


        </div> <!-- /container -->
    </main>

@endsection