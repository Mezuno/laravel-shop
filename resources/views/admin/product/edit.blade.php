@extends('admin.layouts.main')

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
                        <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Товары</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.show', $product->id) }}">{{ $product->vendor_code }}</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
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
            <div class="row d-flex flex-wrap">
                <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data" class=" col-sm-6">
                    @csrf
                    @method('patch')


                    @if ($errors->has('title'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('title') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="title" value="{{ old('title') ?? $product->title  }}" class="form-control" placeholder="Наименование" required>
                    </div>

                    @if ($errors->has('description'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('description') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="description" value="{{ old('description') ?? $product->description }}" class="form-control" placeholder="Описание">
                    </div>

                    @if ($errors->has('content'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('content') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <textarea name="content" class="form-control" placeholder="Контент">{{ old('content') ?? $product->content }}</textarea>
                    </div>

                    @if ($errors->has('price'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('price') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="number" max="100000" name="price" value="{{ old('price') ?? $product->price }}" class="form-control" placeholder="Цена">
                    </div>

                    @if ($errors->has('count'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('count') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="number" name="count" value="{{ old('count') ?? $product->count }}" class="form-control" placeholder="Количество в наличии">
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
                                <option @if($product->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($errors->has('tags'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('tags') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
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

                    @if ($errors->has('preview_image'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('preview_image') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <img style="max-width: 200px;" src="{{ URL::asset('storage/'.$product->preview_image) }}" alt="Превью фото товара id{{ $product->id }}">
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="preview_image" type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">@if(isset($product->preview_image)) {{ $product->preview_image }} @else Выберите файл @endif </label>
                            </div>
                        </div>
                    </div>


                    <div class="custom-control custom-switch">
                        <input @if($product->is_published) checked @endif name="is_published" type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Опубликовано</label>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                </form>


                <div class="d-flex flex-column col-sm-6">


                    @if ($errors->has('product_image'))
                        <div class="alert alert-danger w-100">
                            <ul>@foreach($errors->get('product_image') as $message)<li>{{$message}}</li>@endforeach</ul>
                        </div>
                    @endif

                    @if($productImagesCount !== 0)
                        @foreach($productImages as $productImage)

                            <form class="d-inline-block" action="{{ route('product.image.update', ['product' => $product, 'productImage' => $productImage]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <img style="max-width: 200px;" src="{{ URL::asset('storage/'.$productImage->file_path) }}" alt="Фото товара id{{ $productImage->id }}">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="text" value="{{ $productImage->id }}" hidden>
                                            <input name="product_image" type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">{{ $productImage->file_path }}</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="input-group-text bg-success">Изменить</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        @endforeach
                    @endif
                    @for($i = 0; $i < (3-$productImagesCount); $i++)

                        <form action="{{ route('product.image.store', ['product' => $product]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="product_image" type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-success">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endfor
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
