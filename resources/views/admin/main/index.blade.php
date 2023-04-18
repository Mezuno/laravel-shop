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
                <div class="col-md-6">
                    <h3>Популярность в заказах</h3>
                    <div class="row">
                        @foreach($mostPopularProducts as $product)
                            <div class="card col-lg-3 col-4">
                                <img class="card-img-top" src="{{ $product->imageUrl }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->title }}</h5>
                                    <p class="card-text">
                                        В {{ $mostPopularProductsCount[$product->id] }}х заказах
                                    </p>
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">К товару</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <h3>График заказов за {{ now()->format('F') }}</h3>
                    <canvas id="orderChart" style="width:100%;max-width:700px"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Популярность в желаемом</h3>
                    <div class="row">
                        @foreach($mostPopularWishes as $product)
                            <div class="card col-lg-3 col-4">
                                <img class="card-img-top" src="{{ $product->imageUrl }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->title }}</h5>
                                    <p class="card-text">
                                        Добавили в желаемое {{ $mostPopularWishesCount[$product->id] }}х раз
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
