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
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary mr-2"><i class="fas fa-pen"></i></a>
                                            <button type="button" onclick="openModal({{ "deleteModal" . $user->id }});" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
