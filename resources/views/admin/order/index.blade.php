@extends('admin.layouts.main')

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
                        <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Заказы</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Content filter -->
    <div class="ml-3 p-3 pr-0 alert alert-dark d-inline-block">
        <div class="">
            <h3>Фильтр</h3>
            <form action="{{ route('order.index') }}" class="w-100 d-flex" id="filter_form">
                <input type="text" name="filter" value="true" hidden>
                <div class="form-group d-flex flex-column">
                    <label>Пользователь</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" name="user" value="{{ app('request')->input('user') }}" placeholder="Имя, email или id">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Товар в заказе</label>
                    <input class="me-2 p-2 rounded-2 border" type="text" name="product" value="{{ app('request')->input('product') }}" placeholder="Товар (артикул или название)">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Сколько записей</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Кол-во товаров</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="products_count" value="{{ app('request')->input('products_count') }}" placeholder="Кол-во товаров">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Сумма от</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="total_price_from" value="{{ app('request')->input('total_price_from') }}" placeholder="Сумма от">
                </div>
                <div class="form-group d-flex flex-column ml-2">
                    <label>Сумма до</label>
                    <input class="me-2 p-2 rounded-2 border" type="number" name="total_price_to" value="{{ app('request')->input('total_price_to') }}" placeholder="Сумма до">
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
                <div class="form-group d-flex m-0 justify-content-end">
                    @if( app('request')->input('filter') === 'true')
                        <a href="{{ route('order.index') }}" class="btn btn-dark mr-2 text-decoration-none">Сбросить фильтры</a>
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
                    {{ $orders->withQueryString()->links() }}
                    <div class="card">
{{--                        <div class="card-header">--}}
{{--                            <a href="{{ route('order.create') }}" class="btn btn-primary">Добавить</a>--}}
{{--                        </div>--}}
                        <div class="card-header">
                            <form action="{{ route('order.from.query.export') }}" class="d-inline-block" id="filter_form">
                                <input type="text" name="filter" value="true" hidden>
                                <input type="text" name="title" value="{{ app('request')->input('title') }}" placeholder="Наименование" hidden>
                                <input type="number" name="vendor_code" value="{{ app('request')->input('product') }}" placeholder="Артикул" hidden>
                                <input type="number" name="size" value="{{ app('request')->input('size') }}" placeholder="Сколько записей" hidden>
                                <input type="number" name="total_price_from" value="{{ app('request')->input('total_price_from') }}" placeholder="Цена от" hidden>
                                <input type="number" name="total_price_to" value="{{ app('request')->input('total_price_to') }}" placeholder="Цена до" hidden>
                                <input type="checkbox" name="payment_status_true" class="custom-control-input" id="customSwitch1" @if(app('request')->input('payment_status_true') == 'on') checked @endif hidden>
                                <input type="checkbox" name="payment_status_false" class="custom-control-input" id="customSwitch2" @if(app('request')->input('payment_status_false') == 'on') checked @endif hidden>
                                {{--                            <input type="checkbox" name="deleted" class="custom-control-input" id="customSwitch3" @if(app('request')->input('deleted') == 'on') checked @endif hidden>--}}
                                <button class="btn btn-success">Выгрузить в Excel (с фильтром)</button>
                            </form>
                            <a href="{{ route('order.export') }}" class="btn btn-success">Выгрузить в Excel (все)</a>
                        </div>


                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Товары</th>
                                    <th>Сумма</th>
                                    <th>Товары (шт.)</th>
                                    <th>Статус оплаты</th>
                                    <th>Адрес</th>
                                    <th>Дата заказа</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('order.show', $order->id) }}">{{ $order->id }}</a></td>
                                        <td>
                                            <a href="{{ route('user.show', $order->user->id) }}">{{ $order->user->name }}</a>
                                        </td>
                                        <td>{{ $order->user->email }}</td>
                                        <td>
                                            @foreach(json_decode($order->products) as $orderProduct)
                                                <a href="{{ route('product.show', $orderProduct->id) }}">{{ $orderProduct->title }}</a>,
                                            @endforeach
                                        </td>
                                        <td>{{ $order->total_price }}₽</td>
                                        <td>{{ count(json_decode($order->products)) }}</td>
                                        <td class="pt-0 pb-0 align-text-bottom"><p class="p-0 pl-2 alert @if($order->payment_status) alert-default-success @else alert-default-warning @endif">{{ $order->paymentStatusString }}</p></td>
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
