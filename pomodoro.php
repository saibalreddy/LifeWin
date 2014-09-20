<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/pomodoro.js"></script>

</head>
<body>
<div id="page">
<center>
<header>
            <h1>Pomodoro Timer</h1>
        </header>
  <audio id="sound" loop="true"/>
      <source src="audio.wav"/>
  </audio>

<div id="state" class="state" style="margin-bottom:-1px;"><span >Stopped</span></div>
<small>(press Enter to Start/Stop)</small>
<div id="timer">00:00</div>
<div style="margin-top:-20px; margin-left:"><b>Pomodoro&nbsp; #&nbsp;<span id="pomo">0</span></b><br/><small>(rest after every four pomodoros)</small></div>

 <fieldset class="field" >
                <legend align="center"><h3>Options</h3></legend>
				<center>
				<span style="color:red">(click on any of the fields to Reset Timer)</span>
                <div>
                    <label for="work"><span>Work:</span> 
					<input id="work" type="number" min="20" max="50" value="1" step="5" autocomplete="true" onclick="reset();"/> minutes</label>
                </div>
                <div>
                    <label for="break"><span>Break:</span> 
					<input id="brek" type="number" min="1" max="15" value="1" step="1" autocomplete="true" onclick="reset();"/> minutes</label>
                </div>
				<div>
                    <label for="rest"><span>Rest:</span> 
					<input id="rest" type="number" min="1" max="15" value="1" step="1" autocomplete="true" onclick="reset();"/> minutes</label>
                </div>
				
				
            </fieldset><br/>

			<footer>Developed By: <a href="https://www.facebook.com/daljeet.singh.90260">Daljeet Singh</a></footer>
</center>
</div>
<div id="pause" onclick="start();" class="pause">Paused<br/><span class="info">(press Enter to Start/Stop)</span></small></div>
<style>

 .work
	 {
	 color:#0C3;
	 }
.brek
	 {
	 color:#FF3333;
	 }
.rest
	 {
	 color:blue;
	 }
.state
	 {
	 font-family:Arial,Helventica,Sans-seriff;
	 cursor:pointer;
	 font-size:20px;
	 }
.state:hover
	 {
	 font-family:Arial,Helventica,Sans-seriff;
	 font-size:20px;
	 cursor:hand;
	 }
	 fieldset
{
    border-color: #999;
    color: #999;
    font-size: 75%;
    margin: 20px auto;
    padding: 5px;
    max-width: 250px;
}

fieldset div
{
    margin: 10px 0;
}

fieldset input
{
    width: 40px;
}

fieldset label span
{
    display: inline-block;
    width: 50px;
    text-align: right;
}
#timer {
  font-size: 400%;  margin: 20px auto;
  
color:#999; font-style:bold;  text-align:center; 

margin-top:-7px; 

}

h1
{
    color: #ccc;
    font-size: 600%;
    overflow: hidden;
    white-space: nowrap;
    margin: 20px auto;
}
#state {
  font-size: 300%;
  color: #999;
  margin: 20px auto;
  max-width: 250px;
}
.info
{
margin-left:-50px;
font-family:Verdana; font-size:40%;
}
#state:hover
{
    color: #333;
}

.pause
{
font-size:25pt; color:#666; font-family:"verdana bold",verdana,arial,sans-serif; text-decoration:none; cursor:pointer; opacity:0; position:absolute; top:240px; left:45%;
}
.pause:hover
{
font-size:25pt; color:#000;font-family:"verdana bold",verdana,arial,sans-serif; text-decoration:none; cursor:hand; opacity:0; position:absolute; top:240px; left:45%;
}
	.button
	 {
	 width:150px;
	 background:#666;
	 color:#f9f9f9;
	 cursor:pointer;
	 }
	 .button:hover
	 {
	 width:150px;
	 background:#ccc;
	 color:#000;
	 cursor:hand;
	 }
	 footer {
  font-size: 75%;
  margin: 20px auto;
  padding-bottom: 20px;
}</style>
</body>
    </html>
    