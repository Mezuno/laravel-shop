@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Главная</h1>
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
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $dataCount['ordersCount'] }}</h3>

                            <p>Заказы</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('order.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $dataCount['productsCount'] }}</h3>
{{--                            <sup style="font-size: 20px">%</sup>--}}
                            <p>Товары</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <a href="{{ route('product.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $dataCount['usersCount'] }}</h3>

                            <p>Пользователи</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $dataCount['reviewsCount'] }}</h3>

                            <p>Отзывы</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <a href="{{ route('review.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">

                <div class="col mb-2">
                    <div class="bg-dark text-white rounded-3 p-3 mr-4">
                        <h3>График заказов за {{ now()->format('F') }}</h3>
                        <canvas id="orderChart" style="width:100%;max-width:700px"></canvas>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h1 class="card-title">Последние заказы</h1>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Заказ ID</th>
                                        <th>Товары</th>
                                        <th>Статус</th>
                                        <th>Сумма</th>
                                        <th>Дата</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($lastOrders as $order)
                                    <tr>
                                        <td><a href="{{ route('order.show', $order->id) }}">{{ $order->id }}</a></td>
                                        <td>
                                            @foreach(json_decode($order->products) as $product)
                                                <a href="{{ route('product.show', $product->id) }}" class="text-white">{{ $product->vendor_code }}</a>,
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge @if($order->payment_status) badge-success @else badge-warning @endif">
                                                {{ $order->paymentStatusString }}
                                            </span>
                                        </td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('order.index') }}" class="btn btn-sm btn-primary float-right">Посмотреть все заказы</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col">
                    <h3 class="mb-3">Популярное в заказах</h3>
                    <div class="row">
                        @foreach($mostPopularProducts as $product)
                            <div class="card col mr-3 ml-3 p-0">
                                <img class="card-img-top" height="240" src="{{ $product->imageUrl }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->title }}</h5>
                                    <p class="card-text">
                                        В {{ $mostPopularProductsCount[$product->id] }} заказах
                                    </p>
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">К товару</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-6">
                    <h3 class="mb-3">Популярное в желаемом</h3>
                    <div class="row">
                        @foreach($mostPopularWishes as $product)
                            <div class="card col mr-3 ml-3 p-0">
                                <img class="card-img-top" height="240" src="{{ $product->imageUrl }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->title }}</h5>
                                    <p class="card-text">
                                        Добавили {{ $mostPopularWishesCount[$product->id] }} раз
                                    </p>
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">К товару</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
    <script>

        const orderChartData = [
            @foreach($ordersPerDayCount as $day => $orders) {day: {{ $day }}, count: {{ $orders }} }, @endforeach
        ];

        new Chart("orderChart", {
            type: "bar",

            data: {
                labels: orderChartData.map(row => row.day),
                datasets: [{
                    label: 'Заказы',
                    backgroundColor: '#17a2b8',
                    data: orderChartData.map(row => row.count)
                }],
            },
        });
    </script>
@endsection
