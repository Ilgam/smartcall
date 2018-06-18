'use strict';

var audioInputSelect = document.querySelector('select#audioSource');
var videoInputSelect = document.querySelector('select#videoSource');
var selectors = [audioInputSelect, videoInputSelect];

function gotDevices(deviceInfos) {
    // Handles being called several times to update labels. Preserve values.
    var values = selectors.map(function(select) {
        return select.value;
    });
    selectors.forEach(function(select) {
        while (select.firstChild) {
            select.removeChild(select.firstChild);
        }
    });
    for (var i = 0; i !== deviceInfos.length; ++i) {
        var deviceInfo = deviceInfos[i];
        var option = document.createElement('option');
        option.value = deviceInfo.deviceId;
        if (deviceInfo.kind === 'audioinput') {
            option.text = deviceInfo.label ||
                'microphone ' + (audioInputSelect.length + 1);
            audioInputSelect.appendChild(option);
        } else
        if (deviceInfo.kind === 'videoinput') {
            option.text = deviceInfo.label ||
                'camera ' + (videoInputSelect.length + 1);
            videoInputSelect.appendChild(option);
        }
        else {
            //console.log('Some other kind of source/device: ', deviceInfo);
        }
    }
    selectors.forEach(function(select, selectorIndex) {
        if (Array.prototype.slice.call(select.childNodes).some(function(n) {
                return n.value === values[selectorIndex];
            })) {
            select.value = values[selectorIndex];
        }
    });
}

function handleError(error) {
    console.log('navigator.getUserMedia error: ', error);
}

function changeDeviceAudio(){
    ximssSession.doUpdate(1,audioInputSelect.value);
}

function changeDeviceVideo(){
    ximssSession.doUpdate(1,audioInputSelect.value, true);
}

if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
    console.log("enumerateDevices() not supported.");
}else{
    navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
    audioInputSelect.onchange = changeDeviceAudio;
    videoInputSelect.onchange = changeDeviceVideo;
}
