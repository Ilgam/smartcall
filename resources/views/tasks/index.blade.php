@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Новая задача
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                    <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                        {{--<div class="form-group">--}}
                        {{--<label for="task-name" class="col-sm-3 control-label">Задача</label>--}}

                        {{--<div class="col-sm-6">--}}
                        {{--<input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="task-inn" class="col-sm-2 control-label">ИНН</label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="name" id="task-inn" class="form-control" value="{{ $client->inn }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-name" class="col-sm-2 control-label">Название</label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="name" id="task-name" class="form-control" value="{{ $client->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-type" class="col-sm-2 control-label">Тип</label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="name" id="task-type" class="form-control" value="{{ $client->type }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-client" class="col-sm-2 control-label">Клиент</label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="name" id="task-client" class="form-control" value="{{ $client->client }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-address" class="col-sm-2 control-label">Адрес</label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="name" id="task-address" class="form-control" value="{{ $client->address }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-phone" class="col-sm-2 control-label">Телефон</label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="name" id="task-phone" class="form-control" value="{{ $client->phone }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        {{--<div class="form-group">--}}
                        {{--<div class="col-sm-offset-3 col-sm-6">--}}
                        {{--<button type="submit" class="btn btn-default">--}}
                        {{--<i class="fa fa-btn fa-plus"></i>Позвонить--}}
                        {{--</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8 text-right">
                                <button type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-phone"></i>Позвонить
                                </button>
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-btn fa-pause"></i>Удержание
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <i class="fa fa-btn fa-phone-square"></i>Завершить
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8 text-right">
                                <button type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-check"></i>Успех
                                </button>
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-btn fa-clock-o"></i>Отложить
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <i class="fa fa-btn fa-times"></i>Отказ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Задачи
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                            <tr class="info">
                                <th>В работе:</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="table-text">
                                    <div>Нет задач</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                            <tr class="warning">
                                <th>Ближайшие отложенные:</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="table-text">
                                    <div>Нет задач</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                            <tr class="danger">
                                <th>Пропущенные отложенные:</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="table-text">
                                    <div>Нет задач</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
