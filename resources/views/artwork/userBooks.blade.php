@extends('layouts.site')

@section('content')
    <main role="main">

      <div class="container">
        <!-- row of columns -->
        <div class="row">


          <div class="col-md-12">
            <div class="title default">
              @if(Auth::user()&&$user->id==Auth::id())
              <h2>{{ $message1 }}</h2>
                @if($n)
              <div style="text-align: right" class="book_add-btn">
                <a class="btn btn-success" href="{{ route('addArtwork') }}">
                  <span class="read-bloc">Добавить произвидение</span>
                </a>
              </div>
                @endif
              @else
                <h2>{{ $message2 }} {{$author->name}}</h2>
              @endif
            </div>
            <hr>
          </div>

            @foreach($artworks as $artwork)
            <div class="col-md-3 col-sm-4 col-xs-6 book-block">
              <div class="renewal-item">
                <div class="renewal-img">
                    <img class="book-img-main" alt="Шериф" src="{{ \Storage::disk('public')->url($artwork->image->image_path) }}">
                </div>
              </div>
                <div class="renewal-bottom">
                    <div class="vote-default">
                      <span data-tip="Понравилось" data-for="rating-tooltip" class="vote__item vote-green " currentitem="false">
                       @if(Auth::user()->liked->where('id', $artwork->id)->first() == true)
                          <img class="book-info-icn" src="/icn/heart.png"><span
                                  style="color: #218838">{{ $artwork->likers->count() }}</span>
                        @else
                          <img class="book-info-icn" src="/icn/like.png"><span
                                  style="color: #218838">{{ $artwork->likers->count() }}</span>
                        @endif
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