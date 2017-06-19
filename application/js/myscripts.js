// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
/******************************************************************************/
 //following function was taken from http://codepen.io/ishanbakshi/pen/pgzNMv
 function countdown(minutes) {
        var timeoutHandle;
        var seconds = 60;
        var mins = minutes
        function tick() {
            var counter = document.getElementById("timer");
            var current_minutes = mins-1
            seconds--;
            counter.innerHTML =
            current_minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);
            if( seconds > 0 ) {
                timeoutHandle=setTimeout(tick, 1000);
            } else {
    
                if(mins > 1){
                   setTimeout(function () { countdown(mins - 1); }, 1000);
                }
            }
            if (mins < 5) {
                document.getElementById("timer").style.background = "#dd4335";
            }
        }
        tick();
}
/******************************************************************************/
function showOption() {
    if(document.getElementById('selectTable').value == "question") {
        document.getElementById('subjectFilter').style.display='inline'; 
        document.getElementById('level').style.display='inline';
    } else {
        document.getElementById('subjectFilter').style.display='none'; 
        document.getElementById('level').style.display='none';
    }
}
function forceShowOption(select,value) {
    document.getElementById('subjectFilter').style.display='inline'; 
    document.getElementById('level').style.display='inline';
    document.getElementById(select).value=value;
}

function toBottom() {
    window.scrollTo(0, document.body.scrollHeight);
}

function hideRadioCircle() {
    document.getElementsByClassName('answers').style.display='none';
}
