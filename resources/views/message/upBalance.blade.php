@extends('layouts.site')

@section('content')
    <main role="main">

        <div class="container">
            <!-- row of columns -->
            <div class="row">

                <div class="col-md-12">
                    <div class="title default">
                        <h3>Пополнение счета</h3>
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
                        <div>
                            <p><strong>Для пополнения выполните следующие действия:</strong></p>
                            <ul>
                                <li>переведите сумму на которую вы желаете пополнить баланс, на карту **** **** **** **** </li>
                                <li>сделайте скриншот чека и укажите файл изображения ниже</li>
                                <li>укажите в поле ввода сумму пополнеия</li>
                                <li>после проверки действительности платежа администратором и соответствия указанной суммы с переведенной, к вашему балансу будет добавленна сумма платежа</li>
                            </ul>
                        </div>

                    <form method="POST" action="{{ route('userBalanceUp') }}" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputTitle">Сумма платежа</label>
                            <input type="text" class="form-control" name="sum" value="{{ old('title') }}" aria-describedby="emailHelp" placeholder="Введите название главы">
                        </div>
                        <div class="custom-file">
                            <label class="custom-file-label" for="InputImage">Чек</label>
                            <input type="file" name="check" class="custom-file-input" placeholder="Выберите файл">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value={{ Auth::id() }}>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="type" value='4'>
                        </div>

                        <div class="text-right">
                            <button style="text-align: right" type="submit" class="btn btn-success btn-md text-right">Отправить</button>
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