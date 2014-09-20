<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<div id="page">
<style>
.box
{text-align:center;
height:261px;
vertical-align:center;
background:url(img/stopwatch.png) no-repeat;
}
#timer
{
padding-top:130px;
font-family:Verdana; font-size:20px;
}
.stopwatch{
 width:236px;   position:relative; 
 margin-left:100px;}</style>
<div class="stopwatch">
<header>
            <h1 align="center">Stopwatch</h1>
        </header>
<div class="box"><div id="timer">00:00:00</div><small>&nbsp;&nbsp;&nbsp;hr &nbsp;&nbsp;&nbsp;&nbsp; min &nbsp;&nbsp;&nbsp; sec</small></div><br/>
              <center>
			  <small style="margin-left:-135px;">(Click to Start or Stop)</small> 
                          <button id="start" onclick="start()">Start</button>
			  <button onclick="reset()">Reset</button><br/>
                           <br/><br/><br/>
			<footer>Developed By: <a href="https://www.facebook.com/daljeet.singh.90260">Daljeet Singh</a></footer>
              </div>
<script>
var sec=0,min=0,hr=0,time,SD,timer,state,setTarget,timer=$('#timer'),flag=0;
state='stopped';
 function start()
{  
//to start the timer
if((flag=='0')||(state=='stopped'))
{ 
state='tick';
flag=1;
$('#start').html('Stop');
SD=setTimeout('stopwatch()',0);
}
//to stop the timer
else if((flag=='1')||(state=='tick'))
{ 
flag=0;
state='held';
$('#start').html('Start');
clearTimeout(SD);
}
}

function stopwatch()
{
timer=$('#timer'); 
sec++;
if(sec>59)
{
sec=0;
//incrementing minutes by 1 if seconds=59
min=min+1;
}
if(min>59)
{
min=0;
//incrementing hours by 1 if minutes=59
hr=hr+1;
}
if (sec<=9) 
{ sec = "0" + sec; }
time=(hr<=9 ? "0" + hr : hr)+':'+(min<=9 ? "0" + min : min)+':'+sec;
SD=setTimeout('stopwatch()',1000);
timer.html('<span>'+time+'</span>');
}
function reset()
{
sec=0;clearTimeout(SD);
state='stopped';
$('#start').html('Start');flag=0;
 timer=$('#timer');
timer.html('00:00:00');sec=0;min=0;hr=0;
statedisp.html('<span style=\"color:#000;\">Stopped</span>');
}
</script>

</body>
    </html>
	