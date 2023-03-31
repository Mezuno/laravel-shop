@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Заказы</h1>
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

    @if (!empty(session()->get('success')))
        <div class="notification success">{{ session()->get('success') }}</div>
    @endif

    @if (!empty(session()->get('error')))
        <div class="notification error">{{ session()->get('error') }}</div>
    @endif

    <!-- Content filter -->
    <div class="ml-3 p-3 pr-0 alert alert-default-dark d-inline-block">
        <div class="">
            <h3>Фильтр</h3>
            <form action="{{ route('order.index') }}" class="w-100 d-flex" id="filter_form">
                <div class="form-group d-flex flex-column">
                    <label for="filter_user">Пользователь (пока только id)</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" id="filter_title" name="user" value="{{ app('request')->input('user') }}" placeholder="Имя, email или id">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_vendor_code">Артикул товара в заказе</label>
                    <input disabled class="me-2 p-2 rounded-2 border" type="number" id="filter_vendor_code" name="vendor_code" value="{{ app('request')->input('vendor_code') }}" placeholder="Артикул">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_size">Сколько записей</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_size" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_products_count">Кол-во товаров</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_products_count" name="products_count" value="{{ app('request')->input('products_count') }}" placeholder="Кол-во товаров">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_price_from">Сумма от</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_price_from" name="price_from" value="{{ app('request')->input('price_from') }}" placeholder="Цена от">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label for="filter_price_to">Сумма до</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" id="filter_price_to" name="price_to" value="{{ app('request')->input('price_to') }}" placeholder="Цена до">
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-end">
                <div class="d-flex flex-column">
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="payment_status_true" class="custom-control-input" id="customSwitch1" @if(app('request')->input('payment_status_true') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch1">Оплаченные</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input form="filter_form" type="checkbox" name="payment_status_false" class="custom-control-input" id="customSwitch2" @if(app('request')->input('payment_status_false') == 'on') checked @endif>
                        <label class="custom-control-label" for="customSwitch2">Не оплаченные</label>
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
                    {{ $orders->withQueryString()->links() }}
                    <div class="card">
{{--                        <div class="card-header">--}}
{{--                            <a href="{{ route('order.create') }}" class="btn btn-primary">Добавить</a>--}}
{{--                        </div>--}}

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Товары</th>
                                    <th>Сумма</th>
                                    <th>Кол-во товаров</th>
                                    <th>Статус оплаты</th>
                                    <th>Адрес</th>
                                    <th>Дата заказа</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('order.show', $order->id) }}">{{ $order->id }}</a></td>
                                        <td>
                                            <a href="{{ route('user.show', $order->orderer->id) }}">{{ $order->orderer->name }}</a>
                                        </td>
                                        <td>{{ $order->orderer->email }}</td>
                                        <td>
                                            @foreach(json_decode($order->products) as $orderProduct)
                                                <a href="{{ route('product.show', $orderProduct->id) }}">{{ $orderProduct->title }}</a>,
                                            @endforeach
                                        </td>
                                        <td>{{ $order->total_price }}₽</td>
                                        <td>{{ count(json_decode($order->products)) }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('order.show', $order->id) }}"
                                               class="btn btn-primary mr-2"><i class="fas fa-eye"></i></a>
                                            @if(!$order->deleted_at)
                                            <a href="{{ route('order.edit', $order->id) }}"
                                               class="btn btn-primary mr-2"><i class="fas fa-pen"></i></a>
                                            <button type="button" onclick="openModal({{ "deleteModal" . $order->id }});"
                                                    class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $order->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @else
                                                <form action="{{ route('order.restore', $order->id) }}" method="post" class="p-0 d-inline">
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
                            {{ $orders->withQueryString()->links() }}
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @foreach($orders as $order)
        <!-- Modal -->
        <div onclick="openModal({{ "deleteModal" . $order->id}})" class="deleteModal d-none"
             id="deleteModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-default-danger">Совершайте это действие только по просьбе клиента.</div>
                        Вы действительно хотите отменить заказ id{{ $order->id }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Отмена</button>
                        <form action="{{ route('order.delete', $order->id) }}" method="post" class="p-0 d-inline">
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
