@extends('admin.layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать заказ</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Заказы</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.show', $order->id) }}">{{ $order->id }}</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="alert alert-default-danger">
            Опасная зона. Редактирование заказа может привести к нежелательным последствиям. Вносить изменения только по просьбе клиента.
        </div>
        <div class="container-fluid">

            <div class="row">
                <form action="{{ route('order.update', $order->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <p>ID пользователя</p>
                        <input type="text" name="user_id" value="{{ $order->user_id }}" class="form-control" placeholder="ID пользователя">
                    </div>
                    <div class="form-group">
                        <p>Товары</p>
                        <textarea name="products" class="form-control" placeholder="Товары" rows="15" cols="100">{{ $order->products }}</textarea>
                    </div>
                    <div class="form-group">
                        <p>Адрес</p>
                        <input type="text" value="{{ $order->address }}" name="address" class="form-control" placeholder="Адрес">
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
