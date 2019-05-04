@extends('layouts.site')

@section('content')
    <main role="main">

      <hr>
      <div class="container">
        <!-- row of columns -->
        <div class="row">


          <div class="col-md-12">
            <div class="title default">
              @if(Auth::user()&&$author->id==Auth::user()->id)
              <h2>Мои произвидения</h2>
              <div class="book_add-btn">
                <a class="btn btn-success" href="{{ route('addArtwork') }}">
                  <span class="read-bloc">Добавить произвидение</span>
                </a>
              </div>
              @else
                <h2>Произвидения автора {{$author->name}}</h2>
              @endif
            </div>
            <hr>
          </div>

            @foreach($artworks as $artwork)
            <div class="col-md-3 col-sm-4 col-xs-6 book-block">
              <div class="renewal-item">
                <div class="renewal-img">
                    <img class="book-img-main" alt="Шериф" src="{{ \Storage::disk('public')->url($artwork->image->img_link) }}">
                </div>
              </div>
                <div class="renewal-bottom">
                    <div class="vote-default">
                      <span data-tip="Понравилось" data-for="rating-tooltip" class="vote__item vote-green " currentitem="false">
                        <img class="ico-voice" src="/icn/like.png" ><span color="green">{{ $artwork->likes }}  </span>
                      </span>
                      <span data-tip="Не понравилось" data-for="rating-tooltip" class="vote__item vote-red " currentitem="false">
                        <img class="ico-voice" src="/icn/dislike.png" ><span>{{ $artwork->dislikes }}</span>
                      </span>
                    </div>
                  <div align="right" ata-html="true" data-tip="Просмотры " class="watch" currentitem="false">
                    <img class="ico-voice" src="/icn/view.png" ><span>{{ $artwork->views }}</span>
                  </div>
                </div>
                <h4 style="color: #008080"><a  href="{{ route('bookShow', ['id'=>$artwork->id]) }}">{{ $artwork->title }}</a></h4>
             </div>
            @endforeach
        </div>

        <hr>
      </div> <!-- /container -->
    </main>

@endsection