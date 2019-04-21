@extends('layouts.site')

@section('content')
    <main role="main">

        <hr>
        <div class="container">
            <!-- row of columns -->
            <div class="row">


                <div class="col-lg-9">


                    <article class="part-block">
                        <div class="preloaderFilter none">
                            <div class="preloaderWrapper">
                                <i class="fi flaticon-loading"></i>
                            </div>
                        </div>
                        <div class="title default">
                            <h2 style="color: #495057">{{$chapter->artwork->title}}</h2>
                            <h4 style="color: #495057">{{$chapter->title}}</h4>
                        </div>
                        <div>
                            @if($content)
                            <p>{!!$content!!}</p>
                                @else
                                <p>Данная глава временно недоступна</p>
                            @endif
                       </div>
                    </article>
                    <div class="col-md-12 text-center">
                        <div class="adsense-bottom" style="margin-bottom: 5px;">
                            <div class="adsense-block"><ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-format="fluid" data-ad-layout="in-article" data-ad-client="ca-pub-7505887367641385" data-ad-slot="8181392956" data-adsbygoogle-status="done"></ins>
                            </div>
                        </div>
                    </div>
                    <div align="center">
                    <ul class="default navigation-bottom" style="align:center; margin-left:10px">
                            @if($previous_chapter)
                            <a style="margin-left:10px" class="btn btn-outline-dark" href="{{ route('chapterShow', ['id'=>$previous_chapter->id]) }}">
                                <i class="btn-icon-nav fi flaticon-left-arrow"></i>
                                <span>Предыдущая</span>
                            </a>
                            @endif
                            <a style="margin-left:10px" class="btn btn-outline-dark" href="{{ route('bookShow', ['id'=>$chapter->artwork->id]) }}">
                                <i class="btn-icon-nav fi flaticon-open-book"></i>
                                <span>Оглавление</span>
                            </a>
                            @if($next_chapter)
                            <a style="margin-left:10px" class="btn btn-outline-dark btn-nav-right" href="{{ route('chapterShow', ['id'=>$next_chapter->id]) }}">
                                <i class="btn-icon-nav fi flaticon-arrow-pointing-to-right"></i>
                                <span>Следующая</span>
                            </a>
                            @endif
                    </ul>
                    </div>
                </div>
          </div>
      </div>

        </div>


        </div> <!-- /container -->
    </main>

@endsection