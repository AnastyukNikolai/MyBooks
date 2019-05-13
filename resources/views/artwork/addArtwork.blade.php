@extends('layouts.site')

@section('content')
    <main role="main">

        <hr>
        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Добавить произвидение</h3>
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
                    <form method="POST" action="{{ route('storeArtwork') }}" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Название</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" aria-describedby="emailHelp" placeholder="Введите название произведения">
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Язык</label>
                            <select name="language" value="{{ old('language') }}" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                @foreach($languages as $language)
                                <option value="{{$language->id}}">{{$language->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Категория</label>
                            <select name="category" value="{{ old('category') }}" class="custom-select mr-sm-2">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Жанры (для выбора нескольких жанров держите ctrl)</label>
                            <select multiple="multiple" class="form-control" id="exampleFormControlSelect2" name="genres[ ]">
                                @foreach($genres as $genre)
                                    <option value="{{$genre->id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Статус произведения</label>
                            <select name="status" value="{{ old('language') }}" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                @foreach($statuses as $statuse)
                                    <option value="{{$statuse->id}}">{{$statuse->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="custom-file">
                            <label class="custom-file-label" for="InputImage">Выберите изображение (.jpg, .jpeg)</label>
                            <input type="file" name="image" class="custom-file-input" placeholder="Выберите изображение">
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Описание</label>
                            <textarea name="description" value="{{ old('description') }}" class="form-control" placeholder="Введите описание произведения"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_id" value={{ $user->id }}>
                        </div>

                        <div class="text-right">
                        <button type="submit" class="btn btn-success btn-md">Добавить</button>
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