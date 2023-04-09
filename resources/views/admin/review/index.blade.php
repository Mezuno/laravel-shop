@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Отзывы</h1>
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

    <!-- Content filter -->
    <div class="ml-3 p-3 pr-0 alert alert-default-dark d-inline-block">
        <div class="">
            <h3>Фильтр</h3>
            <form action="{{ route('review.index') }}" class="w-100 d-flex" id="filter_form">
                <input type="text" name="filter" value="true" hidden>

                <div class="form-group d-flex flex-column">
                    <label>Пользователь</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" name="user" value="{{ app('request')->input('user') }}" placeholder="ID, email или имя">
                </div>

                <div class="form-group d-flex flex-column ml-2">
                    <label>Товар</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" name="product" value="{{ app('request')->input('product') }}" placeholder="Артикул или название">
                </div>

                <div class="form-group d-flex flex-column ml-2">
                    <label>Заголовок</label>
                    <input class="me-2 p-2 rounded-2 border flex-grow-1" type="text" name="title" value="{{ app('request')->input('title') }}" placeholder="Заголовок">
                </div>

                <div class="form-group d-flex flex-column ml-2">
                    <label>Сколько записей</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей">
                </div>

                <div class="form-group d-flex flex-column ml-2">
                    <label>Оценка от</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="rate_from" value="{{ app('request')->input('rate_from') }}" placeholder="Оценка от">
                </div>

                <div class="form-group d-flex flex-column ml-2">
                    <label>Оценка до</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="rate_to" value="{{ app('request')->input('rate_to') }}" placeholder="Оценка до">
                </div>

            </form>

            <div class="d-flex justify-content-between align-items-end">
                <div class="d-flex flex-column">
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="confirmed_true" class="custom-control-input" id="customSwitch1" @if(app('request')->input('confirmed_true') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch1">Подтвержденные</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="confirmed_false" class="custom-control-input" id="customSwitch2" @if(app('request')->input('confirmed_false') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch2">Не подтвержденные</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="deleted" class="custom-control-input" id="customSwitch3" @if(app('request')->input('deleted') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch3">Удаленные</label>
                    </div>
                </div>
                <div class="form-group d-flex flex-column m-0 justify-content-end">
                    <button form="filter_form" class="btn btn-dark flex-grow-0" value="Поиск">Применить</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-filter -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="d-inline text-dark text-black">{{ $reviews->withQueryString()->links() }}</div>
                    <div class="card">

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="align-text-bottom">ID</th>
                                    <th class="align-text-bottom">Пользователь</th>
                                    <th class="align-text-bottom">Товар</th>
                                    <th class="align-text-bottom">Заголовок</th>
                                    <th class="align-text-bottom">Оценка</th>
                                    <th class="align-text-bottom">Публикация</th>
                                    <th class="align-text-bottom">Дата</th>
                                    <th class="align-text-bottom">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        <td class="align-text-bottom pl-4">{{ $review->id }}</td>
                                        <td class="align-text-bottom"><a href="{{ route('user.show', $review->user->id) }}">{{ $review->user->email }}</a></td>
                                        <td class="align-text-bottom"><a href="{{ route('product.show', $review->product->id) }}">{{ $review->product->title }}</a></td>
                                        <td class="align-text-bottom"><a href="{{ route('review.show', $review->id) }}">{{ mb_strimwidth($review->title, 0, 60, "...") }}</a></td>
                                        <td class="align-text-bottom">
                                            @for($i = 0; $i < $review->rate; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </td>
                                        <td class="align-text-bottom">
                                            @if ($review->confirmed_at)
                                                <p class="p-0 pl-2 alert alert-default-success">{{ $review->confirmed_at }}</p>
                                            @else
                                                <p class="p-0 pl-2 alert alert-default-warning">Требует проверки</p>
                                            @endif
                                        </td>
                                        <td class="align-text-bottom">{{ $review->created_at }}</td>
                                        <td class="align-text-bottom">
                                            @if(!$review->deleted_at)
                                                <a href="{{ route('review.show', $review->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$review->confirmed_at)
                                                    <form action="{{ route('review.confirm', $review->id) }}" method="post" class="p-0 d-inline">
                                                        @csrf
                                                        @method('patch')
                                                        <button class="btn btn-outline-success "><i class="fas fa-check"></i></button>
                                                    </form>
                                                @endif
                                                <button type="button" onclick="openModal({{ "deleteModal" . $review->id }});" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $review->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('review.restore', $review->id) }}" method="post" class="p-0 d-inline">
                                                    @csrf
                                                    @method('patch')
                                                    <button class="btn btn-warning"><i class="fas fa-undo"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @foreach($reviews as $review)
        <!-- Modal -->
        <div onclick="openModal({{ "deleteModal" . $review->id}})" class="deleteModal d-none" id="deleteModal{{ $review->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        Вы действительно хотите удалить отзыв с id{{ $review->id }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                        <form action="{{ route('review.delete', $review->id) }}" method="post" class="p-0 d-inline">
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
