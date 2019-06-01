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

            <div class="row">
                <div class="col-md-10">
                        <div class="book_content-title">
                            <strong>Отзывы о книге "{{ $artwork->title }}":</strong>
                        </div>
                </div>
                <div class="col-md-2"></div>
            </div>

            @foreach($reviews as $review)
                <div class="row">
                    <div class="col-md-10" style="padding: 0">
                        <div class="book__description default">
                            <div class="book__description-heading">
                                <strong>Отзыв от <a href="#">{{ $review->user->name }}</a>:</strong>
                            </div>
                            <div>
                                <p>{{ $review->text }}<br></p>
                            </div>
                            <div class="book__description-heading">
                                <strong>Оценка книги:
                                    @if($review->assessment == 1)
                                        <div class="assessment_icn" title="Ужасно">
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                        </div>
                                    @elseif($review->assessment == 2)
                                        <div class="assessment_icn" title="Плохо">
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                        </div>
                                    @elseif($review->assessment == 3)
                                        <div class="assessment_icn" title="Неплохо">
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                        </div>
                                    @elseif($review->assessment == 4)
                                        <div class="assessment_icn" title="Хорошо">
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                        </div>
                                    @elseif($review->assessment == 5)
                                        <div class="assessment_icn" title="Отлично">
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                            <img class="book-info-icn" src="/icn/star.png"></a>
                                        </div>
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            @endforeach


        </div> <!-- /container -->
    </main>

@endsection