@extends('layouts.site')

@section('content')
    <main role="main">

        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Добавление отзыва</h3>
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

                    <form method="POST" action="{{ route('storeReview') }}" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputTitle">Заголовок</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" aria-describedby="emailHelp" placeholder="Введите название главы">
                        </div>

                        <div class="form-group">
                            <label for="InputDescription">Текст отзыва</label>
                            <textarea name="textrev" class="form-control" placeholder="Описание главы"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value={{ Auth::user()->id }}>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="artwork_id" value={{ $artwork_id }}>
                        </div>

                        <div class="text-right">
                            <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Добавить отзыв</button>
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