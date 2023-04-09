@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Товары</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Товары</li>
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
            <form action="{{ route('product.index') }}" class="w-100 d-flex" id="filter_form">
                <input type="text" name="filter" value="true" hidden>
                <div class="form-group d-flex flex-column">
                    <label for="filter_title">Наименование</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" id="filter_title" name="title" value="{{ app('request')->input('title') }}" placeholder="Наименование">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_vendor_code">Артикул</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_vendor_code" name="vendor_code" value="{{ app('request')->input('vendor_code') }}" placeholder="Артикул">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_description">Описание</label>
                    <input class="me-2 p-2 rounded-2 border flex-grow-1" id="filter_description" type="text" name="description" value="{{ app('request')->input('description') }}" placeholder="Описание">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_content">Контент</label>
                    <input class="me-2 p-2 rounded-2 border flex-grow-1" id="filter_content" type="text" name="content" value="{{ app('request')->input('content') }}" placeholder="Содержание">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_size">Сколько записей</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_size" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_price_from">Цена от</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_price_from" name="price_from" value="{{ app('request')->input('price_from') }}" placeholder="Цена от">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_price_to">Цена до</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_price_to" name="price_to" value="{{ app('request')->input('price_to') }}" placeholder="Цена до">
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-end">
                <div class="d-flex flex-column">
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="is_published_true" class="custom-control-input" id="customSwitch1" @if(app('request')->input('is_published_true') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch1">Опубликованные</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="is_published_false" class="custom-control-input" id="customSwitch2" @if(app('request')->input('is_published_false') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch2">Не опубликованные</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="deleted" class="custom-control-input" id="customSwitch3" @if(app('request')->input('deleted') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch3">Удаленные</label>
                    </div>
                </div>
                <div class="form-group d-flex m-0 justify-content-end">
                    @if( app('request')->input('filter') === 'true')
                        <a href="{{ route('product.index') }}" class="btn btn-dark mr-2 text-decoration-none">Сбросить фильтры</a>
                    @endif
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
                    <div class="d-inline text-dark text-black">{{ $products->withQueryString()->links() }}</div>
                    <div class="card">
                        <div class="card-header" id="managmentBar">
                            <a href="{{ route('product.create') }}" class="btn btn-primary">Добавить</a>
                            <form action="{{ route('product.from.query.export') }}" class="d-inline-block" id="filter_form">
                                <input type="text" name="filter" value="true" hidden>
                                <input type="text" name="title" value="{{ app('request')->input('title') }}" placeholder="Наименование" hidden>
                                <input type="number" name="vendor_code" value="{{ app('request')->input('vendor_code') }}" placeholder="Артикул" hidden>
                                <input type="text" name="description" value="{{ app('request')->input('description') }}" placeholder="Описание" hidden>
                                <input type="text" name="content" value="{{ app('request')->input('content') }}" placeholder="Содержание" hidden>
                                <input type="number" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей" hidden>
                                <input type="number" name="price_from" value="{{ app('request')->input('price_from') }}" placeholder="Цена от" hidden>
                                <input type="number" name="price_to" value="{{ app('request')->input('price_to') }}" placeholder="Цена до" hidden>
                                <input type="checkbox" name="is_published_true" class="custom-control-input" id="customSwitch1" @if(app('request')->input('is_published_true') == 'on') checked @endif hidden>
                                <input type="checkbox" name="is_published_false" class="custom-control-input" id="customSwitch2" @if(app('request')->input('is_published_false') == 'on') checked @endif hidden>
                                <input type="checkbox" name="deleted" class="custom-control-input" id="customSwitch3" @if(app('request')->input('deleted') == 'on') checked @endif hidden>
                                <button class="btn btn-success">Выгрузить в Excel (с фильтром)</button>
                            </form>
                            <a href="{{ route('product.export') }}" class="btn btn-success">Выгрузить в Excel (все)</a>
                        </div>
                        <div class="card-header" id="managmentBar2" style="display: none">

                            <form action="{{ route('product.mass.publish') }}" method="post" id="massPublishForm" class="d-inline-block">
                                @csrf
                                @method('patch')
                                <button class="btn btn-primary">Опубликовать выбранные</button>
                            </form>

                            <form action="{{ route('product.mass.delete') }}" method="post" id="massDeleteForm" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">Удалить выбранные</button>
                            </form>

                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="align-text-bottom">
                                        <input type="checkbox" id="massInput" onchange="massInputCheck()">
                                    </th>
                                    <th class="align-text-bottom">Артикул</th>
                                    <th class="align-text-bottom">Изображение</th>
                                    <th class="align-text-bottom">Наименование</th>
                                    <th class="align-text-bottom">Цена</th>
                                    <th class="align-text-bottom">Кол-во в наличии</th>
                                    <th class="align-text-bottom">Публикация</th>
                                    <th class="align-text-bottom">Категория</th>
                                    <th class="align-text-bottom">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <input form="massPublishForm" name="products_ids[]" value="{{ $product->id }}" massPublishProductId="{{ $product->id }}" type="checkbox" onchange="switchBar()" class="check-button-publish">
                                            <input form="massDeleteForm" name="products_ids[]" value="{{ $product->id }}" massDeleteProductId="{{ $product->id }}" type="checkbox" class="check-button-delete" hidden>
                                        </td>
                                        <td class="pt-0 pb-0 align-text-bottom pl-4">{{ $product->vendor_code }}</td>
                                        <td class="pt-0 pb-0 align-text-bottom"><img src="{{ URL::asset('storage/'.$product->preview_image) }}" width="50" height="50" alt="Изображение товара"></td>
                                        <td class="pt-0 pb-0 align-text-bottom"><a href="{{ route('product.show', $product->id) }}" class="">{{ mb_strimwidth($product->title, 0, 60, "...") }}</a></td>
                                        <td class="pt-0 pb-0 align-text-bottom">{{ $product->price }} ₽</td>
                                        <td class="pt-0 pb-0 align-text-bottom">{{ $product->count }}шт.</td>
                                        <td class="pt-0 pb-0 align-text-bottom"><p class="p-0 pl-2 alert @if($product->is_published) alert-default-success @else alert-default-warning @endif">{{ $product->publishedStatus }}</p></td>
                                        <td class="pt-0 pb-0 align-text-bottom">{{ $product->category->title }}</td>
                                        <td class="pt-0 pb-0 align-text-bottom">
                                            @if(!$product->deleted_at)
                                            <a href="{{ route('product.edit', $product->id) }}" class="primary p-2 mr-4 d-inline"><i class="fas fa-pen"></i></a>
                                                <button type="button" onclick="openModal({{ "deleteModal" . $product->id }});" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('product.restore', $product->id) }}" method="post" class="p-0 d-inline">
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

    @foreach($products as $product)
        <!-- Modal -->
        <div onclick="openModal({{ "deleteModal" . $product->id}})" class="deleteModal d-none" id="deleteModal{{ $product->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
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

        function massInputCheck() {
            let managementBar = document.getElementById('managmentBar');
            let managementBar2 = document.getElementById('managmentBar2');
            let switchesPublish = Array.from(document.getElementsByClassName('check-button-publish'));
            let switchesDelete = Array.from(document.getElementsByClassName('check-button-delete'));
            let activeSwitches = calculateChecked(switchesPublish, switchesDelete)
            const urlParams = new URLSearchParams(window.location.search);

            if (Number(urlParams.get('size')) !== 0) {
                if (Number(urlParams.get('size')) * 2 === activeSwitches) {
                    checkAll(switchesPublish, switchesDelete, managementBar, managementBar2, false)
                } else {
                    checkAll(switchesPublish, switchesDelete, managementBar, managementBar2, true)
                }
            } else {
                if (activeSwitches === 16) {
                    checkAll(switchesPublish, switchesDelete, managementBar, managementBar2, false)
                } else {
                    checkAll(switchesPublish, switchesDelete, managementBar, managementBar2, true)
                }
            }
        }

        function calculateChecked(switchesPublish, switchesDelete) {
            let activeSwitches = []

            switchesPublish.forEach((switchPublish) => {
                if (switchPublish.checked) {
                    activeSwitches.push(switchPublish)
                }
            })

            switchesDelete.forEach((switchDelete) => {
                if (switchDelete.checked) {
                    activeSwitches.push(switchDelete)
                }
            })

            return activeSwitches.length;
        }

        function checkAll(switchesPublish, switchesDelete, managementBar, managementBar2, enable) {
            if (enable) {
                switchesPublish.forEach((switchPublish) => {
                    switchPublish.checked = true
                })
                switchesDelete.forEach((switchDelete) => {
                    switchDelete.checked = true
                })

                managementBar.style.display = 'none'
                managementBar2.style.display = 'block'
            }
            else {
                switchesPublish.forEach((switchPublish) => {
                    switchPublish.checked = false
                })
                switchesDelete.forEach((switchDelete) => {
                    switchDelete.checked = false
                })

                managementBar.style.display = 'block'
                managementBar2.style.display = 'none'
            }
        }

        function switchBar() {
            let managementBar = document.getElementById('managmentBar');
            let managementBar2 = document.getElementById('managmentBar2');
            let switchesPublish = Array.from(document.getElementsByClassName('check-button-publish'));
            let switchesDelete = Array.from(document.getElementsByClassName('check-button-delete'));
            let activeSwitches = [];

            switchesPublish.forEach((switchPublish) => {
                if (switchPublish.checked) {

                    switchesDelete.forEach(switchDelete => {
                        if (switchDelete.attributes.massDeleteProductId.value === switchPublish.attributes.massPublishProductId.value) {
                            switchDelete.checked = true
                        }
                    })

                    activeSwitches.push(switchPublish)

                } else {

                    switchesDelete.forEach(switchDelete => {
                        if (switchDelete.attributes.massDeleteProductId.value === switchPublish.attributes.massPublishProductId.value) {
                            switchDelete.checked = false
                        }
                    })
                }
            })

            if (activeSwitches.length === 0) {
                managementBar.style.display = 'block'
                managementBar2.style.display = 'none'
            } else {
                managementBar.style.display = 'none'
                managementBar2.style.display = 'block'
            }
        }
    </script>
@endsection
