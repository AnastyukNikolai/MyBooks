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
                        @if($first_chapter)
                            <a href="{{ route('chapterShow', ['id'=>$first_chapter->id]) }}"
                               class="btn btn-outline-warning btn-lg my-2 my-sm-0" role="button" aria-pressed="true">
                                <span>Начать читать</span>
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
                            <div class="book__block-name">Рейтинг книги:</div>

                            <div class="vote-book" style="align: right">
                               <span data-tip="Понравилось" data-for="rating-tooltip" class="vote__item vote-green "
                                     currentitem="false">
                                    <img class="book-info-icn" src="/icn/like.png"><span
                                           color="#218838">{{ $artwork->likes }}</span>
                               </span>
                                <span data-tip="Не понравилось" data-for="rating-tooltip" class="vote__item vote-red "
                                      currentitem="false">
                                    <img class="book-info-icn"
                                         src="/icn/dislike.png"><span>{{ $artwork->dislikes }}</span>
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
                            <strong>Содеражание:</strong>
                        </div>
                        <div class="book_content-item">
                            <div class="book_content-table">
                                @if(Auth::user()&&Auth::user()->id==$artwork->user_id)
                                    <div class="chapter_add_btn">
                                        <a class="btn btn-outline-success btn-block "
                                           href="{{ route('addArtworkChapter', ['id'=>$artwork->id]) }}">Добавить
                                            главу</a>
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
                            <div class="book_chapter-title col-md-10" style="text-align: center">
                                <a class="btn btn-link book_chapter-title"
                                   href="{{ route('chapterShow', ['id'=>$chapter->id]) }}">
                                    <strong>{{$chapter->title}}</strong>
                                </a>
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
                                                data-target="#deleteChapterModal">
                                            <span class="read-block">Удалить</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteChapterModal" tabindex="-1" role="dialog"
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
                            @if($chapter->price==0||Auth::user()&&$chapter->users->find(Auth::user()->id)==true||Auth::user()&&$chapter->artwork->users->find(Auth::user()->id)==true||$chapter->artwork->user==Auth::user())
                                <div class="book-action col-md-5">
                                    @if($chapter->trashed())
                                        <div class="book_item-btn">
                                            <button type="button" class="btn btn-dark" disabled>
                                                <span class="read-block">Удалена</span>
                                            </button>
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
                                                data-target="#buyModal">
                                            <span class="read-block">Купить главу</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="buyModal" tabindex="-1" role="dialog"
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
                        <div class="book_content-item">
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
                                <a class="btn btn-link book_chapter-title" data-toggle="modal"
                                   data-target="#descriptionModal">
                                    <strong>{{$announcement->title}}</strong>
                                </a>
                            </div>
                            <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog"
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
                                            {{$announcement->description}}
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
                                                data-target="#publishAnonsModal">
                                            <span class="read-block">Опубликовать</span>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="publishAnonsModal" tabindex="-1" role="dialog"
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
                                                data-target="#cancelAnnouncementModal">
                                            <span class="download-block">Отменить</span>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="cancelAnnouncementModal" tabindex="-1" role="dialog"
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
                            @endif
                            <div class="book-action col-md-5">
                                @if(Auth::user()&&Auth::user()->buy_chapters->where('chapter_id', $announcement->id)->first() !=null)
                                    <div class="book_item-btn">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#cancelSponsorshipModal">
                                            <span class="read-block">Отменить</span>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="cancelSponsorshipModal" tabindex="-1" role="dialog"
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
                                        <button type="button" class="btn btn-info" disabled>
                                            <span class="read-block">Количество спонсирований: {{ $announcement->purchases->count() }}</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#sponsorModal">
                                            <span class="read-block">Спонсировать</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="modal fade" id="sponsorModal" tabindex="-1" role="dialog"
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