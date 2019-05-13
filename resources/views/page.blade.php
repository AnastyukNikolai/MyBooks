@extends('layouts.site')

@section('content')
    <main role="main">

      <hr>
      <div class="container">
        <!-- row of columns -->
        <div class="row">


          <div class="col-md-12">
            <div class="title default">
              <h2><img class="ico-main" src="../../../../icn/oo.png" >Обновление книг</h2>
            </div>
            <hr>
          </div>

            @foreach($artworks as $artwork)
            <div class="col-md-3 col-sm-4 col-xs-6 book-block">
              <div class="renewal-item">
                <div class="renewal-img">
                    <img class="book-img-main" alt="{{ $artwork->title }}" src="{{ \Storage::disk('public')->url($artwork->image->image_path) }}">
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
                <h4 style="color: #008080"><a  href="{{ route('bookShow', ['id'=>$artwork->id]) }}">{{ $artwork->title }}</a>
                  @if($artwork->chapters->max('number')!=null)
                    - {{$artwork->chapters->where('number', $artwork->chapters->where('announcement', false)->max('number'))->first()->title}}
                  @endif</h4>
             </div>
            @endforeach
        </div>


      </div> <!-- /container -->
    </main>

@endsection