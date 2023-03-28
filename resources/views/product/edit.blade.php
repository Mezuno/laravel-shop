@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary mb-3"><i class="fas fa-arrow-left"></i>&nbsp&nbspВсе товары</a>
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary mb-3">Страница товара</a>
                    <h1 class="m-0">Редактировать товар id{{ $product->id }}</h1>
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
                <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <input type="text" name="title" value="{{ old('title') ?? $product->title  }}" class="form-control" placeholder="Наименование" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" value="{{ old('description') ?? $product->description }}" class="form-control" placeholder="Описание">
                    </div>
                    <div class="form-group">
                        <textarea name="content" class="form-control" placeholder="Контент">{{ old('content') ?? $product->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="number" max="100000" name="price" value="{{ old('price') ?? $product->price }}" class="form-control" placeholder="Цена">
                    </div>
                    <div class="form-group">
                        <input type="text" name="count" value="{{ old('count') ?? $product->count }}" class="form-control" placeholder="Количество в наличии">
                    </div>
                    <div class="form-group">
                        <select name="category_id" class="form-control select2" style="width: 100%;">
                            <option selected="selected" disabled>Выберите категорию</option>
                            @foreach($categories as $category)
                                <option @if($product->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="tags[]" class="tags" multiple="multiple" data-placeholder="Добавить тег" style="width: 100%;">
                            @foreach($tags as $tag)
                                @foreach($product->tags as $productTag)
                                    @if($productTag->id == $tag->id)
                                        {{ $selected = 'selected' }}
                                        @break
                                    @else
                                        {{ $selected = '' }}
                                    @endif
                                @endforeach
                                <option {{ $selected ?? '' }} value="{{ $tag->id }}">{{ $tag->title }}</option>
                                    {{ $selected = '' }}
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="preview_image" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="product_images[]" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="product_images[]" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="product_images[]" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
