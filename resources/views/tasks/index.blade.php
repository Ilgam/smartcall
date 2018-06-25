@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Новая задача:
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
                            <div class="col-sm-6">
                                <input disabled type="text" name="name" id="task-phone" class="form-control" value="{{ $client->phone }}">
                            </div>
                            <div class="col-sm-3">
                                <!-- BEGIN SIPNET CODE {literal} -->
                                <script type="text/javascript">
                                    (function () {
                                        var s = document.createElement("script");
                                        s.type = "text/javascript";
                                        s.async = true;
                                        s.src = "https://www.sipnet.ru/bundles/artsoftemain/js/frontend/modules/webrtc_client.min.js";
                                        var ss = document.getElementsByTagName("script")[0];
                                        ss.parentNode.insertBefore(s, ss);
                                    })();
                                </script>
                                {{--<link rel="stylesheet" href="https://www.sipnet.ru/bundles/artsoftemain/css/webrtc_client.css"/>--}}
                                <div class="fw-container__step__form__design-btn__body">
                                    <label for="design-btn-3" class="fw-container__step__form__design-btn__label js-start_client_call fw-container__step__form__design-btn__label--3" data-token="{{ $cid }}" data-dtmf="off" data-lang="RU">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-btn fa-phone"></i>
                                            <span class="js-text_call">Позвонить</span>
                                        </button>
                                        <span class="fw-container__step__form__design-btn__label__icon2"></span>
                                    </label>

                                </div>
                                <!-- {/literal} END SIPNET CODE -->
                            </div>
                        </div>

                        {{--<!-- Add Task Button -->--}}
                        {{--<div class="form-group">--}}
                        {{--<div class="col-sm-offset-3 col-sm-6">--}}
                        {{--<button type="submit" class="btn btn-default">--}}
                        {{--<i class="fa fa-btn fa-plus"></i>Позвонить--}}
                        {{--</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                        {{--<div class="col-sm-offset-3 col-sm-8 text-right">--}}
                        {{--<button type="button" class="btn btn-success">--}}
                        {{--<i class="fa fa-btn fa-phone"></i>Позвонить--}}
                        {{--</button>--}}
                        {{--<button type="button" class="btn btn-info">--}}
                        {{--<i class="fa fa-btn fa-pause"></i>Удержание--}}
                        {{--</button>--}}
                        {{--<button type="button" class="btn btn-danger">--}}
                        {{--<i class="fa fa-btn fa-phone-square"></i>Завершить--}}
                        {{--</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8 text-right">
                                <a target="_blank" href="http://open.tochka.com" type="button" target class="btn btn-success">
                                    <i class="fa fa-btn fa-share"></i>Точка
                                </a>
                                <a href="{{ url('/task/success/' . $client->id) }}" class="btn btn-success">
                                    <i class="fa fa-btn fa-check"></i>Успех
                                </a>
                                <a href="{{ url('/task/defer/' . $client->id) }}" type="button" class="btn btn-info">
                                    <i class="fa fa-btn fa-clock-o"></i>Отложить
                                </a>
                                <a onclick="$('.fail_status').toggle(); return false;" type="button" class="btn btn-danger">
                                    <i class="fa fa-btn fa-times"></i>Отказ
                                </a>
                            </div>
                        </div>
                        <div class="form-group fail_status" style="display: none;">
                            <div class="col-sm-offset-2 col-sm-9 text-right">
                                <a href="{{ url('/task/fail/' . $client->id . '/1') }}" class="btn btn-success">
                                    <i class="fa fa-btn fa-check"></i>Неинтересно
                                </a>
                                <a href="{{ url('/task/fail/' . $client->id . '/2') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-clock-o"></i>Претензия
                                </a>
                                <a href="{{ url('/task/fail/' . $client->id . '/3') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-times"></i>Не актуально
                                </a>
                                <a href="{{ url('/task/fail/' . $client->id . '/4') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-times"></i>Не хочет менять банк
                                </a>
                                <br>
                                <br>
                                <a href="{{ url('/task/fail/' . $client->id . '/5') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-times"></i>Не подходят условия
                                </a>
                                <a href="{{ url('/task/fail/' . $client->id . '/6') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-times"></i>Не нравиться банк
                                </a>
                                <a href="{{ url('/task/fail/' . $client->id . '/7') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-times"></i>Рассмотрит в будущем.
                                </a>
                                <a href="{{ url('/task/fail/' . $client->id . '/8') }}" type="button" class="btn btn-success">
                                    <i class="fa fa-btn fa-times"></i>Другое
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Задачи
                </div>

                <div class="panel-body">
                    <table class="table task-table table-hover">
                        <thead>
                        <tr class="info text-left">
                            <th colspan="3">В работе:</th>
                        </tr>
                        <tr class="active">
                            <th class="text-center">ID</th>
                            <th class="text-center">Телефон</th>
                            <th class="text-center">ФИО</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($tasks_defer) > 0)
                            @foreach ($tasks_defer as $task)
                                @if (!is_object($task->clients))
                                    @continue
                                @endif
                                <tr>
                                    <td class="table-text text-center">
                                        <a href="{{ url('/tasks') .'/'. $task->clients->id }}">{{ $task->clients->id }}</a>
                                    </td>
                                    <td class="table-text text-center">
                                        {{ $task->clients->phone }}
                                    </td>
                                    <td class="table-text text-center">
                                        {{ $task->clients->client }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="table-text text-center">
                                    Нет задач
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table task-table table-hover">
                        <thead>
                        <tr class="success text-left">
                            <th colspan="3">Последние успешные:</th>
                        </tr>
                        <tr class="active">
                            <th class="text-center">ID</th>
                            <th class="text-center">Телефон</th>
                            <th class="text-center">ФИО</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($tasks_success) > 0)
                            @foreach ($tasks_success as $task)
                                @if (!is_object($task->clients))
                                    @continue
                                @endif
                                <tr>
                                    <td class="table-text text-center">
                                        {{ $task->clients->id }}
                                    </td>
                                    <td class="table-text text-center">
                                        {{ $task->clients->phone }}
                                    </td>
                                    <td class="table-text text-center">
                                        {{ $task->clients->client }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="table-text text-center">
                                    Нет задач
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table task-table table-hover">
                        <thead>
                        <tr class="danger text-left">
                            <th colspan="3">Последние отказы:</th>
                        </tr>
                        <tr class="active">
                            <th class="text-center">ID</th>
                            <th class="text-center">Телефон</th>
                            <th class="text-center">ФИО</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($tasks_fail) > 0)
                            @foreach ($tasks_fail as $task)
                                @if (!is_object($task->clients))
                                    @continue
                                @endif
                                <tr>
                                    <td class="table-text text-center">
                                        {{ $task->clients->id }}
                                    </td>
                                    <td class="table-text text-center">
                                        {{ $task->clients->phone }}
                                    </td>
                                    <td class="table-text text-center">
                                        {{ $task->clients->client }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="table-text text-center">
                                    Нет задач
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
