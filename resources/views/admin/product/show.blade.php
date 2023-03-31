@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary mb-3"><i
                            class="fas fa-arrow-left"></i>&nbsp&nbspВернуться к товарам</a>
                    <a href="{{ route('order.index') }}" class="btn btn-outline-primary mb-3"><i
                            class="fas fa-arrow-left"></i>&nbsp&nbspВернуться к заказам</a>
                    @if(URL::previous() != URL::current())
                        <a href="{{ URL::previous() }}" class="btn btn-outline-primary mb-3">
                            <i class="fas fa-arrow-left"></i>&nbsp&nbspНазад
                        </a>
                    @endif
                    <h1 class="m-0">Товар</h1>
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
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary mr-3">Редактировать</a>
                            <button type="button" onclick="openModal({{ "deleteModal" . $product->id }});"
                                    class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $product->id }}">
                                Удалить
                            </button>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <td>Наименование</td>
                                    <td>{{ $product->title }}</td>
                                </tr>
                                <tr>
                                    <td>Описание</td>
                                    <td>{{ $product->description }}</td>
                                </tr>
                                <tr>
                                    <td>Контент</td>
                                    <td><p class="text-wrap" style="max-width: 1000px;">{{ $product->content }}</p></td>
                                </tr>
                                <tr>
                                    <td>Цена</td>
                                    <td>{{ $product->price }}$</td>
                                </tr>
                                <tr>
                                    <td>Количество в наличии</td>
                                    <td>{{ $product->count }}</td>
                                </tr>
                                <tr>
                                    <td>Публикация</td>
                                    <td>{{ $product->publishedStatus }}</td>
                                </tr>
                                <tr>
                                    <td>Категория</td>
                                    <td>{{ $product->category->title }}</td>
                                </tr>
                                <tr>
                                    <td>Теги</td>
                                    <td>
                                        @foreach($product->tags as $tag)
                                            <div class="text-primary"> {{ $tag->title }}</div>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Превью и остальные фото товара</td>
                                    <td>
                                        <img src="{{ URL::asset('storage/'.$product->preview_image) }}" width="200"
                                             height="200" alt="Изображение товара">
                                        @foreach($productImages as $productImage)
                                            <img src="{{ URL::asset('storage/'.$productImage->file_path) }}" width="200"
                                                 height="200" alt="Изображение товара">
                                        @endforeach
                                    </td>
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
    <div onclick="openModal({{ "deleteModal" . $product->id}})" class="deleteModal d-none"
         id="deleteModal{{ $product->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить товар с артикулом {{ $product->vendor_code }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                    <form action="{{ route('product.delete', $product->id) }}" method="post" class="p-0 d-inline">
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
