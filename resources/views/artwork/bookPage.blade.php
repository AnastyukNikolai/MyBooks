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


            <div class="row book-main-block">
                <div class="col-md-5" style="padding-right: 5%">
                    <div class="book-photo text-center">
                        <div class="image-wrapper">
                            <img alt="{{ $artwork->title }}"
                                 src="{{ \Storage::disk('public')->url($artwork->image->image_path) }}"
                                 class="book-img">
                        </div>
                    </div>
                    <div class="book_read text-center default" style="margin-top: 10px">
                        @if(Auth::check()&&Auth::user()->favorites->where('artwork_id', $artwork->id)==false)
                            <a href="{{ route('addToFavorite', ['artwork_id'=>$artwork->id, 'user_id' => Auth::id()]) }}"
                               class="btn btn-outline-primary btn-lg my-2 my-sm-0" role="button" aria-pressed="true">
                                <span>Добавить в избранное</span>
                            </a>
                        @elseif(Auth::check()&&Auth::user()->favorites->where('artwork_id', $artwork->id)==true)
                            <a href="{{ route('deleteFromFavorites', ['artwork_id'=>$artwork->id, 'user_id' => Auth::id()]) }}"
                               class="btn btn-outline-danger btn-lg my-2 my-sm-0" role="button" aria-pressed="true">
                                <span>Удалить из избранного</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="book__cont col-md-5">
                    <h2 style="color: #008080; text-align: center; margin-top: 5px"
                        class="book-heading">{{ $artwork->title }}</h2>
                    <hr color="green" height="bold">
                    <div class="book__info default">
                        <div class="book__block-name">Автор:</div>
                        <div align="right" class="book__block-time pull-right">
                            <a href="{{ route('artworksShow', ['id'=>$artwork->user->id]) }}">{{ $artwork->user->name }}</a>
                        </div>
                        <hr color="green">
                        <div class="book__block-item book__block-star clearfix">
                            <div class="book__block-name">Опубликовано:</div>
                            <div align="right"
                                 class="book__block-time time-green pull-right">{{$artwork->created_at}}</div>
                        </div>
                        <hr color="green">
                        <div class="book__block-item">
                            <div class="book__block-name">Жанры:</div>
                            <div class="book__block-genre">
                                <span class="book-category">{{ $artwork->category->title }}</span>
                            </div>
                        </div>
                        <hr color="green">
                        <div class="book__block-item">
                            <div class="book__block-name">Категория:</div>
                            <div class="book__block-genre">|
                                @if($artwork->category)
                                    @foreach($artwork->genres as $genre) {{ $genre->name }} | @endforeach
                                @endif
                            </div>
                        </div>
                        <hr color="green">
                        <div class="book__block-item country-block">
                            <div class="book__block-name">
                                Язык: <span class="book-country">{{ $artwork->language->title }}</span>
                            </div>
                            <img class="book-info-icn"
                                 src="{{ \Storage::disk('public')->url($artwork->language->image->image_path) }}"
                                 class="country-img" alt="{{ $artwork->language->title }}">
                        </div>
                        <hr color="green">
                        <div class="book__block-item">
                            <div class="book__block-name">Популярность книги:</div>

                            <div class="vote-book" style="align: right">
                               <span data-tip="Понравилось" data-for="rating-tooltip" class="vote__item vote-green "
                                     currentitem="false">
                                   @if(Auth::check()&&Auth::user()->liked->where('id', $artwork->id)->where('deleted_at', null)->first() != null)
                                       <a title="Отменить" href="{{ route('deleteLike', ['artwork_id'=>$artwork->id, 'user_id' => Auth::id()]) }}"><img class="book-info-icn" src="/icn/heart.png"></a><span
                                               style="color: #218838">{{ $artwork->likers->count() }}</span>
                                       @elseif(Auth::check())
                                       <a title="Отметить как понравившееся" href="{{ route('addLike', ['id'=>$artwork->id]) }}"><img class="book-info-icn" src="/icn/like.png"></a><span
                                               style="color: #218838">{{ $artwork->likers->count() }}</span>
                                       @else
                                       <a title="Отметить как понравившееся" href="{{ route('googleLogin') }}"><img class="book-info-icn" src="/icn/like.png"></a><span
                                               style="color: #218838">{{ $artwork->likers->count() }}</span>
                                       @endif
                               </span>
                            </div>
                        </div>
                        <hr color="green">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-10" style="padding: 0">
                    <div class="book__description default">
                        <div class="book__description-heading">
                            <i class="icon icon-desc"></i>
                            <strong>Описание:</strong>
                        </div>
                        <div>
                            <p>{{ $artwork->description }}<br></p>
                        </div>
                    </div>
                    <div class="book__description default">
                        <div class="book__description-heading">
                            <i class="icon icon-info"></i>
                            <strong>Важная информация:</strong>
                        </div>
                        <div>
                            <p>Статус произведения:&nbsp;{{ $artwork->status->title }}</p>
                            <p></p>
                            @if($artwork->chapters!=null)
                                <p>Количество глав: {{ $artwork->chapters->where('announcement', false)->count() }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>




            <div class="row">
                <div class="col-md-10">
                    <div class="book_content default">
                        <div class="book_content-title">
                            <strong>Отзывы:</strong>
                        </div>
                        <div class="book_content-item" style="text-align: right">
                            <div class="book_content-table">
                                @if(Auth::user()&&$artwork->users->find(Auth::user()->id)==true||$user_chapter==true)
                                    <div class="chapter_add_btn">
                                        <a class="btn btn-outline-success btn-block "
                                           href="{{ route('addReview', ['id'=>$artwork->id]) }}">Добавить отзыв
                                        </a>
                                    </div>
                                    <hr>
                                @else
                                    <div class="chapter_add_btn">
                                        <a class="btn btn-secondary btn-block disabled"
                                           href="#">Отзывы могут добавлять только пользователи купившие хотя-бы одну главу
                                        </a>
                                    </div>
                                    <hr>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

            <div class="reviews">
            @foreach($reviews as $review)
                    <div class="book_item">
                        <div class="row">
                            <div class="book_chapter-title col-md-10" title="Нажмите что бы увидеть отзыв" style="text-align: center">
                                <a class="btn btn-link book_chapter-title" title="Нажмите что бы увидеть отзыв" data-toggle="modal" data-target="#review{{ $review->id }}DescriptionModal">
                                    <strong>{{$review->title}}</strong>
                                </a>
                            </div>
                            <div class="modal fade" id="review{{ $review->id }}DescriptionModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div style="color: #1b1e21" class="modal-header">
                                            <h5 class="modal-title" id="buyModalLabel">{{ $review->title }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div style="color: #1b1e21" class="modal-body">
                                            <p>@if($review->text != null){{$review->text}}@else Текст отсутствует @endif</p>
                                            <p></p>
                                            <p>
                                                <strong>Оценка:</strong>
                                                    @if($review->assessment == 1)
                                                       Ужасно
                                                    @elseif($review->assessment == 2)
                                                        Плохо
                                                    @elseif($review->assessment == 3)
                                                        Неплохо
                                                    @elseif($review->assessment == 4)
                                                        Хорошо
                                                    @elseif($review->assessment == 5)
                                                        Отлично
                                                    @endif
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Закрыть
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            @if($review->user->id==Auth::id())
                                <div class="book-author-control col-md-5">
                                    <div class="book_item-btn">
                                        <a class="btn btn-warning btn-sm"
                                           href="{{ route('editReview', ['id'=>$review->id]) }}">
                                            <span class="read-block">Изменить</span>
                                        </a>
                                    </div>
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteReview{{ $review->id }}Modal">
                                            <span class="read-block">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteReview{{ $review->id }}Modal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div style="color: #1b1e21" class="modal-header">
                                                <h5 class="modal-title" id="buyModalLabel">Удаление отзыва</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div style="color: #1b1e21" class="modal-body">
                                                <p>Вы уверены что хотите удалить данный отзыв?</p>
                                                <p></p>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-info"
                                                   href="{{ route('deleteReview', ['id'=>$review->id]) }}">
                                                    <span class="buy-modal-block">Да</span>
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Нет
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-5"></div>
                            @endif
                        </div>
                    </div>
                <div class="col-md-2"></div>
                <div class="col-md-10 book_item-text" style="margin: 0.1px"></div>
            @endforeach
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-10">
                        <a class="btn btn-info btn-block"
                           href="{{ route('reviewsShow', ['id'=>$artwork->id]) }}">
                            <span class="read-block">Все отзывы ({{ $artwork->reviews->count() }})</span>
                        </a>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-10">
                    <div class="book_content default">
                        <div class="book_content-title">
                            <strong>Содеражание:</strong>
                        </div>
                        <div class="book_content-item" style="text-align: right">
                            <div class="book_content-table">
                                @if(Auth::user()&&Auth::user()->id==$artwork->user_id)
                                    <div class="chapter_add_btn">
                                        <a class="btn btn-outline-success btn-block "
                                           href="{{ route('addArtworkChapter', ['id'=>$artwork->id]) }}">Добавить главу
                                        </a>
                                    </div>
                                    <hr>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

            @foreach($chapters as $chapter)
                @if($chapter->trashed()==false || Auth::check()&&$chapter->trashed()&&$chapter->purchases->where('user_id', Auth::user()->id)->first() != null)
                    <div class="book_item">
                        <div class="row">
                            <div class="book_chapter-title col-md-10" title="Нажмите что бы увидеть описание главы" style="text-align: center">
                                <a class="btn btn-link book_chapter-title" title="Нажмите что бы увидеть описание главы" data-toggle="modal" data-target="#chapter{{ $chapter->id }}DescriptionModal">
                                    <strong>{{$chapter->title}}</strong>
                                </a>
                            </div>
                            <div class="modal fade" id="chapter{{ $chapter->id }}DescriptionModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div style="color: #1b1e21" class="modal-header">
                                            <h5 class="modal-title" id="buyModalLabel">Описание главы</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div style="color: #1b1e21" class="modal-body">
                                            @if($chapter->description != null){{$chapter->description}}@else Нет описания @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Закрыть
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            @if($chapter->artwork->user->id==Auth::id())
                                <div class="book-author-control col-md-5">
                                    <div class="book_item-btn">
                                        <a class="btn btn-warning"
                                           href="{{ route('editArtworkChapter', ['id'=>$chapter->id]) }}">
                                            <i class="icon-arrow"></i>
                                            <span class="read-block">Изменить</span>
                                        </a>
                                    </div>
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteChapter{{ $chapter->id }}Modal">
                                            <span class="read-block">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteChapter{{ $chapter->id }}Modal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div style="color: #1b1e21" class="modal-header">
                                                <h5 class="modal-title" id="buyModalLabel">Удаление главы</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div style="color: #1b1e21" class="modal-body">
                                                <p>Вы уверены что хотите удалить данную главу из списка глав книги?</p>
                                                <p></p>
                                                <p>Пользователи купившие данную главу по прежнему будут ее видеть.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-info"
                                                   href="{{ route('deleteChapter', ['id'=>$chapter->id]) }}">
                                                    <span class="buy-modal-block">Да</span>
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Нет
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-5"></div>
                            @endif
                            @if($chapter->price==0||Auth::user()&&$chapter->users->find(Auth::user()->id)==true||Auth::user()&&$chapter->artwork->users->find(Auth::user()->id)==true||$chapter->artwork->user->id==Auth::id())
                                <div class="book-action col-md-5">
                                    @if($chapter->trashed())
                                        <div class="book_item-btn">
                                            <button type="button" class="btn btn-dark" disabled>
                                                <span class="read-block">Удалена автором</span>
                                            </button>
                                        </div>
                                    @endif
                                        @if(Auth::user()&&Auth::user()->id==$chapter->artwork->user->id)
                                            <div class="book_item-btn">
                                                <a class="btn btn-info" href="{{ route('chapterFinancialOperations', ['id'=>$chapter->id, 'anons'=> 0]) }}">
                                                    <span class="read-block">Сумма покупок: {{ $chapter->financial_operations->where('status_id', 1)->where('type_id', 1)->sum('amount') }}</span>
                                                </a>
                                            </div>
                                        @endif

                                    <div class="book_item-btn">
                                        <a class="btn btn-success"
                                           href="https://drive.google.com/file/d/{{$chapter->file_id}}/view">
                                            <span class="read-block">Читать</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="book-action col-md-5">
                                    <div class="book_item-btn">
                                        <span class="read-block">{{ $chapter->price }} у.е.</span>
                                    </div>
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#buy{{ $chapter->id }}Modal">
                                            <span class="read-block">Купить главу</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="buy{{ $chapter->id }}Modal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div style="color: #1b1e21" class="modal-header">
                                                <h5 class="modal-title" id="buyModalLabel">Покупка главы</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @if(Auth::user()&&$chapter->price<=Auth::user()->balance)
                                                <div style="color: #1b1e21" class="modal-body">
                                                    Вы уверены что хотите приобрести данную главу?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-info"
                                                       href="{{ route('chapterBuy', ['id'=>$chapter->id]) }}">
                                                        <span class="buy-modal-block">Да</span>
                                                    </a>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Нет
                                                    </button>
                                                </div>
                                            @elseif(Auth::user()&&Auth::user()->balance<$chapter->price)
                                                <div style="color: #1b1e21" class="modal-body">
                                                    У вас недостаточно средств для покупки данной главы
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Отмена
                                                    </button>
                                                </div>
                                            @else
                                                <div style="color: #1b1e21" class="modal-body">
                                                    Для покупки главы необходимо войти на сайт
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-info" href="{{ url('/login/google') }}">
                                                        <span class="buy-modal-block">Войти</span>
                                                    </a>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Отмена
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <hr color="white" style="margin: 0">
                        </div>
                    </div>
                @endif
                <div class="col-md-2"></div>
                <div class="col-md-10 book_item-text" style="margin: 0.1px"></div>
            @endforeach


            <div class="row">
                <div class="col-md-10">
                    <div class="book_content default">
                        <div class="book_content-title">
                            <strong>Анонсы:</strong>
                        </div>
                        <div class="book_content-item" style="text-align: right">
                            <div class="book_content-table">
                                @if(Auth::user()&&Auth::user()->id==$artwork->user_id)
                                    <div class="chapter_add_anons_btn">
                                        <a class="btn btn-outline-success btn-block "
                                           href="{{ route('addChapterAnons', ['id'=>$artwork->id]) }}">Добавить анонс
                                            главы</a>
                                    </div>
                                    <hr>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

            <div>
                @foreach($announcements as $announcement)
                    <div class="book_item">
                        <div class="row">
                            <div class="book_chapter-title col-md-10" style="text-align: center">
                                <a class="btn btn-link book_chapter-title" title="Нажмите что бы увидеть описание анонса" data-toggle="modal" data-target="#anons{{ $announcement->id }}DescriptionModal">
                                    <strong>{{$announcement->title}}</strong>
                                </a>
                            </div>
                            <div class="modal fade" id="anons{{ $announcement->id }}DescriptionModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div style="color: #1b1e21" class="modal-header">
                                            <h5 class="modal-title" id="buyModalLabel">Описание анонса</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div style="color: #1b1e21" class="modal-body">
                                            @if($announcement->description != null)
                                                {{$announcement->description}}
                                            @else
                                                Нет описания
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Закрыть
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            @if($announcement->artwork->user->id==Auth::id())
                                <div class="book-author-control col-md-5">
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#publishAnons{{ $announcement->id }}Modal">
                                            <span class="read-block">Опубликовать</span>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="publishAnons{{ $announcement->id }}Modal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div style="color: #1b1e21" class="modal-header">
                                                    <h5 class="modal-title" id="buyModalLabel">Опубликовать</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div style="color: #1b1e21" class="modal-body">
                                                    Выберите файл публикуемой главы
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <form class="form-inline" method="POST"
                                                              action="{{ route('googleUploadFile') }}"
                                                              enctype="multipart/form-data">
                                                            <div class="col-sm-8">
                                                                <div class="custom-file">
                                                                    <label class="custom-file-label"
                                                                           for="InputFile"></label>
                                                                    <input type="file" name="text"
                                                                           class="custom-file-input"
                                                                           placeholder="Выберите файл">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="anons_id"
                                                                           value={{ $announcement->id }}>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="title"
                                                                           value={{ $announcement->title }}>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="description"
                                                                           value={{ $announcement->description }}>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="price"
                                                                           value={{ $announcement->price }}>
                                                                </div>

                                                            </div>

                                                            <div class="text-right col-sm-4">
                                                                <button style="text-align: right" type="submit"
                                                                        class="btn btn-success btn-md text-right">ОК
                                                                </button>
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Отмена
                                                                </button>
                                                            </div>
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#cancelAnnouncement{{ $announcement->id }}Modal">
                                            <span class="download-block">Отменить</span>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="cancelAnnouncement{{ $announcement->id }}Modal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div style="color: #1b1e21" class="modal-header">
                                                    <h5 class="modal-title" id="buyModalLabel">Отмена анонса главы</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div style="color: #1b1e21" class="modal-body">
                                                    Вы уверены что хотите отменить данный анонс?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-info"
                                                       href="{{ route('deleteAnons', ['id'=>$announcement->id]) }}">
                                                        <span class="buy-modal-block">Да</span>
                                                    </a>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Нет
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-5"></div>
                            @endif
                            <div class="book-action col-md-5">
                                @if(Auth::user()&&Auth::user()->buy_chapters->where('chapter_id', $announcement->id)->first() !=null)
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#cancelSponsorship{{ $announcement->id }}Modal">
                                            <span class="read-block">Отменить</span>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="cancelSponsorship{{ $announcement->id }}Modal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div style="color: #1b1e21" class="modal-header">
                                                    <h5 class="modal-title" id="buyModalLabel">Отмена спонсирования</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div style="color: #1b1e21" class="modal-body">
                                                    <p>Вы уверены что хотите отменить спонсирование данной главы?</p>
                                                    <p></p>
                                                    <p>Общая сумма спонсирования
                                                        составляет {{Auth::user()->purchase_transactions->whereIn('id', Auth::user()->buy_chapters->where('chapter_id', $announcement->id)->pluck('financial_operation_id'))->sum('amount') }}
                                                        у.е.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-info"
                                                       href="{{ route('cancelSponsorship', ['id'=>$announcement->id]) }}">
                                                        <span class="buy-modal-block">Да</span>
                                                    </a>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Нет
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="book_item-btn">
                                    @if(Auth::user()&&Auth::user()->id==$announcement->artwork->user->id)
                                        <a class="btn btn-info" href="{{ route('chapterFinancialOperations', ['id'=>$announcement->id, 'anons'=> true]) }}">
                                            <span class="read-block">Количество спонсирований: {{ $announcement->purchases->count() }}; Сумма: {{ $announcement->financial_operations->where('status_id', 3)->sum('amount') }}</span>
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#sponsor{{ $announcement->id }}Modal">
                                            <span class="read-block">Спонсировать</span>
                                        </button>
                                    @endif
                                </div>
                            <div class="modal fade" id="sponsor{{ $announcement->id }}Modal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div style="color: #1b1e21" class="modal-header">
                                            <h5 class="modal-title" id="buyModalLabel">Спонсирование главы</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @if(Auth::user()&&Auth::user()->balance - Auth::user()->sale_transactions->where('status_id', 3)->sum('amount') >= $announcement->min_amount)
                                            <div style="color: #1b1e21" class="modal-body">
                                                Вы уверены что хотите спонсировать данную главу?
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <form class="form-inline" method="POST"
                                                          action="{{ route('chapterSponsorship') }}">
                                                        <div class="form-group col-sm-4">
                                                            <input type="text" name="sponsor_sum" class="form-control"
                                                                   placeholder="Мин. сумма {{ $announcement->min_amount }} у.е.">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="anons_id"
                                                                   value={{ $announcement->id }}>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="user_id"
                                                                   value={{ Auth::user()->id }}>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="author_id"
                                                                   value={{ $announcement->artwork->user->id }}>
                                                        </div>

                                                        <div class="text-right col-sm-8">
                                                            <button style="text-align: right" type="submit"
                                                                    class="btn btn-success btn-md text-right">ОК
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Нет
                                                            </button>
                                                        </div>
                                                        {{ csrf_field() }}
                                                    </form>
                                                </div>
                                            </div>

                                        @elseif(Auth::user()&&Auth::user()->balance - Auth::user()->sale_transactions->where('status_id', 3)->sum('amount') < $announcement->min_amount)
                                            <div style="color: #1b1e21" class="modal-body">
                                                У вас недостаточно средств для спонсирования
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Отмена
                                                </button>
                                            </div>
                                        @else
                                            <div style="color: #1b1e21" class="modal-body">
                                                Для спонсирования главы необходимо войти на сайт
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-info" href="{{ url('/login/google') }}">
                                                    <span class="buy-modal-block">Войти</span>
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Отмена
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-10 book_item-text" style="margin: 1px"></div>
                            <hr color="white" style="margin: 0">
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="row">
                <div class="col-md-10" style="margin-top: 30px">
                    <div class="book_content-title">
                        <strong>Комментарии:</strong>
                    </div>
                    <div id="disqus_thread"></div>
                    <script>

                        /**
                         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

                        var disqus_config = function () {
                            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                        };

                        (function () { // DON'T EDIT BELOW THIS LINE
                            var d = document, s = d.createElement('script');
                            s.src = 'https://http-bookmake-loc.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                </div>
            </div>


        </div> <!-- /container -->
    </main>

@endsection