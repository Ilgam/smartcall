@extends('layouts.sip')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h1>Рабочее место</h1>

                <label>Сервер:</label>
                <input type="text" placeholder="sipnet.ru" id="domain" class="form-control" value="sipnet.ru"/>
                <br>
                <label>Логин:</label>
                <input type="text" placeholder="SIP ID" id="login" value="0042536098" class="form-control" />
                <br>
                <label>Пароль:</label>
                {{--55H352Gc--}}
                <input type="password" placeholder="password" id="password" value="" class="form-control" />
                <br>
                <label class="dn">Прием звоноков на:</label>
                <br>
                <button id='callOnWeb' class="dn btn btn-default btn-primary" type="button" onclick="onDevice(false)" style="width:160px;">рабочем месте</button>
                <button id='callOnDevice' class="dn btn btn-default" type="button" onclick="onDevice(true);" style="width:160px;">SIP-устройстве</button>
                <br>
                <br>
                <input id="btnLogin" class="btn btn-default" type="button" value="Начать работу" onclick="startWork(); return false;" />
                <input id="btnLogout" class="btn btn-default" type="button" value="Закончить работу" onclick="stopWork(); return false;"
                />
                <input id="btnRecover" class="dn btn btn-default" type="button" value="Восстановить пароль" onclick="recoverPass(); return false;"
                />
            </div>
            <div class="col-lg-8">
                <br>
                <br>
                <video id="audioElem_1" autoplay controls></video>
                <video id="localVideo" style="height: 100px;" autoplay muted controls></video>
            </div>
        </div>
    </div>
    <hr>
    <div id="mainBlock" style="display: none">

        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h3>Звонок</h3>
                    <label>Куда звоним:</label>
                    <input type="tel" placeholder="71234567890" id="number_1" value="" class="form-control" style="width: 300px" />
                    <br>
                    <input id="isvideo_1" name="isvideo_1" value="isvideo_1" type="checkbox" onchange="checkbox_1_changed()">
                    <input id="btnCall_1" class="btn btn-success" type="button" value="Звонить" onclick="startCall(number_1.value, 1); return false;"
                           style="display:inline-block;" />
                    <span style="display: none" id="callFunctions_1">
                        <input id="btnHold_1" class="btn btn-default" type="button" value="Удержать" onclick="holdCall(1); return false;" style="display:inline-block;"
                        />
                        <input id="btnUnhold_1" class="btn btn-default" style='display: none;' type="button" value="Вернуть" onclick="unholdCall(1); return false;"
                               style="display:inline-block;" />
                        <input id="btnMute_1" class="btn btn-default" type="button" value="Выкл. динамик" onclick="muteCall(1); return false;" style="display:inline-block;"
                        />
                        <input id="btnUnmute_1" class="btn btn-default" style='display: none;' type="button" value="Вкл. динамик" onclick="unmuteCall(1); return false;"
                               style="display:inline-block;" />
                        <br>
                        <br>
                        <input style="display:inline-block;" id="btnTransfer_1" class="btn btn-default" type="button" value="Перевести звонок" onclick="transferCall(transnumber_1.value,1); return false;"
                        />
                        <input style="display:inline-block;width: 200px" type="tel" placeholder="71234567890" id="transnumber_1" value="" class="form-control"
                        />
                    </span>
                    <br>
                    <br>
                    <div class="alert alert-success" id="child_1" role="alert">
                        <span id="callStat_1">&nbsp;</span>&nbsp;&nbsp;
                        <span id="timer_1"></span>
                    </div>
                    <label>Cобытия звонка:</label>
                    <br>
                    <textarea title="status" rows="5" id="callLog_1" style="width: 100%; height: 130px;"></textarea>
                    <div class="select">
                        <label for="audioSource">Audio input source: </label>
                        <select id="audioSource"></select>
                    </div>
                    <div class="select">
                        <label for="videoSource">Video input source: </label>
                        <select id="videoSource"></select>
                    </div>
                </div>
                <div class="dn col-lg-4" style="display:inline;" id="secondCall">
                    <h3>Звонок для перевода</h3>
                    <label>Куда звоним:</label>
                    <input type="tel" placeholder="71234567890" id="number_2" value="" class="form-control" style="width: 300px" />
                    <br>

                    <input id="btnCall_2" class="btn btn-success" type="button" value="Звонить" onclick="startCall(number_2.value, 2); return false;"
                           style="display:inline-block;" />

                    <span style="display: none" id="callFunctions_2">
                        <input id="btnHold_2" class="btn btn-default" type="button" value="Удержать" onclick="holdCall(2); return false;" style="display:inline-block;"
                        />
                        <input id="btnUnhold_2" class="btn btn-default" style='display: none;' type="button" value="Вернуть" onclick="unholdCall(2); return false;"
                               style="display:inline-block;" />
                        <br>
                        <br>
                        <input id="btnMute_2" class="btn btn-default" type="button" value="Выкл. динамик" onclick="muteCall(2); return false;" style="display:inline-block;"
                        />
                        <input id="btnUnmute_2" class="btn btn-default" style='display: none;' type="button" value="Вкл. динамик" onclick="unmuteCall(2); return false;"
                               style="display:inline-block;" />

                        <input style="display:inline-block;" id="btnTransfer_2" class="btn btn-default" type="button" value="Перевести звонок" onclick="transferCall(transnumber_2.value,2); return false;"
                        />
                        <input style="display:inline-block;width: 200px" type="tel" placeholder="71234567890" id="transnumber_2" value="" class="form-control"
                        />
                    </span>
                    <br>
                    <br>
                    <div class="alert alert-success" id="child_2" role="alert">
                        <span id="callStat_2">&nbsp;</span>&nbsp;&nbsp;
                        <span id="timer_2"></span>
                    </div>
                    <label>Cобытия звонка:</label>
                    <br>
                    <textarea title="status" rows="5" id="callLog_2" style="width: 100%; height: 130px;"></textarea>
                    <br>
                    <br>
                    <input id="btnAttended" class="btn btn-success" type="button" value="Соединить звонки" onclick="attendedTransfer(2); return false;"
                           style="display:inline-block;" />
                </div>
            </div>
        </div>
        <hr>

        <div class="dn">
        <div class="container">
            <!-- установка статуса -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>2. Статус presence</h3>
                    <label>Выбери текущий статус:</label>
                    <br>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="statusdd">Online</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="index.html#" onclick="ximssSession.doPresenceSet('online'); $('#statusdd').text('Online'); return false;">Online</a>
                            </li>
                            <li>
                                <a href="index.html#" onclick="ximssSession.doPresenceSet('busy'); $('#statusdd').text('Busy'); return false;">Busy</a>
                            </li>
                            <li>
                                <a href="index.html#" onclick="ximssSession.doPresenceSet('offline'); $('#statusdd').text('Offline'); return false;">Offline</a>
                            </li>
                        </ul>
                    </div>


                </div>
                <div class="col-lg-6">
                    <label>Входящие события:</label>
                    <br>
                    <textarea title="status" rows="5" id="presenceStat" style="width: 585px; height: 150px;"></textarea>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>3. Ростер</h3>

                    <div class="btn-group">
                        <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="contactsdd"></span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" id="contactsdditems">

                    </ul>-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Ростер:</label>
                    <br>
                    <textarea title="status" rows="5" id="rosterList" style="width: 585px; height: 150px;"></textarea>

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>4. Контакты и VCard</h3>


                    <div class="btn-group">
                        <input id="btnAddContact" class="btn btn-default" type="button" value="Добавить контакт c UID:" onclick="addContact(); return false;"
                        />

                        <input type="text" placeholder="" id="uid" value="" class="form-control" style="width: 50px">

                        <br>
                        <textarea title="vcard" rows="5" id="vcardDemo" style="width: 350px; height: 150px;"></textarea>

                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Контакты:</label>
                    <br>
                    <textarea title="status" rows="5" id="contactList" style="width: 585px; height: 150px;"></textarea>
                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>5. Импорт VCard</h3>


                    <div class="btn-group">




                        <form enctype="multipart/form-data" id="uploadForm">
                            <input name="fileData" type="file" id="userfile" name="userfile" multiple/>
                            <br>
                            <input type="button" id="uploadBtn" value="Загрузить VCard" class="btn btn-default" />
                        </form>


                    </div>



                </div>
                <div class="col-lg-6">
                    <!--<label> vCard:</label><br>
                <textarea title="status" rows="5" id="contactList2" style="width: 585px; height: 150px;"></textarea>-->
                </div>
            </div>

        </div>
        <br>
        <script>
            $('#uploadBtn').click(function () {
                for (var i = 0; i < $('#userfile')[0].files.length; ++i) {
                    ximssSession.doUploadVCard($('#userfile')[0].files[i]);
                }
            });
        </script>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>6. Голосовая почта</h3>
                    Файлов:
                    <span id="vmess">0</span>

                </div>
                <div class="col-lg-6">
                    <label>Файлы:</label>
                    <br>
                    <textarea title="files" rows="5" id="voiceFiles" style="width: 585px; height: 150px;"></textarea>
                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>7. Запросить CG-Card</h3>
                    <input id="btnEvent" class="btn btn-default" type="button" value="Запросить CG-CARD" onclick="askEvent(); return false;"
                           style="display:inline-block;" />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>8. Отправить сообщение с ID CG-Card</h3>
                    <input id="sendImCG" class="btn btn-default" type="button" value="Отправить ID CG-CARD" onclick="sendImCG(); return false;"
                           style="display:inline-block;" />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>9. Получить CG-Card</h3>
                    <input id="getCG" class="btn btn-default" type="button" value="Искать CG-Card" onclick="getCG(); return false;" style="display:inline-block;"
                    />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>10. Сохранить CG-Card</h3>
                    <input id="saveCG" class="btn btn-default" type="button" value="Сохранить CG-Card" onclick="saveCG(); return false;" style="display:inline-block;"
                    />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">
            <!-- ростер -->
            <div class="row">
                <div class="col-lg-4">

                    <h3>11. Искать CG-Card</h3>
                    <input id="searchCG" class="btn btn-default" type="button" value="Искать CG-Card" onclick="searchCG(); return false;" style="display:inline-block;"
                    />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">

            <div class="row">
                <div class="col-lg-4">

                    <h3>12. Отправить IM</h3>
                    <input id="sendIM" class="btn btn-default" type="button" value="sendIM" onclick="sendIM(); return false;" style="display:inline-block;"
                    />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">

            <div class="row">
                <div class="col-lg-4">

                    <h3>13. Отправить IM хабу</h3>
                    <input id="sendIMtoHub" class="btn btn-default" type="button" value="sendIM" onclick="sendIMtoHub(); return false;" style="display:inline-block;"
                    />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">

            <div class="row">
                <div class="col-lg-4">

                    <h3>14. DTMF</h3>
                    <input id="sendDTMF" class="btn btn-default" type="button" value="sendDTMF" onclick="sendDTMF(); return false;" style="display:inline-block;"
                    />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">

            <div class="row">
                <div class="col-lg-4">

                    <h3>15. Отправить запрос мониторинга</h3>
                    <input id="sendMonitor" class="btn btn-default" type="button" value="sendIM" onclick="monitor('E4CF716C-FAF2-457F-BC9B-63911CF60731','listen'); return false;"
                           style="display:inline-block;" />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <hr>
        <div class="container">

            <div class="row">
                <div class="col-lg-4">

                    <h3>16. Отправить событие для CG-Card</h3>
                    <input id="sendCGevent" class="btn btn-default" type="button" value="by hand" onclick="ximssSession.doXimssSendEvent('cgcard-shown', '10', ximssSession.hubTaskReferer); return false;"
                           style="display:inline-block;" />
                    <input id="sendCGevent" class="btn btn-default" type="button" value="closed" onclick="ximssSession.doXimssSendEvent('cgcard-closed', '10', ximssSession.hubTaskReferer); return false;"
                           style="display:inline-block;" />
                    <input id="sendCGevent" class="btn btn-default" type="button" value="saved" onclick="ximssSession.doXimssSendEvent('cgcard-saved', '10', ximssSession.hubTaskReferer); return false;"
                           style="display:inline-block;" />

                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>
        <br>
        <div class="container">

            <div class="row">
                <div class="col-lg-4">

                    <input id="showModal" class="btn btn-default" type="button" value="saved" onclick="document.getElementById('ddd').style.display = 'block'; return false;"
                           style="display:inline-block;" />

                </div>
            </div>

        </div>
        <br>
        </div>
    </div>
    <script src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
    <div class="modal modal-list modal_print-calc modal_calc-action mgc-calc-modal" id="ddd">
        <div class="modal-scroller custom-scroll">
            <div class="modal-body modal-body-relative">
                <div class="modal-body__inner">
                    <div class="calc-action__header">
                        <h2 class="calc-action__caption head_2">Расчет стоимости полиграфии</h2>
                        <div class="calc-action__top-controls">
                            <button type="button" class="button-input button-cancel " tabindex="" id="" style="">
                                <span>Закрыть</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="default-overlay modal-overlay default-overlay-visible">
                <span class="modal-overlay__spinner spinner-icon spinner-icon-abs-center" style="display: none;"></span>
            </div>
        </div>
    </div>
    <script>
        $('.mgc-calc-modal .button-cancel').on('click', function () {
            $('.mgc-calc-modal').style.display = 'none';
        });
    </script>
    <!--окно входящего звонка-->
    <div id="window">
        <center>
            <h2>
                <span id="peerName"></span>
            </h2>
            <span id="peer"></span>
            <br>
            <br>
            <font color="red" id="callType">входящий звонок</font>
            <br>
            <br>
            <input style="max-width: 140px" id="acceptCallWithVideo" class="btn btn-success" type="button" value="c видео" onclick="answerCall(1,true); return false;"
            />
            <input style="max-width: 140px" id="acceptCall" class="btn btn-success" type="button" value="Ответить" onclick="answerCall(1,false); return false;"
            />
            <input style="max-width: 140px" id="cancelCall" class="btn btn-danger" type="button" value="Отменить" onclick="cancelCall(1); return false;"
            />
            <input style="max-width: 140px;display:inline-block;" id="redirectCall" class="btn btn-default" type="button" value="Перевести"
                   onclick="redirectCall(1); return false;" /> ->
            <input style="display:inline-block;width: 150px" type="tel" placeholder="71234567890" id="redirnumber" value="" class="form-control"
            />
        </center>
    </div>
    <script>
        loadCredentials();
        function checkbox_1_changed() {
            if (ximssSession.currentCalls != null && Object.keys(ximssSession.currentCalls).length > 0) {
                if ($("#isvideo_1").prop('checked') == true) {
                    ximssSession.isVideo = true;
                    ximssSession.doUpdate(1, audioInputSelect.value, true);
                } else {
                    ximssSession.isVideo = false;
                    ximssSession.doUpdate(1, audioInputSelect.value, false);
                }
            } else {
                if ($("#isvideo_1").prop('checked') == true) {
                    ximssSession.isVideo = true;
                } else {
                    ximssSession.isVideo = false;
                }
            }
        }
    </script>
    <div onclick="show('none')" id="wrap"></div>
@endsection
