@extends('layouts.site')

@section('content')
    <main role="main">

        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Редактирование отзыва</h3>
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

                    <form method="POST" action="{{ route('updateReview') }}" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputTitle">Новый заголовок</label>
                            <input type="text" class="form-control" name="title" value="{{ $review->title }}" aria-describedby="emailHelp" placeholder="Введите название главы">
                        </div>

                        <div class="form-group">
                            <label for="InputDescription">Новый текст отзыва</label>
                            <textarea name="textrev" class="form-control" placeholder="Описание главы"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Новая оценка книги</label>
                            <select class="form-control" id="exampleFormControlSelect2" name="assessment">
                                <option value="5">Отлично</option>
                                <option value="4">Хорошо</option>
                                <option value="3">Неплохо</option>
                                <option value="2">Плохо</option>
                                <option value="1">Ужасно</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <input type="hidden" name="review_id" value={{ $review->id }}>
                        </div>

                        <div class="text-right">
                            <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Редактировать отзыв</button>
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