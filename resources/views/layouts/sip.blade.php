<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebRTC тестовый звонок</title>
    <link href="{{ asset('public/css/bootstrap.min.css', true) }}" rel="stylesheet">

    <style type="text/css">
        #wrap {
            display: none;
            opacity: 0.8;
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            padding: 16px;
            background-color: rgba(1, 1, 1, 0.725);
            z-index: 100;
            overflow: auto;
        }

        #window {
            width: 600px;
            height: 200px;
            margin: 50px auto;
            display: none;
            background: #fff;
            z-index: 200;
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            padding: 16px;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 5px;
            -khtml-border-radius: 10px;
        }

        .close {
            margin-left: 364px;
            margin-top: 4px;
            cursor: pointer;
        }

        #parent {
            padding: 5% 0;
        }

        #child {
            padding: 5% 5%;
        }

        .outer {
            width: 100%;
            text-align: left;
        }

        .inner {
            margin-right: 5px;
            margin-top: 5px;
            display: inline-block;
        }







        .card-widgets__widget__body .ac-form {
            padding-left: 25px;
        }

        .mgc-calc-modal {
            margin-top: 0;
        }

        .mgc-template-modal {
            margin-top: 0;
        }


        div[class*="card-widgets__widget-neirocrm_print_calc_"] .js-widget-caption-block {
            background-color: #b00f0a;
        }

        div[class*="card-widgets__widget-neirocrm_print_calc_"] .card-widgets__widget__body {
            background-color: #b00f0a;
        }

        div[class*="card-widgets__widget-neirocrm_print_calc_"] .card-widgets__widget__body .ac-form {
            padding: 1px 7px;
            background-color: #fff;

        }

        div[class*="card-widgets__widget-neirocrm_print_calc_"] .card-widgets__widget__body .ac_sub {
            padding: 3px 5px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 7px 0;
            text-align: center;
        }

        div[class*="card-widgets__widget-neirocrm_print_calc_"] .card-widgets__widget__body .ac_sub:hover {

            border: 1px solid #7d7d7d;

        }

        .card-widgets__widget {

            margin-bottom: 5px;
        }

        .calc-action__header h2 {
            display: inline-block;
            margin: 40px 10px 10px 20px;
        }

        .calc-action__top-controls {
            float: right;
        }




        .submit-button {
            background-color: #4f89f5;
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
            float: right;
            padding: 8px;
            margin: 10px;
        }

        .submit-button {
            background-color: white;
            color: black;
            border: 2px solid #4f89f5;
        }

        .submit-button:hover {
            background-color: #4f89f5;
            color: white;
        }

        .color-calc {
            background-color: #d8e9f1;
        }

        TABLE {
            border-collapse: collapse;
            width: 450px;
        }

        TH,
        TD {
            border: 1px solid #d8e9f1;
            text-align: left;
            padding: 4px;
        }

        TH {
            background: #fc0;
            height: 40px;
            vertical-align: bottom;

        }



        #result {
            margin-top: 70px;
        }

        .modal-body {
            width: 550px;
            padding: 10px 30px 50px 30px;
        }
    </style>

    <script type="text/javascript">
        //Функция показа очочка входящего звонка
        function show(state, isVideo) {
            document.getElementById('window').style.display = state;
            document.getElementById('wrap').style.display = state;
            if (isVideo == true) {
                $('#callType').text('входящий звонок с видео');
            } else {
                $('#callType').text('входящий звонок');
            }

        }
    </script>
    {{--{{ URL::asset('css/css.css') }}--}}
    <script type="text/javascript" src="https://www.sipnet.ru/webrtc/detector.js"></script>
    <script type="text/javascript" src="{{ URL::asset('public/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/js/ximssclient.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/js/ximsswrapper.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/js/adapter.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('public/js/callutils.js') }}"></script>

    <style type="text/css">
        .dn{
            display: none !important;
        }

        #shell-panel {
            height: 200px;
            width: 100%;
            background-color: #fefefe;
            color: #000000;
            padding: 20px 20px 20px 20px;
            font-family: 'Source Code Pro';
            overflow: scroll;
            overflow-x: hidden;
            overflow-y: scroll;
            border: 1px dashed #E6EBE0;
        }

        #shell-cli .prompt {
            font-weight: bold;
        }
    </style>


    <script>
        $(document).ready(function () {
            $('#btnLogout').hide();
        });
    </script>

    <script>
        var sid;
        var timer;

        var isFolderOpened = false;

        var timers = new Array();
        var secs = new Array();
        var transferStarted = new Array();

        var body_card = "<subKey key='cgcardid'><number>100</number></subKey>";



        function loadCredentials() {
            if (window.localStorage) {
                // IE retuns 'null' if not defined
                var s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.login'))) login.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.password'))) password.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.domain'))) domain.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.number_1'))) number_1.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.number_2'))) number_2.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.transnumber_1'))) transnumber_1.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.transnumber_2'))) transnumber_2.value = s_value;
                if ((s_value = window.localStorage.getItem('ru.sipnet.redirnumber'))) redirnumber.value = s_value;
            }
        };

        function saveCredentials() {
            if (window.localStorage) {
                window.localStorage.setItem('ru.sipnet.login', login.value);
                window.localStorage.setItem('ru.sipnet.password', password.value);
                window.localStorage.setItem('ru.sipnet.domain', domain.value);
                window.localStorage.setItem('ru.sipnet.number_1', number_1.value);
                window.localStorage.setItem('ru.sipnet.number_2', number_2.value);
                window.localStorage.setItem('ru.sipnet.transnumber_1', transnumber_1.value);
                window.localStorage.setItem('ru.sipnet.transnumber_2', transnumber_2.value);
                window.localStorage.setItem('ru.sipnet.redirnumber', redirnumber.value);
            }
        };

        function start_timer(line) {
            if (timers[line]) {
                clearInterval(timers[line]);
                delete timers[line];
                delete secs[line];
            }
            secs[line] = 0;
            $('#timer_' + line).text('длительностью: ' + secs[line] + ' сек.');

            timers[line] = setInterval(
                function () {
                    secs[line]++;
                    $('#timer_' + line).text('длительностью: ' + secs[line] + ' сек.');
                },
                1000);

            if (!timer) {
                timer = setInterval(
                    function () {
                        for (var key in ximssSession.currentCalls) {
                            console.log("[call " + key + ": " + ximssSession.currentCalls[key]['callLeg'] + "]");
                        }
                    }, 1000);
            }
        }

        function stop_timer(line) {
            if (timers[line]) {
                clearInterval(timers[line]);
                delete timers[line];
                delete secs[line];
            }
        }


        function addCallStatusToLog(msgTxt, line) {
            if (msgTxt == 'Call connected') {
                $('#callStat_' + line).text('Идет разговор');
                start_timer(line);
            } else
            if (msgTxt == 'Call provisioned') {
                $('#callStat_' + line).text('Вызов...');
            } else
            if (msgTxt == 'Success login') {} else
                $('#callLog_' + line).append(msgTxt + '\n');
        }

        function addToMainLog(msgTxt, line) {
            $('#callLog_' + line).append(msgTxt + '\n');
        }

        function addContact(peer) {
            $('#contactsdd').text(peer);
        }

        function askEvent() {
            ximssSession.doXimssStartTask('cgcard', '');
        }

        function sendImCG() {
            //ximssSession.doXimssSendMsg('sip_point@sipnet.ru', 'chat', '<subKey key="attempted"><number>5</number></subKey><subKey key="blacklisted">YES</subKey><subKey key="comments"><subValue><subKey key="agent">Муравин Вячеслав</subKey><subKey key="commentary">Невменяемый тип.</subKey><subKey key="created">2016-03-22T09:17:05Z</subKey></subValue></subKey><subKey key="company">Ордена Ленина комбинат "Североникель" им В.И. Ленина</subKey><subKey key="completed"><number>4</number></subKey><subKey key="created">2016-03-22T09:15:22Z</subKey><subKey key="emails"><subValue><subKey key="category"><number>1</number></subKey><subKey key="email">bondarenko.p@domain.ru</subKey></subValue><subValue><subKey key="category"><number>2</number></subKey><subKey key="email">p.bondarenko@domain.ru</subKey></subValue></subKey><subKey key="firstname">Пётр</subKey><subKey key="id"><number>100</number></subKey><subKey key="lastname">Бондаренко</subKey><subKey key="phones"><subValue><subKey key="category"><number>1</number></subKey><subKey key="phonenum">+79602548933</subKey></subValue><subValue><subKey key="category"><number>2</number></subKey><subKey key="phonenum">+78152269147</subKey></subValue></subKey>');
            //ximssSession.doXimssSendCgCardId('qwerty98@sipnet.ru', '60');
            ximssSession.doXimssSendCRMlink('qwerty9888@sipnet.ru',
                'https://www.sipnet.ru?id={sessionid}&login={login}');
        }

        function sendIM() {
            //ximssSession.doXimssSendMsg('qwerty988@sipnet.ru', 'chat', 'Вам отправлена карточка клиента с номером 101. Используйте рабочее место оператора ВАТС для работы с карточками клиентов.');
            //ximssSession.doXimssSendMsg('tel-654@sipnet.ru', 'chat', '<composing/>');
            ximssSession.doXimssSendMsg('tel-654@sipnet.ru', 'chat', 'test');
        }

        function getCG() {
            ximssSession.doXimssBannerRead(
                "<bannerRead type='getcgcard'><subKey key='cgcardid'><number>51</number></subKey></bannerRead>",
                "getcgcard");
        }

        function saveCG() {
            ximssSession.doXimssBannerRead(
                "<bannerRead type='cgcard'><subKey key='last_comment'>Не звонить после 16:00 по московскому времени 2</subKey><subKey key='id'><number>51</number></subKey><subKey key='phones'><subValue><subKey key='phonenum'>+79118576357</subKey></subValue></subKey></bannerRead>",
                "cgcard");
        }

        function searchCG() {
            ximssSession.doXimssBannerRead(
                "<bannerRead type='cgcardsearch'><subKey key='search'>79118576357</subKey></bannerRead>",
                "cgcardsearch");
        }

        function sendDTMF() {
            ximssSession.doDTMFSend(1, 1);
            //ximssSession.doXimssMailboxRightsGet("PBXAddressBook");
        }

        function attendedTransfer(line) {
            ximssSession.ximssTransferCall('', 1, 2);
        }


        function monitor(uuid, type) {
            ximssSession.doMonitorCalls(uuid, type);
        }

        ximssSession.onXimssReadIM = function (peer, peerName, msgTxt) {
            console.log("Пришло сообщение от " + peerName + " c адреса " + peer + " с текстом: " + msgTxt);
        };
        ximssSession.onXimssCallProvisioned = function (line) {
            addCallStatusToLog("Call provisioned", line);
            $('#btnCall_' + line).attr('disabled', false);
        };
        ximssSession.onXimssCallConnected = function (line, withVideo) {
            addCallStatusToLog("Call connected", line);
            $('#btnCall_' + line).attr('disabled', false);
            //ximssSession.doDTMFCreate(line);
            $('#callFunctions_' + line).show();
            //if(line==1) $('#secondCall').show();
        };
        ximssSession.onXimssCallIncoming = function (peer, peerName, isVideo, cid) {
            document.getElementById("peer").innerHTML = peer;
            document.getElementById("peerName").innerHTML = peerName;
            if (isVideo == true) {
                document.getElementById("callType").innerHTML = "входящий звонок с видео";
            } else {
                document.getElementById("callType").innerHTML = "входящий звонок";
            }

            if (isVideo == true) {
                $('#acceptCallWithVideo').show();
            } else {
                $('#acceptCallWithVideo').hide();
            }

            show('block', isVideo);
        }
        ximssSession.onXimssCallDisconnected = function (errorText, line) {
            if (errorText == 'transferred') {
                transferStarted[line] = false;

                $('#btnCall_' + line).attr("disabled", false);
                $('#btnHold_' + line).attr("disabled", false);
                $('#btnUnhold_' + line).attr("disabled", false);
                $('#btnTransfer_' + line).attr("disabled", false);
                ximssSession.doPresenceSet('online');
                $('#statusdd').text('Online');
            }
            $('#btnCall_' + line).addClass("btn-success");
            $('#btnCall_' + line).removeClass("btn-danger");
            stop_timer(line);

            $('#timer_' + line).attr("innerHTML", "");
            $('#btnCall_' + line).attr("value", "Звонить");
            $('#callStat_' + line).text("");
            $('#btnCall_' + line).attr("disabled", false);


            show('none');
            $('#callFunctions_' + line).hide();
            addToMainLog("Call disconnected: " + errorText, line);
            //if(line==2) $('#secondCall').hide();


        };
        ximssSession.onXimssSuccessLogin = function () {
            $('#rosterList').html('');
            $('#presenceStat').html('');
            $('#contactsdditems').html('');

            if ($('#callOnDevice').hasClass('btn-primary')) {
                ximssSession.ximssSignalBindForDevice();
            } else {
                //console.log(ximssSession);
                //console.log(ximssSession.audioDevices);
                //console.log(ximssSession.videoDevices);
                ximssSession.ximssSignalBind();
            }

            $('#btnLogin').hide();
            $('#btnLogout').show();
            $('#mainBlock').show();

            ximssSession.doXimssFindTaskMeeting('pbx', 'agent');
            ximssSession.doXimssFileDirInfo('private/IM');
        };

        ximssSession.onXimssSignalBind = function () {
            //addToMainLog("Success login\n");
            //ximssSession.doXimssFolderOpen("Contacts", "IPF.Contact", "imVCardQueueFolder");

            if (isFolderOpened == true) {
                ximssSession.doXimssFolderClose("MainContacts");
                ximssSession.doXimssFolderClose("MyContacts");
                ximssSession.doXimssFolderClose("INBOX");
            }

            ximssSession.doXimssMailboxSubList("*PBXAddressBook");
            //ximssSession.doXimssMailboxSubList("*");
            ximssSession.doXimssFolderOpen("Contacts", "IPF.Contact", "MyContacts", null);
            ximssSession.doXimssFolderOpen("INBOX", null, "INBOX", "Media");
            ximssSession.doXimssCli("GETACCOUNTINFO " + login.value + "@" + domain.value + " Key SIPContacts");
            ximssSession.doXimssPrefsReadCustom("CallGroupRegistration");

            isFolderOpened = true;

            ximssSession.doXimssPrefsRead();
            ximssSession.doXimssFileRead("vcard", "profile.vcf");
            ximssSession.doXimssFileRead(null, "private/logs/calls-2016-Mar");

            ximssSession.doXimssFileRead("binary", "MIME/vmail-2016-Mar-01_09-01.wav");

            //  ximssSession.doXimssMailboxSubList("*PBXAddressBook");
        };

        ximssSession.onXimssErrorLogin = function (err) {
            alert("Unsuccess login: " + err);
            //addToMainLog("Unsuccess login:"+err+"\n");
            $('#btnLogin').attr("disabled", false);
        };

        ximssSession.onConflict = function () {
            alert('Рабочее место активировано где-то еще. Эта сессия закрывается.');
            ximssSession.doLogout(true);
            $('#mainBlock').hide();
            $('#btnLogin').show();
            $('#btnLogin').attr("disabled", false);
            $('#btnLogout').hide();
        };
        ximssSession.onXimssPresence = function (peer, show, presence) {
            $('#presenceStat').append('Статус изменен для ' + peer + ' : ' + presence + '\n');
            ximssSession.doXimssIqSend(peer);
        };
        ximssSession.onXimssRosterItem = function (name, peer, group, subscription) {
            $('#rosterList').append('Контакт ' + name + ' ' + peer + ' в группе: ' + group + '\n');
            peerTmp = peer;
            var item = "<li><a href='index.html#' onclick='addContact(" + peerTmp + "); return false;' >" + peer +
                "</a></li>";
            $('#contactsdditems').append(item);
            // $('#contactsdd').text(peer);
        };

        ximssSession.onFileNotFound = function (filename) {
            console.log('file not found: ' + filename);
        }

        ximssSession.onIqRead = function (peer, vCardJSON, photoData) {
            //console.log('IqRead: '+peer+' vCard: '+ JSON.stringify(vCardJSON, null, 2)+' Photo: '+photoData);
        }
        ximssSession.onNetworkError = function (isFatal, timeElapsed) {

            if (isFatal == true) {
                alert('Сетевое подключение прервано, проверьте настройки сети.');
                for (var key in ximssSession.currentCalls) {
                    $('#btnCall_' + key).addClass("btn-success");
                    $('#btnCall_' + key).removeClass("btn-danger");
                }

                $('#mainBlock').hide();
                $('#btnLogin').show();
                $('#btnLogin').attr("disabled", false);
                $('#btnLogout').hide();

                show('none');
            } else {
                /*
                if(ximssSession.curCallLeg!="") {

                    $('#btnCall').addClass("btn-success");
                    $('#btnCall').removeClass("btn-danger");
                    $('#callFunctions').hide();
                    stop_timer();
                    document.getElementById("timer").innerHTML = "";
                    ximssSession.doCallKill();
                    document.getElementById("btnCall").value = "Звонить";
                    document.getElementById("btnCall").disabled = false;
                    //$('#callStat').append('Статус изменен для '+peer+' : '+presence+'\n');
                    document.getElementById("callStat").innerHTML = "&nbsp;";
                }
                */
            }
        };

        ximssSession.onXimssMakeCallReport = function (reportText) {
            if (reportText == null) {
                $('#btnCall_1').addClass("btn-success");
                $('#btnCall_1').removeClass("btn-danger");
                document.getElementById('timer_1').innerHTML = "";
                document.getElementById('btnCall_1').value = "Звонить";
                document.getElementById('callStat_1').innerHTML = '';
                document.getElementById('btnCall_1').disabled = false;
                show('none');

            } else {
                addToMainLog("Make call to device: " + reportText, 1);
                //document.getElementById("callStat").innerHTML = reportText;
            }
        };

        ximssSession.onXimssCallUpdated = function (isHold, line) {
            console.log("сall updated, isHold:" + isHold);
            addToMainLog("Call updated, isHold:" + isHold, line);
            //
            //if (isHold==true) {
            //    if (transferStarted == true) {
            //        var transferPeer = transnumber.value;
            //        ximssSession.ximssTransferCall(transferPeer);
            //    }
            //}
        };

        ximssSession.onXimssCallUpdatedError = function (isHold, line, signalCode, errorText) {
            console.log("Call update error, isHold:" + isHold + " error: " + errorText + " " + signalCode);
            addToMainLog("Call update error, isHold:" + isHold + " error: " + errorText + " " + signalCode);
            //
            //if (isHold==true) {
            //    if (transferStarted == true) {
            //        var transferPeer = transnumber.value;
            //        ximssSession.ximssTransferCall(transferPeer);
            //    }
            //}
        };

        ximssSession.onXimssCallOpCompleted = function (line) {

            console.log("transferStarted onXimssCallOpCompleted: " + transferStarted[line]);
            if (transferStarted[line] == true) {
                document.getElementById("callStat_" + line).innerHTML = 'Transfered';
                transferStarted[line] = false;

                $('#btnCall_' + line).attr("disabled", false);
                $('#btnHold_' + line).attr("disabled", false);
                $('#btnUnhold_' + line).attr("disabled", false);
                $('#btnTransfer_' + line).attr("disabled", false);

            }
        };

        ximssSession.onXimssCallOpFailed = function (errorText, signalCode, line) {

            console.log("transferStarted onXimssCallOpFailed: " + transferStarted[line]);
            if (transferStarted[line] == true) {
                addToMainLog("Failed to transfer call: " + errorText);
                transferStarted[line] = false;
                $('#btnCall_' + line).attr("disabled", false);
                $('#btnHold_' + line).attr("disabled", false);
                $('#btnUnhold_' + line).attr("disabled", false);
                $('#btnTransfer_' + line).attr("disabled", false);
                unholdCall(line);
            }
        };

        ximssSession.onXimssCallTransfer = function () {

        };

        ximssSession.onXimssContact = function (abook, xmlVCard) {
            //$('#contactList').append("Контакт книги "+abook+": "+(new XMLSerializer()).serializeToString(xmlVCard)+'\n');
            //console.log("Контакт книги "+abook+": "+(new XMLSerializer()).serializeToString(xmlVCard));
        }

        ximssSession.onXimssPrefsCustom = function (answer) {
            if (answer != null) {
                console.log("onXimssPrefsCustom: " + (new XMLSerializer()).serializeToString(answer));
            }

        }

        ximssSession.onXimssClosed = function () {
            console.log("XIMSS session closed!");
            //ximssSession=null;
        }

        ximssSession.onXimssContact2 = function (abook, peerContact, toFields) {

            $('#contactList').append("Контакт книги " + abook + ": " + peerContact.vCardJSON['X-FILE-AS VALUE'] +
                '\n');

            //console.log("name: "+peerContact.name);
            //       console.log("peer: "+peerContact.peer);

            //console.log("VCARD1: "+JSON.stringify(peerContact.vCardJSON, null, 2));
            //console.log("UID: "+peerContact.UID);
            //console.log("To Fields: "+toFields);


            //console.log("name: "+profileContact.telnums);

            //       for (i = 0; i < peerContact.telnums.length; i++) {
            //           console.log("telnums type: " + peerContact.typedTelnums[i].type + " telnums number: " + peerContact.typedTelnums[i].value);
            //       }

            //       for (i = 0; i < peerContact.emails.length; i++) {
            //           console.log("email type: "+peerContact.typedEmails[i].type + " email number: "+peerContact.typedEmails[i].value);
            //       }



            //       console.log("addresses: "+peerContact.addresses);
            //       console.log("photoData: "+peerContact.photoData);
            //       console.log("UID: "+peerContact.UID);
        }

        ximssSession.onXimssContactRemoved = function (abook, uid) {
            console.log("Contact with UID: " + uid + " removed in " + abook + " folder");
        }

        ximssSession.onXimssVCardUploaded = function (uploadId) {
            ximssSession.doXimssContactsImport('MyContacts', uploadId);
        }

        ximssSession.onXimssPrefs = function (prefsXML) {
            //console.log("Настройки: "+ximssSession.xml2str(prefsXML));
        }

        ximssSession.onXimssFileData = function (type, fileName, fileData) {
            //console.log("Пришел файл: "+fileName+" "+ximssSession.xml2str(fileData));
        }

        ximssSession.onXimssMyContact = function (type, fileName, myContact) {
            //console.log("LocalContact: "+JSON.stringify(myContact.vCardJSON, null, 2) );
        }

        ximssSession.onXimssOnHold = function (isHold, status) {
            console.log("Call is On Hold: " + isHold + " status: " + status);
        }

        ximssSession.onXimssVoiceFile = function (url, UID, From, Date) {
            console.log("Voice mail file for UID: " + UID + " " + url + " " + From + " " + Date);
            $('#voiceFiles').append(url + '\n');
        }

        ximssSession.onXimssVoiceMessages = function (messages) {
            console.log("Voice messages: " + messages);
            $('#vmess').text(messages);

            //ximssSession.doXimssFolderSync('INBOX');
        }

        ximssSession.onXimssVoiceMailFlags = function (uid, flags) {
            console.log("VM: " + uid + " " + flags);
        }

        ximssSession.onXimssRecoverPassword = function (errorText) {
            console.log("onXimssRecoverPassword: " + errorText);

        }

        ximssSession.onXimssRights = function (mailbox, rights) {
            ximssSession.doXimssFolderOpen(mailbox, "IPF.Contact", "MainContacts", null);
            console.log("onXimssRights: " + mailbox + " rights: " + rights);
        }

        ximssSession.onGroupsUpdate = function (groups) {
            console.log("onGroupsUpdate: " + (new XMLSerializer()).serializeToString(groups));
        }

        ximssSession.onCgCardEvent = function (xmlEvent) {
            console.log("onCgCardEvent: " + (new XMLSerializer()).serializeToString(xmlEvent));
        }

        ximssSession.onXimssBanner = function (xmlResponse) {
            console.log("onXimssBanner: " + (new XMLSerializer()).serializeToString(xmlResponse));
        }

        ximssSession.onXimssReceiveCgCardId = function (peer, peerName, cardid) {
            console.log("onXimssReceiveCgCardId: " + cardid);
        }


        ximssSession.onXimssReceiveCRMlink = function (peer, peerName, link) {
            console.log("onXimssReceiveCRMlink: " + link);
        }

        ximssSession.onXimssCliResult = function (cliResult) {



            console.log("onXimssCliResult: " + (new XMLSerializer()).serializeToString(cliResult));
        }

        ximssSession.onXimssSessionID = function (SessionID) {
            console.log("onXimssSessionID: " + SessionID);
        }

        ximssSession.onXimssContactsInfo = function (folder, messages) {
            console.log("onXimssContactsInfo: " + folder + " messages: " + messages);
        }


        ximssSession.onUserMediaError = function (errorText) {
            alert("Произошла ошибка при инициализации медиа устройств: " + errorText +
                " Рабочее место оператора переключается в режим \"Работа через телефонный аппарат\".\n\nДля осуществления звонков с рабочего места, необходимо настроить микрофон выключить режим \"Работа через телефонный аппарат\" или перезагрузить страницу."
            );
            onDevice(true);
            console.log("ошибка при инициализации медиа устройств: " + errorText);

            ximssSession.doPresenceSet('online');
            $('#statusdd').text('Online');

            for (var line = 1; line < 3; line++) {
                $('#btnCall_' + line).attr('disabled', false);
                $('#btnCall_' + line).addClass("btn-success");
                $('#btnCall_' + line).removeClass("btn-danger");
                $('#callFunctions_' + line).hide();
                stop_timer(line);
                document.getElementById("timer_" + line).innerHTML = "";
                document.getElementById("btnCall_" + line).value = "Звонить";
                document.getElementById("callStat_" + line).innerHTML = "&nbsp;";
            }
        }

        //ximssSession.ximssOpCompleted = function(type, event) {
        //    console.log('чук-чук');
        //}
    </script>

    <script>
        function cancelCall() {
            ximssSession.ximssCallReject(1);
            show('none');
        }

        function redirectCall() {
            saveCredentials();
            var redirectPeer = redirnumber.value;
            ximssSession.ximssRedirectCall(redirectPeer, 1);
            show('none');
            addToMainLog("Incoming call redirected to: " + redirectPeer);
        }

        function startCall(peer, line) {
            saveCredentials();
            if ($('#callOnDevice').hasClass('btn-primary')) {
                //phone=number.value;
                $('#btnCall_1').addClass("btn-danger");
                $('#btnCall_1').removeClass("btn-success");
                $('#btnCall_1').attr('value', 'Завершить');
                $('#btnCall_1').attr('disabled', true);
                ximssSession.ximssMakeCall(peer);

            } else {
                if (ximssSession.currentCalls[line] !== undefined) {
                    ximssSession.hideLocalVideo();
                    ximssSession.doCallKill(line);
                    ximssSession.doPresenceSet('online');
                    $('#statusdd').text('Online');

                    $('#btnCall_' + line).addClass("btn-success");
                    $('#btnCall_' + line).removeClass("btn-danger");
                    $('#callFunctions_' + line).hide();
                    stop_timer(line);
                    document.getElementById("timer_" + line).innerHTML = "";

                    document.getElementById("btnCall_" + line).value = "Звонить";
                    document.getElementById("callStat_" + line).innerHTML = "&nbsp;";
                    //console.log("Line free: "+line);

                    //if(line==2) $('#secondCall').hide();
                } else {
                    ximssSession.doPresenceSet('busy');
                    $('#statusdd').text('Busy');

                    //$('#callFunctions_'+line).hide();
                    $('#btnUnhold_' + line).hide();
                    $('#btnHold_' + line).show();
                    $('#btnCall_' + line).addClass("btn-danger");
                    $('#btnCall_' + line).removeClass("btn-success");
                    $('#btnCall_' + line).attr('value', 'Завершить');
                    $('#btnCall_' + line).attr('disabled', true);
                    //phone=$number_.value;
                    //console.log('phone: '+phone);
                    console.log("Objects: " + Object.keys(ximssSession.currentCalls).length);
                    console.log("Input device Audio: " + audioInputSelect.value);
                    console.log("Input device Video: " + videoInputSelect.value);

                    if ($("#isvideo_1").prop('checked') == true) {
                        ximssSession.isVideo = true;
                        ximssSession.showLocalVideo();
                        ximssSession.doStartCall(peer, line, audioInputSelect.value, true);

                    } else
                        ximssSession.doStartCall(peer, line, audioInputSelect.value);
                }
            }
        }


        function answerCall(line, isVideo) {


            console.log("Input device: " + audioInputSelect.value);
            if (isVideo == true) ximssSession.showLocalVideo();
            ximssSession.initRTCAnswer(line, audioInputSelect.value, isVideo);

            $('#btnCall_' + line).addClass("btn-danger");
            $('#btnCall_' + line).removeClass("btn-success");
            $('#btnCall_' + line).attr('value', 'Завершить');
            $('#callStat_' + line).text('Идет разговор');

            start_timer(line);
            $('#callFunctions_' + line).show();
            show('none', false);
        }


        function holdCall(line) {
            ximssSession.doHold(line);
            $('#btnUnhold_' + line).show();
            $('#btnHold_' + line).hide();
        }

        function unholdCall(line) {
            ximssSession.doUnhold(line);
            $('#btnUnhold_' + line).hide();
            $('#btnHold_' + line).show();
        }

        function muteCall(line) {
            ximssSession.doMute(line);
            $('#btnUnmute_' + line).show();
            $('#btnMute_' + line).hide();
        }

        function unmuteCall(line) {
            ximssSession.doUnmute(line);
            $('#btnUnmute_' + line).hide();
            $('#btnMute_' + line).show();
        }


        function transferCall(transferPeer, line) {
            saveCredentials();
            transferStarted[line] = true;

            ximssSession.ximssTransferCall(transferPeer, line, '');

            $('#btnCall_' + line).attr("disabled", true);
            $('#btnHold_' + line).attr("disabled", true);
            $('#btnUnhold_' + line).attr("disabled", true);
            $('#btnTransfer_' + line).attr("disabled", true);
            addToMainLog('Call if transferring to ' + transferPeer + ' ...', line);
        }

        function startWork() {
            saveCredentials();
            addCallStatusToLog("");
            $('#btnLogin').attr("disabled", true);

            ximssSession.doLogin(login.value, password.value, domain.value, false);
        }

        function stopWork() {
            ximssSession.doLogout(true);
            $('#mainBlock').hide();
            $('#btnLogin').show();
            $('#btnLogin').attr("disabled", false);
            $('#btnLogout').hide();

        }

        function recoverPass() {
            saveCredentials();
            ximssSession.doXimssRecoverPassword(domain.value, login.value);
        }

        function sendIMtoHub() {
            ximssSession.doXimssSendMsg('hub@' + ximssSession.serverName, 'chat', '{cmd=register;}');

        }

        function addContact() {

            //добавление контакта
            //ximssSession.doXimssContactAppend("Contacts", "MyContacts", $('#vcardDemo').text(), null);

            //изменение контакта
            //ximssSession.doXimssContactAppend("Contacts", "MyContacts" ,$('#vcardDemo').val(), $('#uid').val());

            //удаление контакта
            //ximssSession.doXimssContactRemove("MyContacts", $('#uid').val());
        }

        function onDevice(ifDev) {
            $('#rosterList').html('');

            if (ifDev == true) {
                $('#callOnDevice').addClass("btn-primary");
                $('#callOnWeb').removeClass("btn-primary");
                if (ximssSession.theSession != null) ximssSession.ximssSignalBindForDevice();
            } else
            if (ifDev == false) {
                $('#callOnWeb').addClass("btn-primary");
                $('#callOnDevice').removeClass("btn-primary");
                if (ximssSession.theSession != null) ximssSession.ximssSignalBind();
            }
        }
    </script>
</head>
<body>

    @yield('content')

</body>
<script type="text/javascript" src="{{ URL::asset('public/js/devices.js') }}"></script>
</html>
