@extends('layouts.site')

@section('content')
    <main role="main">

        <div class="container">
            <!-- row of columns -->
            <div class="row">
                @if($filter_table == null&&$filter_id == null)
                    <div style="color: white">{{ $filter_table = 'a' }}{{ $filter_id = 'a' }}</div>
                @endif
                @if($search_request == null)
                    <div style="color: white">{{ $search_request = 'a'  }}</div>
                @endif


                <div class="col-md-12">
                    <div class="row">
                        <div class="title default col-7">
                            <h3>{{ $message }}</h3>
                        </div>
                        <div class="col-5" id="sort" style="text-align: right; margin-top: auto">
                            <div class="log-reg">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item dropdown dropdown-header">
                                        <a style="margin: 10px; padding: 5px"
                                           class="nav-link dropdown-toggle btn-outline-warning"
                                           href="http://example.com" id="dropdown01" data-toggle="dropdown"
                                           aria-haspopup="true"
                                           aria-expanded="false"><span><strong>Сортировать по:</strong></span></a>
                                        <div style="text-align: center;text-decoration: none; background-color: white; color: black"
                                             id="drop-menu-items" class="dropdown-menu"
                                             aria-labelledby="dropdown01">
                                            <hr style="margin: 5px">
                                            <a class="dropdown-item"
                                               href="{{ route('filterAndSort', ['table'=>$filter_table, 'id'=>$filter_id, 'search'=>$search_request, 'sort_param'=>'likes']) }}">
                                                Популярности</a>
                                            <hr style="margin: 5px">
                                            <a class="dropdown-item"
                                               href="{{ route('filterAndSort', ['table'=>$filter_table, 'id'=>$filter_id, 'search'=>$search_request, 'sort_param'=>'views']) }}">
                                                Просмотрам</a>
                                            <hr style="margin: 5px">
                                            <a class="dropdown-item"
                                               href="{{ route('filterAndSort', ['table'=>$filter_table, 'id'=>$filter_id, 'search'=>$search_request, 'sort_param'=>'reviews']) }}">
                                                Отзывам</a>
                                            <hr style="margin: 5px">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                @if($artworks->count() > 0)
                    @foreach($artworks as $artwork)
                        <div class="col-md-3 col-sm-4 col-xs-6 book-block">
                            <div class="renewal-item">
                                <div class="renewal-img">
                                    <img class="book-img-main" alt="{{ $artwork->title }}"
                                         src="{{ \Storage::disk('public')->url($artwork->image->image_path) }}">
                                </div>
                            </div>
                            <div class="renewal-bottom">
                                <div class="vote-default">
                      <span data-tip="Понравилось" data-for="rating-tooltip" class="vote__item vote-green "
                            currentitem="false">
                        @if(Auth::check()&&Auth::user()->liked->where('id', $artwork->id)->first() == true)
                              <img class="book-info-icn" src="/icn/heart.png"><span
                                      style="color: #218838">{{ $artwork->likers->count() }}</span>
                          @else
                              <img class="book-info-icn" src="/icn/like.png"><span
                                      style="color: #218838">{{ $artwork->likers->count() }}</span>
                          @endif
                      </span>
                                </div>
                                <div align="right" ata-html="true" data-tip="Просмотры " class="watch"
                                     currentitem="false">
                                    <img class="ico-voice" src="/icn/view.png"><span>{{ $artwork->views }}</span>
                                </div>
                            </div>
                            <h4 style="color: #218838;text-decoration: none"><a style="color: #218838"
                                href="{{ route('bookShow', ['id'=>$artwork->id]) }}">{{ $artwork->title }}</a>
                                @if($artwork->chapters->sortBy('created_at')->first()!=null)
                                    - {{$artwork->chapters->where('created_at', $artwork->chapters->where('announcement', false)->max('created_at'))->first()->created_at}}
                                @endif
                            </h4>
                        </div>
                    @endforeach
                @else
                    <h5>Поиск не дал результатов</h5>
                @endif
            </div>


        </div> <!-- /container -->
    </main>

@endsection