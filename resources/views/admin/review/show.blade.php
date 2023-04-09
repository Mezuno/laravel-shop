@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('order.index') }}" class="btn btn-outline-primary mb-3"><i
                            class="fas fa-arrow-left"></i>&nbsp&nbspВернуться к отзывам</a>
                    @if(URL::previous() != URL::current())
                        <a href="{{ URL::previous() }}" class="btn btn-outline-primary mb-3">
                            <i class="fas fa-arrow-left"></i>&nbsp&nbspНазад
                        </a>
                    @endif
                    <h1 class="m-0">Отзыв</h1>
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
                            @if(!$review->deleted_at)
                                @if(!$review->confirmed_at)
                                    <form action="{{ route('review.confirm', $review->id) }}" method="post" class="p-0 d-inline">
                                        @csrf
                                        @method('patch')
                                        <button class="btn btn-outline-success "><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
                                <button type="button" onclick="openModal({{ "deleteModal" . $review->id }});"
                                        class="btn btn-outline-danger ml-2" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $review->id }}">
                                    Удалить
                                </button>
                            @else
                                <form action="{{ route('review.restore', $review->id) }}" method="post" class="p-0 d-inline">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-warning">Восстановить</button>
                                </form>
                            @endif
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td>{{ $review->id }}</td>
                                </tr>
                                <tr>
                                    <td>Пользователь</td>
                                    <td>
                                        <a href="{{ route('user.show', $review->user->id) }}">{{ $review->user->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Товар</td>
                                    <td>
                                        <a href="{{ route('product.show', $review->product->id) }}">{{ $review->product->title }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Артикул товара</td>
                                    <td>{{ $review->product->vendor_code }}</td>
                                </tr>
                                <tr>
                                    <td>Заголовок</td>
                                    <td><p class="text-wrap" style="max-width: 1000px;">{{ $review->title }}</p></td>
                                </tr>
                                <tr>
                                    <td>Достоинства</td>
                                    <td><p class="text-wrap" style="max-width: 1000px;">{{ $review->advantages }}</p></td>
                                </tr>
                                <tr>
                                    <td>Недостатки</td>
                                    <td><p class="text-wrap" style="max-width: 1000px;">{{ $review->flaws }}</p></td>
                                </tr>
                                <tr>
                                    <td>Текст отзыва</td>
                                    <td><p class="text-wrap" style="max-width: 1000px;">{{ $review->body }}</p></td>
                                </tr>
                                <tr>
                                    <td>Оценка</td>
                                    <td>
                                        @for($i = 0; $i < $review->rate; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td>Публикация</td>
                                    <td>{{ $review->confirmed_at }}</td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <td>Превью и остальные фото товара</td>--}}
{{--                                    <td>--}}
{{--                                        <img src="{{ URL::asset('storage/'.$review->preview_image) }}" width="200"--}}
{{--                                             height="200" alt="Изображение товара">--}}
{{--                                        @foreach($reviewImages as $reviewImage)--}}
{{--                                            <img src="{{ URL::asset('storage/'.$reviewImage->file_path) }}" width="200"--}}
{{--                                                 height="200" alt="Изображение товара">--}}
{{--                                        @endforeach--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
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
    <div onclick="openModal({{ "deleteModal" . $review->id}})" class="deleteModal d-none"
         id="deleteModal{{ $review->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
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
