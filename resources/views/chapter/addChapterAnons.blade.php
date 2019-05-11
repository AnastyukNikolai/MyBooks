@extends('layouts.site')

@section('content')
    <main role="main">

        <hr>
        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Добавление анонса главы</h3>
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

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{{Session::get('success')}}</li>
                                </ul>
                            </div>
                        @endif

                    <form method="POST" action="{{ route('storeChapterAnons') }}" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputTitle">Название</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" aria-describedby="emailHelp" placeholder="Введите название главы">
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Минимальная сумма</label>
                            <input  type="text" name="min_amount" class="form-control" placeholder="Укажите минимальную сумму спонсирования">
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Описание планируемой главы</label>
                            <textarea name="description" value="{{ old('description') }}" class="form-control" placeholder="Описание главы"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value={{ Auth::user()->id }}>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="artwork_id" value={{ $artwork_id }}>
                        </div>

                        <div class="text-right">
                        <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Добавить анонс главы</button>
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