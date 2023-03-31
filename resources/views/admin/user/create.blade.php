@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить пользователя</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Главная</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    @method('post')

                    @if ($errors->has('name'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('name') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="name" value="{{ old('name') ?? '' }}" class="form-control" placeholder="Имя" required>
                    </div>

                    @if ($errors->has('email'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('email') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') ?? '' }}" class="form-control" placeholder="Email" required>
                    </div>

                    @if ($errors->has('password'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('password') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="password" name="password" value="{{ old('password') ?? '' }}" class="form-control" placeholder="Пароль" required>
                    </div>

                    @if ($errors->has('password_confirmation'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('password_confirmation') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') ?? '' }}" class="form-control" placeholder="Подтвердите пароль" required>
                    </div>

                    @if ($errors->has('surname'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('surname') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="surname" value="{{ old('surname') ?? '' }}" class="form-control" placeholder="Фамилия">
                    </div>

                    @if ($errors->has('patronymic'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('patronymic') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="patronymic" value="{{ old('patronymic') ?? '' }}" class="form-control" placeholder="Отчество">
                    </div>

                    @if ($errors->has('age'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('age') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="number" name="age" value="{{ old('age') ?? '' }}" class="form-control" placeholder="Возраст">
                    </div>

                    @if ($errors->has('address'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('address') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="address" value="{{ old('address') ?? '' }}" class="form-control" placeholder="Адрес">
                    </div>

                    @if ($errors->has('gender'))
                        <div class="alert alert-default-danger w-100">
                            <ul>@foreach($errors->get('gender') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <select name="gender" class="custom-select form-control" id="exampleSelectBorder">
                            <option disabled selected>Пол</option>
                            <option {{ old('gender') == 1 ? ' selected ' : '' }} value="1">Мужской</option>
                            <option {{ old('gender') == 2 ? ' selected ' : '' }} value="2">Женский</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Добавить">
                    </div>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
