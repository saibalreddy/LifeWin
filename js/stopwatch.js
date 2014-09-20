 //SINGLE BUTTON IMPLEMENTATION: http://stackoverflow.com/q/21202928/3065082

//	Simple example of using private variables
//
//	To start the stopwatch:
//		obj.start();
//
//	To get the duration in milliseconds without pausing / resuming:
//		var	x = obj.time();
// 
//	To pause the stopwatch:
//		var	x = obj.stop();	// Result is duration in milliseconds
//
//	To resume a paused stopwatch
//		var	x = obj.start();	// Result is duration in milliseconds
//
//	To reset a paused stopwatch
//		obj.stop();
//
var	clsStopwatch = function() {
		// Private vars
		var	startAt	= 0;	// Time of last start / resume. (0 if not running)
		var	lapTime	= 0;	// Time on the clock when last stopped in milliseconds

		var	now	= function() {
				return (new Date()).getTime(); 
			}; 
 
		this.setLapTime = function() {
			var data = JSON.parse(localStorage.getItem("meta"))["timer"];
			if(data!=null)
			lapTime = parseInt(data);
			}
		// Public methods
		// Start or resume
		this.start = function() {
			startAt	= startAt ? startAt : now();
			};

		// Stop or pause
		this.stop = function() {
				lapTime	= startAt ? lapTime + now() - startAt : lapTime;
				startAt	= 0; // Paused
			};

		// Reset
		this.reset = function() {
				lapTime = startAt = 0;
			};

		// Duration
		this.time = function() {
				return lapTime + (startAt ? now() - startAt : 0); 
			};
			
		this.pomotime = function() {
				var worktime = JSON.parse(localStorage.getItem("worktime")) * 60;
				return worktime*1000 - lapTime - (startAt ? now() - startAt : 0);
		};
	};

var x = new clsStopwatch();
var y = new clsStopwatch();
var type, clocktimer;

function pad(num, size) {
	var s = "0000" + num;
	return s.substr(s.length - size);
}

function formatTime(time) {
	var h = m = s = ms = 0;
	var newTime = '';

	h = Math.floor( time / 3600000 );
	time = time % 3600000;
	m = Math.floor( time / 60000 );
	time = time % (60000);
	s = Math.floor( time / 1000 );
	ms = time % 1000;

	newTime = pad(h, 2) + ':' + pad(m, 2) + ':' + pad(s, 2); // + ':' + pad(ms, 3);  (milliseconds removed)
	return newTime;
}

function update(type) {
	//update value on screen
	document.getElementById("time").innerHTML = formatTime(type? x.pomotime() : x.time());
	document.getElementById("timeelapsed").innerHTML =  formatTime(y.time());
	//update localStorage - done every second so that even when the system shuts down unexpectedly, the correct data remains.
	var meta = JSON.parse(localStorage.getItem("meta"));
	var log = JSON.parse(localStorage.getItem("log"));
	meta["lastTimer"] = x.time();
	meta["timer"] = y.time();
	//whether a log entry for timer has been found or not
	var found = 0;
	//add entry in log (1) lastTimer (2) timer
	for(var i=0; log[i]; i++)
		if(log[i]["key"]=="timer")
		{
			found = 1;
			log[i]["lastTimer"] = meta["lastTimer"];
			log[i]["timer"] = meta["timer"];
		}
	if(found == 0)
		log.push(JSON.parse('{"key":"timer", "lastTimer":"'+meta["lastTimer"]+'", "timer":"'+meta["timer"]+'"}'));
	//save all data
	localStorage.setItem("meta",JSON.stringify(meta));
	localStorage.setItem("log",JSON.stringify(log));
}

//start timer. para = 0 for normal and 1 for pomodoro
function start(para) {
	type = para;
	if(x.time())	//if a timer is already running
	stop();			//stop it (and save it's data too)
	clocktimer = setInterval("update("+type+")", 1000);   //use 1 instead of 1000 for millisecons
	addpoints = setInterval("addPoints(1)",1000*60*6);
	//stop pomodoro timer at 0
	if(type==1) {
		var worktime = JSON.parse(localStorage.getItem("worktime")) * 60;
		stoptimer = setInterval ("stop()",worktime*1000);
	}	
	if(type==2) {
		var resttime = JSON.parse(localStorage.getItem("resttime")) * 60;
		stoptimer = setInterval ("stop()",resttime*1000);
	}
	if(y.time()==0)
		y.setLapTime();
	x.start();
	y.start();
}

function stop() {
	//First Timer Becomes 0
	x.reset();
	//Second Timer Becomes 0
	y.stop();
	//Updation of timers and points stops
	clearInterval(clocktimer);
	clearInterval(addpoints);
}

function reset() {
	stop();
	x.reset();
	update();
	start();
}