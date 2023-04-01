@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('tag.index') }}" class="btn btn-outline-primary mb-3"><i
                            class="fas fa-arrow-left"></i>&nbsp&nbspВернуться к тегам</a>
                    <h1 class="m-0">Тег</h1>
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
                    <div class="card">
                        <div class="card-header d-flex p-3">
                            <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-primary mr-3">Редактировать</a>
                            <button type="button" onclick="openModal({{ "deleteModal" . $tag->id }});"
                                    class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $tag->id }}">
                                Удалить
                            </button>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <tbody>
                                    <tr>
                                        <td>ID</td>
                                        <td>{{ $tag->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Наименование</td>
                                        <td>{{ $tag->title }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal -->
    <div onclick="openModal({{ "deleteModal" . $tag->id}})" class="deleteModal d-none"
         id="deleteModal{{ $tag->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить тег {{ $tag->title }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                    <form action="{{ route('tag.delete', $tag->id) }}" method="post" class="p-0 d-inline">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
