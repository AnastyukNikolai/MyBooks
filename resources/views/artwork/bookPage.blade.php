@extends('layouts.site')

@section('content')
    <main role="main" class="content">

        <hr>
        <div class="container">
            <!-- row of columns -->




                <div class="row book-main-block">
                    <div class="col-md-4" style="padding-right: 5%">
                        <div class="book-photo text-center">
                            <div class="image-wrapper">
                                <img alt="{{ $artwork->title }}" src="{{ \Storage::disk('public')->url($artwork->image->image_path) }}" class="book-img">
                            </div>
                        </div>
                        <div class="book_read text-center default" style="margin-top: 10px">
                            @if($first_chapter)
                            <a href="{{ route('chapterShow', ['id'=>$first_chapter->id]) }}" class="btn btn-outline-warning btn-lg my-2 my-sm-0" role="button" aria-pressed="true">
                                <span>Начать читать</span>
                            </a>
                                @endif
                        </div>
                    </div>
                    <div class="book__cont col-md-5">
                        <h2 style="color: #008080; text-align: center; margin-top: 5px" class="book-heading">{{ $artwork->title }}</h2>
                        <hr color="green" height="bold">
                        <div class="book__info default">
                            <div class="book__block-name">Автор: </div>
                            <div align="right" class="book__block-time pull-right">
                                <a href="{{ route('artworksShow', ['id'=>$artwork->user->id]) }}">{{ $artwork->user->name }}</a>
                            </div>
                            <hr color="green">
                        <div class="book__block-item book__block-star clearfix">
                            <div class="book__block-name">Опубликовано:</div>
                            <div align="right" class="book__block-time time-green pull-right">{{$artwork->created_at}}</div>
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
                                <div class="book__block-genre">
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
                            <img class="book-info-icn" src="{{ \Storage::disk('public')->url($artwork->language->image->image_path) }}" class="country-img" alt="{{ $artwork->language->title }}">
                        </div>
                            <hr color="green">
                        <div class="book__block-item">
                            <div class="book__block-name">Рейтинг книги:</div>

                            <div class="vote-book" style="align: right">
                               <span data-tip="Понравилось" data-for="rating-tooltip" class="vote__item vote-green " currentitem="false">
                                    <img class="book-info-icn" src="/icn/like.png" ><span color="#218838">{{ $artwork->likes }}</span>
                               </span>
                                <span data-tip="Не понравилось" data-for="rating-tooltip" class="vote__item vote-red " currentitem="false">
                                    <img class="book-info-icn" src="/icn/dislike.png" ><span>{{ $artwork->dislikes }}</span>
                                </span>
                            </div>
                        </div>
                            <hr color="green">
                     </div>
                 </div>
             </div>


                <div class="row">
                    <div class="col-md-9" style="padding: 0">
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
                                <p>Статус произведения:&nbsp;{{ $artwork->status }}</p>
                                <p></p>
                                @if($artwork->chapters!=null)
                                <p>Количество глав: {{ $artwork->chapters->where('announcement', false)->count() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="book_content default">
                            <div class="book_content-title">
                                <strong>Содеражание:</strong>
                            </div>
                            <div class="book_content-item">
                                <div class="book_content-table">
                                    @if(Auth::user()&&Auth::user()->id==$artwork->user_id)
                                        <div class="chapter_add_btn">
                                        <a class="btn btn-outline-success btn-block " href="{{ route('addArtworkChapter', ['id'=>$artwork->id]) }}">Добавить главу</a>
                                        </div>
                                        <hr>
                                    @endif
                                    @foreach($chapters as $chapter)
                                    <div class="book_item">
                                        <div class="book_item-text">
                                            <div class="book__item-wrapper" style="vertical-align: middle">
                                                <div class="book_chapter-title">
                                                <a  class="btn btn-link book_chapter-title" href="{{ route('chapterShow', ['id'=>$chapter->id]) }}">
                                                    <strong>{{$chapter->title}}</strong>
                                                </a>
                                                </div>
                                                    @if($chapter->artwork->user==Auth::user())
                                                        <div class="book-author-control">
                                                            <div class="book_item-btn">
                                                                <a class="btn btn-warning" href="{{ route('editArtworkChapter', ['id'=>$chapter->id]) }}">
                                                                    <i class="icon-arrow"></i>
                                                                    <span class="read-block">Изменить</span>
                                                                </a>
                                                            </div>
                                                            <div class="book_item-btn">
                                                                <a class="btn btn-danger" href="{{ route('downloadChapter', ['chapter'=>$chapter]) }}">
                                                                    <i class="icon-arrow"></i>
                                                                    <span class="download-block">Удалить</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                            </div>
                                            @if($chapter->price==0||$chapter->users->find(Auth::user()==true)||$chapter->artwork->user==Auth::user())
                                            <div class="book-action">
                                            <div class="book_item-btn">
                                                <a class="btn btn-success" href="{{ route('chapterShow', ['id'=>$chapter->id]) }}">
                                                    <i class="icon-arrow"></i>
                                                    <span class="read-block">Читать</span>
                                                </a>
                                            </div>
                                                <div class="book_item-btn">
                                                <a class="btn btn-primary" href="{{ route('downloadChapter', ['chapter'=>$chapter]) }}">
                                                    <i class="icon-arrow"></i>
                                                    <span class="download-block">Скачать</span>
                                                </a>
                                            </div>
                                            </div>
                                                @else
                                                <div class="book-action">
                                                    <div class="book_item-btn">
                                                        <span class="read-block">{{ $chapter->price }} у.е.</span>
                                                    </div>
                                                    <div class="book_item-btn">
                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#buyModal">
                                                            <span class="read-block">Купить главу</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div style="color: #1b1e21" class="modal-header">
                                                                <h5 class="modal-title" id="buyModalLabel">Покупка главы</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @if(Auth::user()&&Auth::user()->balance>=$chapter->price)
                                                            <div style="color: #1b1e21" class="modal-body">
                                                                Вы уверены что хотите приобрести данную главу?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a class="btn btn-info" href="{{ route('chapterBuy', ['id'=>$chapter->id]) }}">
                                                                    <span class="buy-modal-block">Да</span>
                                                                </a>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                                                            </div>
                                                                @elseif(Auth::user()&&Auth::user()->balance<$chapter->price)
                                                                <div style="color: #1b1e21" class="modal-body">
                                                                    У вас недостаточно средств для покупки данной главы
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                                </div>
                                                                @else
                                                                <div style="color: #1b1e21" class="modal-body">
                                                                    Для покупки главы необходимо войти на сайт
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a class="btn btn-info" href="{{ url('/login/google') }}">
                                                                        <span class="buy-modal-block">Войти</span>
                                                                    </a>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                        <hr color="white" style="margin: 0">
                                        @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="book_content default">
                            <div class="book_content-title">
                                <strong>Анонсы:</strong>
                            </div>
                            <div class="book_content-item">
                                <div class="book_content-table">
                                    @if(Auth::user()&&Auth::user()->id==$artwork->user_id)
                                        <div class="chapter_add_anons_btn">
                                            <a class="btn btn-outline-success btn-block " href="{{ route('addChapterAnons', ['id'=>$artwork->id]) }}">Добавить анонс главы</a>
                                        </div>
                                        <hr>
                                    @endif
                                    @foreach($announcements as $announcement)
                                        <div class="book_item">
                                            <div class="book_item-text">
                                                <div class="book__item-wrapper" style="vertical-align: middle">
                                                    <div class="book_chapter-title">
                                                        <a  class="btn btn-link book_chapter-title" data-toggle="modal" data-target="#descriptionModal">
                                                            <strong>{{$announcement->title}}</strong>
                                                        </a>
                                                    </div>
                                                    <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($announcement->artwork->user==Auth::user())
                                                        <div class="book-author-control">
                                                            <div class="book_item-btn">
                                                                <a class="btn btn-warning" href="{{ route('editChapter', ['id'=>$announcement->id]) }}">
                                                                    <span class="read-block">Опубликовать главу</span>
                                                                </a>
                                                            </div>
                                                            <div class="book_item-btn">
                                                                <a class="btn btn-danger" href="{{ route('deleteChapter', ['id'=>$announcement->id]) }}">
                                                                    <span class="download-block">Удалить</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                    <div class="book-action">
                                                        <div class="book_item-btn">
                                                            <span class="read-block">{{ $announcement->min_amount }} у.е.</span>
                                                        </div>
                                                        <div class="book_item-btn">
                                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#sponsorModal">
                                                                <span class="read-block">Спонсировать</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="sponsorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div style="color: #1b1e21" class="modal-header">
                                                                    <h5 class="modal-title" id="buyModalLabel">Спонсирование главы</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                @if(Auth::user()&&Auth::user()->balance >= $announcement->min_amount)
                                                                    <div style="color: #1b1e21" class="modal-body">
                                                                        Вы уверены что хотите приобрести данную главу?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a class="btn btn-info" href="{{ route('chapterBuy', ['id'=>$announcement->id]) }}">
                                                                            <span class="buy-modal-block">Да</span>
                                                                        </a>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                                                                    </div>
                                                                @elseif(Auth::user()&&Auth::user()->balance < $announcement->min_amount)
                                                                    <div style="color: #1b1e21" class="modal-body">
                                                                        У вас недостаточно средств для спонсирования
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                                    </div>
                                                                @else
                                                                    <div style="color: #1b1e21" class="modal-body">
                                                                        Для спонсирования главы необходимо войти на сайт
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a class="btn btn-info" href="{{ url('/login/google') }}">
                                                                            <span class="buy-modal-block">Войти</span>
                                                                        </a>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <hr color="white" style="margin: 0">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            <div class="row">
                <div class="col-md-9">
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

                            (function() { // DON'T EDIT BELOW THIS LINE
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