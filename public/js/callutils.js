//Oscillator
var context = null;
var tone = null;
var playing = false;

//factory function for creating an oscillator
var newOscillator = function(waveform, freq){

    var oscillator = context.createOscillator();
    oscillator.type = waveform;
    oscillator.frequency.value = freq; // value in hertz
    oscillator.connect(context.destination);
    return oscillator
};
                         
var playTone = function(waveform, freq){
    if (tone === null){
       tone = newOscillator(waveform, freq);
       tone.start();
    }
};
                                                       
var stopTone = function(){
    if (tone !== null){
        tone.stop();
    }
    tone = null;
};

//Russian Ring-Back Tone

var kpv,kpv2;
  
function createLocalKPV() {
    if (playing == true) return;
    playing=true;

    if (typeof window.AudioContext != "undefined") {
        context = new window.AudioContext();
    } else if (typeof window.webkitAudioContext != "undefined") {
        context =  new window.webkitAudioContext();
    }

    console.log('start local kpv');
    playTone('sine', 425);
    kpv = setInterval('stopLocalKPV()', 1000);
}

function startLocalKPV() {
    clearInterval(kpv2);
    playTone('sine', 425);
    kpv = setInterval('stopLocalKPV()', 1000);
} 

function stopLocalKPV() {
    clearInterval(kpv);
    stopTone();
    kpv2 = setInterval('startLocalKPV()', 4000);
}

function deleteLocalKPV() {
    if (playing == false) return;
    playing=false;
    console.log('stop local kpv');
    clearInterval(kpv);
    clearInterval(kpv2);
    stopTone();
    context.close();
    context = null;
    //context.close().then(function() {});
}

