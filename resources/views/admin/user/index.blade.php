@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пользователи</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Пользователи</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Content filter -->
    <div class="ml-3 p-3 pr-0 alert alert-dark d-inline-block">
        <div class="">
            <h3>Фильтр</h3>
            <form action="{{ route('user.index') }}" class="w-100 d-flex flex-wrap" id="filter_form">
                <input type="text" name="filter" value="true" hidden>
                <div class="form-group d-flex flex-column">
                    <label>ID</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="id" value="{{ app('request')->input('id') }}" placeholder="ID">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Имя</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" name="name" value="{{ app('request')->input('name') }}" placeholder="Имя">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Фамилия</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" name="surname" value="{{ app('request')->input('surname') }}" placeholder="Фамилия">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Отчество</label>
                    <input class="me-2 p-2 rounded-2 border flex-grow-1" type="text" name="patronymic" value="{{ app('request')->input('patronymic') }}" placeholder="Отчество">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Email</label>
                    <input class="me-2 p-2 rounded-2 border flex-grow-1" type="text" name="email" value="{{ app('request')->input('email') }}" placeholder="Email">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Сколько записей</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Возраст</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="age" value="{{ app('request')->input('age') }}" placeholder="Возраст">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Пол</label>
                    <select class="form-control" name="gender">
                        <option value="" selected>Все</option>
                        <option value="1" @if(app('request')->input('gender') == 1) selected @endif>Мужской</option>
                        <option value="2" @if(app('request')->input('gender') == 2) selected @endif>Женский</option>
                    </select>
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_address">Адрес</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" id="filter_address" name="address" value="{{ app('request')->input('address') }}" placeholder="Адрес">
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-end">
                <div class="d-flex flex-column">
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="deleted" class="custom-control-input" id="customSwitch3" @if(app('request')->input('deleted') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch3">Удаленные</label>
                    </div>
                </div>
                <div class="d-flex">
                    @if( app('request')->input('filter') === 'true')
                        <a href="{{ route('user.index') }}" class="btn btn-dark mr-2 text-decoration-none">Сбросить фильтры</a>
                    @endif
                    <div class="form-group d-flex flex-column m-0 justify-content-end">
                        <button form="filter_form" class="btn btn-dark flex-grow-0" value="Поиск">Применить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    {{ $users->withQueryString()->links() }}
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('user.create') }}" class="btn btn-primary">Добавить</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Фамилия</th>
                                    <th>Отчество</th>
                                    <th>Возраст</th>
                                    <th>Пол</th>
                                    <th>Адрес</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->surname }}</td>
                                        <td>{{ $user->patronymic }}</td>
                                        <td>{{ $user->age }}</td>
                                        <td>@if($user->gender){{ $user->genderTitle }}@endif</td>
                                        <td>{{ $user->address }}</td>
                                        <td class="d-flex">
                                        @if(!$user->deleted_at)
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary mr-2"><i class="fas fa-pen"></i></a>
                                            <button type="button" onclick="openModal({{ "deleteModal" . $user->id }});" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <form action="{{ route('user.restore', $user->id) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <button class="btn btn-warning">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
{{--                            {{ $categories->withQueryString()->links() }}--}}
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @foreach($users as $user)
        <!-- Modal -->
        <div onclick="openModal({{ "deleteModal" . $user->id}})" class="deleteModal d-none" id="deleteModal{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        Вы действительно хотите удалить пользователя id{{ $user->id }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                        <form action="{{ route('user.delete', $user->id) }}" method="post" class="p-0 d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        function openModal(id) {
            if (id.classList.contains('d-none')) {
                id.classList.remove('d-none')
                id.classList.add('d-flex')
            } else {
                id.classList.remove('d-flex')
                id.classList.add('d-none')
            }
        }
    </script>

@endsection
