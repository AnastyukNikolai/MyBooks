@extends('layouts.site')

@section('content')
    <main role="main">

        <hr>
        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Редактирование главы</h3>
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

                    @if(Session::has('message'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{Session::get('message')}}</li>
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('updateArtworkChapter') }}" enctype="multipart/form-data" accept-charset="UTF-8">

                        <div class="form-group">
                            <label for="exampleInputTitle">Название</label>
                            <input type="text" class="form-control" name="title" value="{{ $chapter->title }}" aria-describedby="emailHelp" placeholder="Введите новое название главы">
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Цена главы</label>
                            <input  type="text" name="price" value="{{ $chapter->price }}" class="form-control" placeholder="Укажите новую цену главы">
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Описание главы</label>
                            <textarea name="description"  class="form-control" placeholder="Новое описание главы"></textarea>
                        </div>
                        <div class="custom-file">
                            <label class="custom-file-label" for="InputImage">Выберите новый файл (.txt)</label>
                            <input type="file" name="text" value="{{ $chapter->text_link }}" class="custom-file-input" placeholder="Выберите новый файл">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value={{ Auth::user()->id }}>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="chapter_id" value={{ $chapter->id }}>
                        </div>

                        <div class="text-right">
                            <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Редактировать главу</button>
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