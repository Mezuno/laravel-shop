@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить товар</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Товары</a></li>
                        <li class="breadcrumb-item active">Создание</li>
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
                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    @if ($errors->has('title'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('title') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="title" value="{{ old('title') ?? '' }}" class="form-control"
                               placeholder="Наименование" required>
                    </div>

                    @if ($errors->has('description'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('description') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="description" value="{{ old('description') ?? '' }}"
                               class="form-control" placeholder="Описание">
                    </div>

                    @if ($errors->has('content'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('content') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <textarea name="content" class="form-control"
                                  placeholder="Контент">{{ old('content') ?? '' }}</textarea>
                    </div>

                    @if ($errors->has('price'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('price') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="number" max="100000" name="price" value="{{ old('price') ?? '' }}"
                               class="form-control" placeholder="Цена">
                    </div>

                    @if ($errors->has('count'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('count') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="number" name="count" value="{{ old('count') ?? '' }}" class="form-control"
                               placeholder="Количество в наличии">
                    </div>

                    @if ($errors->has('category_id'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('category_id') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <select name="category_id" class="form-control select2" style="width: 100%;">
                            <option selected="selected" disabled>Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($errors->has('tags'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('tags') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <select name="tags[]" class="tags" multiple="multiple" data-placeholder="Добавить тег"
                                style="width: 100%;">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($errors->has('preview_image'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('preview_image') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="preview_image" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('product_images'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('product_images') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
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
                        <input type="submit" class="btn btn-primary" value="Добавить">
                    </div>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
