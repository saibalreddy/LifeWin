function sync(){
	console.log("sync() function called");
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXect("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			console.log(xmlhttp.responseText);
			//clear the log
			localStorage.setItem('log','[]');
		}
	}
	xmlhttp.open("POST","sync.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	
	//var meta = localStorage.getItem("meta");
	//var DailyDetails = localStorage.getItem("DailyDetails");
	//var DailyNames = localStorage.getItem("DailyNames");
	//var GoalsDetails = localStorage.getItem("GoalsDetails");
	//var GoalsNames = localStorage.getItem("GoalsNames");
	//var TasksDetails = localStorage.getItem("TasksDetails");
	//var TasksNames = localStorage.getItem("TasksNames");
	//var WinstateDetails = localStorage.getItem("WinstateDetails");
	//var WinstateNames = localStorage.getItem("WinstateNames");
	//var scoreboard = localStorage.getItem("scoreboard");
	var log = localStorage.getItem("log");
	//var data = "meta="+meta+"&DailyDetails="+DailyDetails+"&DailyNames="+DailyNames+"&GoalsDetails="+GoalsDetails+"&GoalsNames="+GoalsNames+"&TasksDetails="+TasksDetails+"&TasksNames="+TasksNames+"&WinstateDetails="+WinstateDetails+"&WinstateNames="+WinstateNames+"&scoreboard="+scoreboard;
	var data = "log="+log;
	xmlhttp.send(data);
}

window.onload=function refresh(){
	console.log("window.onload = function refresh() function called");
	// Check if a new cache is available on page load.
	window.addEventListener('load', function(e) {
		window.applicationCache.addEventListener('updateready', function(e) {
			if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
				// Browser downloaded a new app cache.
				if (confirm('A new version of this site is available. Load it?')) {
				window.location.reload();
				}
			}
			else{
				// Manifest didn't changed. Nothing new to server.
			}
		}, false);
	}, false);

	//App used for first time?
	if (localStorage.getItem("meta") === null){
		var date =moment().format('DD-MM-YYYY');
		var meta = '{"date":"'+date+'","Present":0,"Future":0,"Today":0,"Tomorrow":0,"This Week":0,"Later":0,"Habits":0,"Frequent":0,"timer":0,"lastTimer":0,"daily":"00","weekly":"00","initialPos":0,"list":"Tasks","Goals":["Present","Future"],"Tasks":["Today","Tomorrow","This Week","Later"],"Dailies":["Habits","Frequent"],"Winstate":[" "]}';
		var goalsDetails = '{}';
		var goalsNames = '[]';
		var tasksDetails = '{}';
		var tasksNames = '[]';
		var dailyDetails = '{}';
		var dailyNames = '[]';
		var winstateDetails = '{"Yes! I Did It!":{"count":0}}';
		var winstateNames = '["Yes! I Did It!"]';
		var scoreboard = '{}';
		var log = '[]';

		//set initial data
		localStorage.setItem("meta",meta);
		localStorage.setItem("GoalsDetails",goalsDetails);
		localStorage.setItem("GoalsNames",goalsNames);
		localStorage.setItem("TasksDetails",tasksDetails);
		localStorage.setItem("TasksNames",tasksNames);
		localStorage.setItem("DailiesDetails",dailyDetails);
		localStorage.setItem("DailiesNames",dailyNames);
		localStorage.setItem("WinstateDetails",winstateDetails);
		localStorage.setItem("WinstateNames",winstateNames);
		localStorage.setItem("scoreboard",scoreboard);
		localStorage.setItem("log",log);
	}

	//get all required data
	var meta = JSON.parse(localStorage.getItem("meta"));
	var scoreboard = JSON.parse(localStorage.getItem("scoreboard"));
	var log = JSON.parse(localStorage.getItem("log"));

	//is this the same date as last time or a new date?
	var today = moment().format('DD-MM-YYYY');
	var lastdate = meta["date"];
	//the dates are differnet
	if(today!=lastdate){

		//Reset weekly points to 00 if today's week and the last days week are not the same
		if((moment(today).week()!=moment(lastdate).week())||(moment(today).format("YYYY")!=(moment(lastdate).format("YYYY"))))
		meta["weekly"]='00';

		//set currentDate as the new date
		meta["date"]=today;
		//get date's points
		var dailyPoints = meta["daily"];
		//if the currentDate already exists in the scoreboard, continue from the points the day already has
		if(scoreboard[today])
			meta["daily"]=scoreboard[today];
		else //today's points starts from 0
			meta["daily"]='00';
	
		//if date already exists in the scoreboard, modify the points it already has
		if(scoreboard[lastdate]){
			scoreboard[lastdate]=dailyPoints;
		}
		else {
			scoreboard = JSON.stringify(scoreboard);
			scoreboard = scoreboard.substring(0, scoreboard.length - 1);
		if(scoreboard!='{')//else add date to scoreboard
			scoreboard+=',';
		scoreboard+='"'+lastdate+'":"'+dailyPoints+'"}';
		console.log("scoreboard = "+scoreboard);
		scoreboard = JSON.parse(scoreboard);
		console.log("scoreboard = "+scoreboard);
		}
		
		//set both timer and lastTimer to 0
		meta["timer"]=0;
		meta["lastTimer"]=0;

		//make a log entry of change in date and date's points in scoreboard
		log.push(JSON.parse('{"key":"date","lastdate":"'+lastdate+'","today":"'+today+'","daily":"'+meta["daily"]+'","weekly":"'+meta["weekly"]+'","scoreboard_date_points":"'+scoreboard[lastdate]+'"}'));
	}

	//Show the timers
	document.getElementById("time").innerHTML = formatTime(meta["lastTimer"]);
	document.getElementById("timeelapsed").innerHTML = formatTime(meta["timer"]);

	//show daily and weekly points on screen
	document.getElementById("daily").innerHTML = meta.daily;
	document.getElementById("weekly").innerHTML = meta.weekly;
	
	//"Tasks" is loaded by default
	list("Tasks");

	//timer to reload page on Midnight
	var timeToMidnight = moment().add('days',1) - moment();
	var timer = setTimeout(function(){refresh();},timeToMidnight);

	//save the data
	localStorage.setItem("meta",JSON.stringify(meta));
	localStorage.setItem("scoreboard",JSON.stringify(scoreboard));
	localStorage.setItem("log",JSON.stringify(log));
}

function list(listname){
	console.log("list function called");
	//save listname to localStorage so loadData can access it
	var meta = JSON.parse(localStorage.getItem("meta"));
	meta["list"]=listname;
	localStorage.setItem("meta",JSON.stringify(meta));

	//No tags for Tasks
	//if(listname=="Tasks")
		//$('.tags').hide();

	//No form and tags for winstate and scoreboard
	if((listname=="Winstate")||(listname=="Scoreboard")){
		$('#input').hide();
		$('.tags').hide();
	}
	else{
		$('#input').show();
		$('.tags').show();
	}
	if(listname=="Scoreboard")
		scoreBoard();
	else
		loadData();
}

function scoreBoard(){	
	console.log("scoreBoard function called");
	//clear list contents (so that double copies of list doesn't forms on reload)
	var list = document.getElementById("list");
	while (list.firstChild)
		list.removeChild(list.firstChild);
	var scoreboard = JSON.parse(localStorage.getItem("scoreboard"));
	var keys = [], name;
	for(name in scoreboard)
		if(scoreboard.hasOwnProperty(name)){
			console.log(scoreboard[name]);
			keys.push(name);
		}

	//for each day
	for(var i=keys.length-1; i>=0; i--){
		//HTML DOM Manipulation
		//whole container - li, checkbox, calendar
		var container = document.createElement("li");
		container.setAttribute('class','list-group-item');
		console.log("keys[i] = "+keys[i]);
		var textNode = document.createTextNode(keys[i]);
		var points = document.createElement("span");
		points.setAttribute('class','badge');
		console.log("scoreboard[keys[i]] = "+scoreboard[keys[i]]);
		points.innerHTML = scoreboard[keys[i]];
		container.appendChild(textNode);
		container.appendChild(points);
		document.getElementById("list").appendChild(container);
	}

}

function setDueDate(date,pos){
	console.log("setDueDate function called");
	//which list?
	var listname = JSON.parse(localStorage.getItem("meta"))["list"];

	//load required data
	var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
	var log = JSON.parse(localStorage.getItem("log"));
	var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));

	//Calculate no. of days remaining
	var diff =  Math.ceil(( Date.parse(date) - Date.parse(new Date()) ) / 86400000);

	//store date
	listDetails[listNames[pos]].duedate=date;

	//make a log pos
	console.log("Tag: "+listDetails[listNames[pos]].tag);
	console.log("Complete Statement = "+'"key":"duedate","pos":"'+pos+'","list":"'+listname+'","duedate":"'+date+',"tag":"'+listDetails[listNames[pos]].tag+'"');
	log.push(JSON.parse('{"key":"duedate","pos":"'+pos+'","list":"'+listname+'","duedate":"'+date+'","tag":"'+listDetails[listNames[pos]].tag+'"}'));

	//date received in yy-mm-dd format. Convert to dd/mm
	date = moment(date).format('DD/MM');

	//Change the text on the screen
	document.getElementById('gd'+pos).innerHTML=date;
	document.getElementById('gn'+pos).innerHTML=diff;

	//save the changes
	localStorage.setItem(listname+"Details",JSON.stringify(listDetails));
	localStorage.setItem("log",JSON.stringify(log));
}

function clearlist(){
	console.log("clearlist function called");
	$('#input').hide();
	$('.tags').hide();
	var list = document.getElementById("list");
	while (list.firstChild)
		list.removeChild(list.firstChild);
	var xmlhttp;
	if (window.XMLHttpRequest)// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	else // code for IE6, IE5
		xmlhttp=new ActiveXect("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var categories = JSON.parse(xmlhttp.responseText);
			for(var category=0; category<2; category++){
				var item = document.createElement("li");
				item.setAttribute("class","list list-item");
				item.innerHTML = categories[category].Name;
				document.getElementById("list").appendChild(item);
			}
		}
		xmlhttp.open("POST","list.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
	}
}

function loadData(){
	console.log("loadData() function called");
	/*Collapse/Show List Icons removed - they were confusing the users - users think that clicking on them will reveal what they are to do for the day
	//set Icon for the first Tag
	document.getElementById('tagIcon0').setAttribute('class','glyphicon glyphicon-collapse-down');
	*/

	//clear list contents (so that double copies of list doesn't forms on reload)
	var list = document.getElementById("list");
	while (list.firstChild)
		list.removeChild(list.firstChild);

	//get all Details
	var meta = JSON.parse(localStorage.getItem("meta"));
	var listname = meta["list"];
	var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
	var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));

	//Display List's name at the top
	document.getElementById("listname").innerHTML=meta["list"];

	//Set Text of the input box ("New "+listname);
	document.getElementById("newEntry").setAttribute('placeholder','Add '+meta["list"]+'...');

	//set text for the firstTag and it's count
	document.getElementById("firstTag").innerHTML = meta[listname][0];
	document.getElementById("tagCount0").innerHTML = meta[meta[listname][0]];

	//what's the index value of next tag to be added?
	var nextTag = 1;
	//firstTag done. How many remaining?
	var tagsRemaining = meta[listname].length - 1;

	//for each goal
	for(var pos=0; pos<listNames.length; pos++){
		//add secondTag tag if this is the first goal belonging to future
		while((tagsRemaining!=0)&&(listDetails[listNames[pos]].tag != meta[listname][nextTag - 1])){
			createTags(nextTag);
			nextTag++;
			tagsRemaining--;
		}
	
		//generate key for current month (goalsDates stored in JSON with keys corresponding to mmyyyy)
		day = moment().format('DD');
		key = moment().format('MMYY');
	
		//HTML DOM Manipulation
		//whole container - li, checkbox, calendar
		var container = document.createElement("div");
		//"inTag"+(nextTag-1) to indentify as to under which tag it is and show/hide when the tag is clicked
		container.setAttribute('class','inTag'+(nextTag-1));
		var inputGroup = document.createElement("div");
		inputGroup.setAttribute("class","input-group");
		var span = document.createElement("span");
		span.setAttribute("class","input-group-addon");
		var checkbox = document.createElement("input");
		checkbox.setAttribute("type","checkbox");
		checkbox.setAttribute("class", "checkbox");
		checkbox.setAttribute("id","check"+pos);
		//if today present in goalsDates (i.e, progress made towards it today), then check the checkbox
		if((listname!="Tasks")&&($.inArray(day, listDetails[listNames[pos]].key)>=0))
			checkbox.setAttribute("checked","true");
		//have label after checkbox - so that the checkbox can be styled
		var label = document.createElement("label");
		label.setAttribute("for","check"+pos);
		//label.setAttribute("style","display:none");
		span.appendChild(checkbox);
		span.appendChild(label);
		inputGroup.appendChild(span);
		//anchor tag instead of "li" to "linkify"
		var node = document.createElement("div");
		//"list-group-item" is a requirement of bootstrap
		//"list-design" class was asked for by AlphaDext so that the same styling can be applied to all the tasks/goals
		node.setAttribute("class","list list-group-item list-design");
		node.setAttribute('id','g'+pos);
		node.setAttribute("data-toggle","dropdown");
		var text = document.createElement('span');
		text.setAttribute('id','posText'+pos);
		text.innerHTML = listNames[pos];
		node.appendChild(text);
	
		//toolbar to contain all options/buttons -- align towards right
		var toolbar = document.createElement("div");
		toolbar.setAttribute('class','toolbar');
		streakCount = document.createElement("span");
		streakCount.setAttribute('id','co'+pos);
		streakCount.setAttribute('class','');
		if(listname!="Tasks"){
			//Display the Streak Count from localStorage
			streakCount.innerHTML=listDetails[listNames[pos]]["count"];
	
			//streakIcon - glyphicon halfling icon of links
			streakIcon = document.createElement("span");
			streakIcon.setAttribute('class','glyphicon glyphicon-link');
			toolbar.appendChild(streakCount);
			toolbar.appendChild(streakIcon);
		}
		if((listname!="Winstate")&&(listname!="Dailies")){
			//duedate - duedate, calendar icon, no.of days remaining & icon for that too
			var duedate = document.createElement("span");
			duedate.setAttribute('class','duedate');
			duedate.setAttribute('id','du'+pos);
			//due - the date on which the pos is due
			var due = document.createElement("span");
			due.setAttribute('id','gd'+pos);
			//dueIcon - glyphicon halfling icon of calendar
			var dueIcon = document.createElement("span");
			dueIcon.setAttribute('class','glyphicon glyphicon-calendar');
			//daysNumber - no.of days remaining
			var daysNumber = document.createElement("span");
			daysNumber.setAttribute('id','gn'+pos);
			//daysIcon - glyphicon halfling icon of time
			var daysIcon = document.createElement("span");
			daysIcon.setAttribute('class','glyphicon glyphicon-time');
			duedate.appendChild(due);
			duedate.appendChild(dueIcon);
			duedate.appendChild(daysNumber);
			duedate.appendChild(daysIcon);
			toolbar.appendChild(duedate);
		}
		if(listname!='Winstate'){
			//editIcon - glyphicon halfling icon of pencil to edit the pos's name
			var editIcon = document.createElement("span");
			editIcon.setAttribute('id','ed'+pos);
			editIcon.setAttribute('class','edit glyphicon glyphicon-pencil');
			toolbar.appendChild(editIcon);
			//deleteIcon - glyphicon halfling icon of trash to delete the pos
			var deleteIcon = document.createElement("span");
			deleteIcon.setAttribute('id','d'+pos);
			deleteIcon.setAttribute('class','del glyphicon glyphicon-trash');
			toolbar.appendChild(deleteIcon);
		}
		if((listname=="Tasks")||(listname=="Dailies")){
			//Points - how many points is this worth and pointsIcon (star)
			var points = document.createElement("span");
			points.setAttribute('class','point badge');
			points.setAttribute('id','p'+pos);
			points.innerHTML = listDetails[listNames[pos]].points;
			toolbar.appendChild(points);
		}
		node.appendChild(toolbar);
		inputGroup.appendChild(node);
		container.appendChild(inputGroup);

		//Duedate Picker Calendar
		var dueCal = document.createElement("div");
		dueCal.setAttribute('id','gs'+pos);
		dueCal.setAttribute('class','duedatepicker');
		container.appendChild(dueCal);
		if(listname!="Tasks"){
			//Streak Calendar
			var cal = document.createElement("div");
			cal.setAttribute('id','gc'+pos);
			cal.setAttribute("class","datepicker");
			//cal (calendar) part of the container
			container.appendChild(cal);
		}
		//container is a part of the list
		document.getElementById("list").appendChild(container);
		//if duedate is set, show it and no. of days remaining on the screen
		if((listname!="Winstate")&&(listDetails[listNames[pos]].duedate!=''))
			setDueDate(listDetails[listNames[pos]].duedate,pos);
	}
	
	//generate the duedate picker calendar
	if(listname!="Dailies")
		$('.duedatepicker').click();
	
	//generate the streaks calendar
	if(listname!="Tasks")
		$('.datepicker').click();
	
	//Hide all calendars by default.
	if(listname!="Dailies")
		$('.duedatepicker').hide();
		
	if((listname!="Tasks")&&(listname!="Winstate"))
	$('.datepicker').hide();

	//if there were no "future" goals at all
	while (tagsRemaining != 0){
		createTags(nextTag);
		nextTag++;
		tagsRemaining--;
	}
}

//function to add the "future" tag to the list
function createTags(nextTag){
	console.log("createTags() function called");
	//which list?
	var listname = JSON.parse(localStorage.getItem("meta"))["list"];
	
	var meta = JSON.parse(localStorage.getItem("meta"));
	
	//get data to display count
	var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));

	//HTML DOM Manipulation
	//Create a new li element
	var node = document.createElement("li");
	
	/*Collapse/Show List Icons removed - they were confusing the users - users think that clicking on them will reveal what they are to do for the day
	//CollapseIcon to contain collapse icon
	var collapseIcon = document.createElement("span");
	collapseIcon.setAttribute('class','glyphicon glyphicon-collapse-down');
	//this id is to be able to access and modify the icon later on
	collapseIcon.setAttribute('id','tagIcon'+nextTag);
	node.appendChild(collapseIcon);
	*/
	var count = document.createElement("span");
	count.setAttribute("class","badge");
	node.setAttribute("class", "tags list list-group-item");
	//id to show/hide all items under a tag
	node.setAttribute("id","tag"+nextTag);
	//Textnode (to contain Tag)
	var textnode = document.createTextNode(meta[listname][nextTag]);
	//"future" count. span to contain bootstrap's badge
	count.setAttribute("id","tagCount"+nextTag);
	//set the count value
	count.innerHTML = meta[meta[listname][nextTag]];
	//textnode and count are part of li (in that order!)
	node.appendChild(textnode);
	node.appendChild(count);
	//li is a part of the list
	document.getElementById("list").appendChild(node);
}

function addPoints(points){
	console.log("addPoints function called");

	//load relevent data
	var meta = JSON.parse(localStorage.getItem("meta"));
	var log = JSON.parse(localStorage.getItem("log"));

	//coming from quickAdd?
	if(points=='quickAdd'){

		//get quickAdd's form data
		points =  document.getElementById("points").value;

		//clear the input field
		var form = document.getElementById("quickAdd");
		form.reset();
	}

	//add points
	meta.daily = parseInt(meta.daily) + parseInt(points);
	meta.weekly = parseInt(meta.weekly) + parseInt(points);

	//points are of atleast 2 digits all the time
	if(meta.daily<10) meta.daily='0'+meta.daily;
	if(meta.weekly<10) meta.weekly='0'+meta.weekly;

	//add log entry
	log.push(JSON.parse('{"key":"addpoints","date":"'+moment().format("DD-MM-YYYY")+'","points":"'+points+'"}'));

	//reflect change in UI
	document.getElementById("daily").innerHTML = meta.daily;
	document.getElementById("weekly").innerHTML = meta.weekly;

	//save changes
	localStorage.setItem('meta',JSON.stringify(meta));
	localStorage.setItem('log',JSON.stringify(log));
}

$(document).ready(function() {
	//Sidebar
	$('[data-toggle=offcanvas]').click(function() {
		$('.row-offcanvas').toggleClass('active');
	});
	$('.datepicker').datepicker({
		inline: true,
		//nextText: '&rarr;',
		//prevText: '&larr;',
		showOtherMonths: true,
		//dateFormat: 'dd MM yy',
		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		//showOn: "button",
		//buttonImage: "img/calendar-blue.png",
		//buttonImageOnly: true,
	});

	//Duedate Picker Calendar
	$(document).on('click','.duedatepicker',function(){
		console.log("$(document).on('click','.duedatepicker',function() called");
		$(".duedatepicker").datepicker({
			beforeShowDay: enableFuture,
			dateFormat:"yy-mm-dd",
			onSelect: function(date){
				//get id of the pos
				var pos = $(this).attr('id').slice(2);
				setDueDate(date,pos);

				//if in Tasks, change the tag it is under
				var meta = JSON.parse(localStorage.getItem("meta"));
				var log = JSON.parse(localStorage.getItem("log"));
				var listname = meta["list"];
				if(listname=="Tasks"){
					var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
					//Calculate no. of days remaining
					var diff =  Math.ceil(( Date.parse(date) - Date.parse(new Date()) ) / 86400000);
					listDetails[listNames[pos]].tag = (diff==1)? "Today" :(diff==2)? "Tomorrow" :(diff<8)? "This Week" : "Later";
					//add a log entry
					log.push(JSON.parse('{"key":"tag","list":"'+listname+'","pos":"'+pos+'","tag":"'+listDetails[listNames[pos]].tag+'"}'));
					localStorage.setItem(listname+"Details",JSON.stringify(listDetails));
					loadData();
				}
			}
		});
	});

	function enableFuture(date){
		console.log("enableFuture() function called");
		//which list?
		var listname = JSON.parse(localStorage.getItem("meta"))["list"];

		//current goals position
		var pos = ($(this).attr('id')).slice(2);

		//get goalsDetails
		listNames = JSON.parse(localStorage.getItem(listname+"Names"));
		listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
	
		//Date in standard format, convert to yyyy-mm-dd
		date=moment(date).format('YYYY-MM-DD');

		//alter css if it's the duedate
		if((listname!="Winstate")&&(date==listDetails[listNames[pos]].duedate))
			return[true,'tickDay'];

		//enable future days
		if(( Date.parse(date) - Date.parse(new Date()))>0)
			return[true];

		//remaining days can't be clicked
		return[false];
	}

	//Streak Calendars
	$(document).on('click','.datepicker',function(){
		console.log("$(document).on('click','.datepicker',function() called");
		$(".datepicker").datepicker({
			beforeShowDay: alterCSS,
			dateFormat: "mm-dd-yy",
			onSelect: addDay
		});
	});

	//alter css for days on which progress was made and disable future days
	function alterCSS(date,pos){
		console.log("alterCSS() function called");
		//which list?
		var listname = JSON.parse(localStorage.getItem("meta"))["list"];

		//current goals position (if pos is not given as a parameter - get it from the attribute's id
		var pos = pos||($(this).attr('id')).slice(2);

		//get goalsDates
		listNames = JSON.parse(localStorage.getItem(listname+"Names"));
		listDetails = JSON.parse(localStorage.getItem(listname+"Details"));

		//generate key for the month (goalsDates stored in JSON with keys corresponding to mmyyyy)
		var key = moment(date).format('MMYYYY');

		//alter css if progress was made
		if($.inArray(day,listDetails[listNames[pos]][key])>=0)
			return[true,'tickDay'];

		//disable future days
		if(( Date.parse(date) - Date.parse(new Date()))>0)
			return[false];

		//remaining days can be clicked
		return[true];
	}

	//Checkboxes
	$(document).on('change','.checkbox',function(){
		console.log("$(document).on('change','.checkbox',function() called");
		//which list?
		var listname = JSON.parse(localStorage.getItem("meta"))["list"];
		//load relevent data
		var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
		var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
		//get goal's id
		var pos = ($(this).parent().next().attr('id')).slice(1);

		//add points if Tasks or Dailies
		if((listname=="Tasks")||(listname=="Dailies"))
			addPoints(parseInt(listDetails[listNames[pos]].points));
	
		//if it's a task, delete it
		if(listname == "Tasks") 
			del(pos);

		//else add today's date to it's calendar,if "Dailies" then continue only if Today is not already present in it's data.
		else if ((listname!="Dailies")||(listDetails[listNames[pos]].key === undefined)||($.inArray(day, listDetails[listNames[pos]].key) == -1))
			addDay(date,pos);
	});

	//function executed when any day on a calendar is clicked
	//function to add the day to JSON data and recalculate streak
	function addDay(date, pos){
		console.log("addDay() function called");
		//which list?
		var listname = JSON.parse(localStorage.getItem("meta"))["list"];

		//get id of the pos
		//if nothing has been sent in "pos" parameter - i.e., calendar was clicked and not checkbox
		if(isNaN(pos))
			pos = $(this).attr('id').slice(2);

		console.log("pos = "+pos);
		//load required data
		var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
		var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
		var log = JSON.parse(localStorage.getItem("log"));

		//date received as string - get day, key, month, year from date
		console.log('date = '+date);
		var day = moment(date).format('DD');
		var key = moment(date).format('MMYYYY');

		console.log("day = "+day);
		console.log("key = "+key);

		//key doesn't exists? add it!
		if(listDetails[listNames[pos]][key] === undefined)
			listDetails[listNames[pos]][key]=new Array();

		//day doesn't exists? add day
		if($.inArray(day, listDetails[listNames[pos]][key]) == -1)
			listDetails[listNames[pos]][key].push(day);
		//day already existed? remove day
		else 
			listDetails[listNames[pos]][key].splice(listDetails[listNames[pos]][key].indexOf(day),1);

		//recalculate streak
		listDetails[listNames[pos]]["count"]=-1;  //-1 because the do...while loop will execute first time even if no entries present
		//looping around past days
		var yesterDate = moment();
		do{
			listDetails[listNames[pos]]["count"]++;
			yesterDate = moment(yesterDate).subtract('days',1);
			var yesterDay = moment(yesterDate).format('DD');
			var yesterKey = moment(yesterDate).format('MMYYYY');
		}while($.inArray(yesterDay, listDetails[listNames[pos]][yesterKey]) >= 0);
		//add today if present
		//get today's paramentes
		var currentDay = moment().format('DD');
		var currentKey = moment().format('MMYYYY');
		if($.inArray(currentDay, listDetails[listNames[pos]][currentKey]) >=0)
			listDetails[listNames[pos]]["count"]++;

		//make a log pos - (1) KEY-DAY in the calendar (2) Count
		log.push(JSON.parse('{"key":"addday","list":"'+listname+'","pos":"'+pos+'","monthyearkey":"'+key+'","day":"'+day+'","count":"'+listDetails[listNames[pos]]["count"]+'"}'));

		//update UI with latest data
		document.getElementById("co"+pos).innerHTML = listDetails[listNames[pos]]["count"];

		//save changes
		localStorage.setItem(listname+"Details",JSON.stringify(listDetails));
		localStorage.setItem("log",JSON.stringify(log));
	}

	//edit points for an pos
	$(document).on('click','.point', function(e){
		console.log("$(document).on('click','.point', function(e) function called");
		//To not click on the .list too
		e.stopImmediatePropagation();

		//which list is this?
		var listname = JSON.parse(localStorage.getItem("meta"))["list"];

		//get required data
		var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
		var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
		var log = JSON.parse(localStorage.getItem("log"));

		//get id
		var pos = $(this).attr('id').slice(1);

		$('#p'+pos).attr('contentEditable',true).focus().blur(function(){
			$(this).attr('contentEditable',false);
			listDetails[listNames[pos]].points = $(this).text();
			//make a log pos
			log.push(JSON.parse('{"key":"points","list":"'+listname+'","pos":"'+pos+'","points":"'+listDetails[listNames[pos]].points+'"}'));
			//save the changes
			localStorage.setItem(listname+'Details',JSON.stringify(listDetails));
			localStorage.setItem("log",JSON.stringify(log));
		});
	});

	//edit pencil icons
	$(document).on('click','.edit', function(e){
		console.log("$(document).on('click','.edit', function(e) called");
		//To not click on the .list too
		e.stopImmediatePropagation();
		//get id
		var pos = $(this).attr('id').slice(2);
		var oldValue = $('#posText'+pos).text();
		$('#posText'+pos).attr('contentEditable',true).focus().blur(function(){
			$(this).attr('contentEditable',false);
			var newValue = $(this).text();
			//getting some error if oldValue=newValue
			if((oldValue!=newValue)&&(newValue!=""))
				edit(oldValue, newValue);
		});
	});

	//delete icons
	$(document).on('click','.del',function(e){
		console.log("$(document).on('click','.del',function(e) fuction called");
		//To not click on the .list too
		e.stopImmediatePropagation();
		//get id
		var pos = $(this).attr('id').slice(1);
		del(pos);
	});

	//Duedate setter
	$(document).on('click','.duedate',function(e){
		console.log("$(document).on('click','.duedate',function(e) called");
		//To not click on the .list too
		e.stopImmediatePropagation();
		//Get id of the goal
		var pos = $(this).attr('id').slice(2);
		//Toggle the duedatepicker of this goal
		$('#gs'+pos).toggle();
		//Hide the streak calenar of this goal
		$('#gc'+pos).hide();
	});

	//li elements, lists
	$(document).on('click', '.list', function(e){
		console.log("$(document).on('click', '.list', function(e) called");
		//which list?
		var listname = JSON.parse(localStorage.getItem("meta"))["list"];

		//Do not show/hide anything for "Yes! I did it!" page
		if (listname!="Winstate"){
			$("#popup").animate({left:"335px"});
			//Get id of the goal
			var pos = ($(this).attr('id')).slice(1);

			//Hide all except this one - streaks calendar
			$('.datepicker:not(#gc'+pos+')').hide();
			//toggle for this one
			$('#gc'+pos).toggle();
	
			//Hide all duedate pickers
			$('.duedatepicker').hide();
		}
	});

	/*Collapse/Show List Icons removed - they were confusing the users - users think that clicking on them will reveal what they are to do for the day
	//tags - present, future, today, etc...
	$(document).on('click', '.tags', function(){

		//Get id of the Tag
		var tag = ($(this).attr('id')).slice(3);
		$('.inTag'+tag).toggle();

		//toggle the collapse gliphicon icon
		$('#tagIcon'+tag).toggleClass('glyphicon-collapse-down');
		$('#tagIcon'+tag).toggleClass('glyphicon-expand');
	});
	*/
	
	//Functions to enable drag and drop property to the "list" element which is a ul list containg all goals names
	//Taken from: http://jqueryui.com/sortable/ and http://api.jqueryui.com/sortable/#event-update
	$("#list").sortable({
		start: function(event, ui) {
			console.log("start function in sortable called");
			//hide all calendars
			$('.datepicker').hide();
			$('.duedatepicker').hide();
			//save the initial position of item being dragged
			var meta = JSON.parse(localStorage.getItem("meta"));
			meta["intitalPos"] = $(ui.item).index()
			localStorage.setItem("meta",JSON.stringify(meta));
		},
		update: function(event, ui) {
			console.log("update() function in sortable called");
			//position changes
			var initialPos = JSON.parse(localStorage.getItem("meta"))["initialPos"];
			var finalPos = $(ui.item).index();

			//get all required data
			var meta = JSON.parse(localStorage.getItem("meta"));
			var listname = meta["list"];
			var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
			var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
			var log = JSON.parse(localStorage.getItem("log"));

			//uncount the tags -- from initialPos and finalPos
			var thisPos = -1;
			var initialTag = 0;
			var finalTag= 0;
			var correctInitial = initialPos;
			//because initially it might have been just below a Tag
			if(initialPos>finalPos) initialPos++;
			var correctFinal = finalPos;
			$(".list").each(function() {
				thisPos++;
				if($(this).hasClass("tags")){
					if(thisPos<finalPos){
						correctFinal--;
						finalTag++;
					}
				if(thisPos<initialPos){
					correctInitial--;
					initialTag++;
					}
				}
			});

			//update listNames with changed position
			listNames.move(correctInitial,correctFinal);

			//mark the tag
			listDetails[listNames[correctFinal]].tag = meta[listname][finalTag];

			//change tags' count
			meta[meta[listname][finalTag]]++;
			meta[meta[listname][initialTag]]--;

			//add a log entry
			log.push(JSON.parse('{"key":"pos","list":"'+listname+'","initialPos":"'+correctInitial+'","finalPos":"'+correctFinal+'","initialTag":"'+meta[listname][initialTag]+'","finalTag":"'+meta[listname][finalTag]+'"}'));

			//change the class of this one's container --> to hide when a tag is clicked
			$('#g'+correctInitial).parent().parent().removeClass().addClass('inTag'+finalTag);

			//show correct count on screen
			document.getElementById("tagCount"+finalTag).innerHTML++;
			document.getElementById("tagCount"+initialTag).innerHTML--;

			//save the data
			localStorage.setItem("meta",JSON.stringify(meta));
			localStorage.setItem(listname+"Names",JSON.stringify(listNames));
			localStorage.setItem(listname+"Details",JSON.stringify(listDetails));
			localStorage.setItem("log",JSON.stringify(log));

			//change the duedate if "Tasks"
			if((listname=="Tasks")&&(initialTag!=finalTag)){
				//the task is due 'n' days from today
				var n = finalTag; //for finalTag=0,1 i.e, today and tommorrow
				if(finalTag==2) n = 7;
				else if(finalTag==3) n= 14;	
				//set new Duedate
				var duedate = moment().add('days',n).format('YYYY-MM-DD');
				setDueDate(duedate,correctFinal);
			}

			//Reload the whole list, so every pos gets new ID
			loadData();

		},
		//Ability to drag only along the y-axis
		axis: 'y',
		//Do not drag the calendar and the "future" tag. From: http://jqueryui.com/draggable/#handle
		cancel: "div.cal",
		cancel: ".tags"
	});
	$("#list").disableSelection();
});

//add new entries
function save(){
	console.log("save() function called");

	//Get data from the form
	var newEntry = document.getElementById("newEntry").value;		//Get 'goal' from form

	//no value? terminate function
	if (newEntry=="")
		return false;

	//Get localStorage Data
	var meta = JSON.parse(localStorage.getItem("meta"));
	var listname = meta["list"];
	var log = JSON.parse(localStorage.getItem("log"));
	var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
	var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));

	//clear the form.
	var form = document.getElementById("input");
	form.reset();

	//add to goalsNames
	listNames.unshift(newEntry);
	//listNames.push(newEntry);	//To add pos at the end

	//duedate is null by default
	var duedate = "";

	//If a Task, set today as duedate by default
	if(listname=="Tasks")
	duedate = moment().format('YYYY-MM-DD');

	listDetails[newEntry] = new Object(JSON.parse('{"count":0,"duedate":"'+duedate+'","points":0,"tag":"'+meta[listname][0]+'"}'));

	//increment "present" count
	meta[meta[listname][0]]++;

	//add an entry in log
	log.push(JSON.parse('{"key":"add","list":"'+listname+'","name":"'+newEntry+'","duedate":"'+duedate+'","tag":"'+meta[listname][0]+'"}'));

	//save data
	localStorage.setItem("meta", JSON.stringify(meta));
	localStorage.setItem(listname+"Names", JSON.stringify(listNames));
	localStorage.setItem(listname+"Details", JSON.stringify(listDetails));
	localStorage.setItem("log",JSON.stringify(log));

	loadData();     //refresh list with the new goal present
}

//function to edit the name of an pos
function edit(oldName, newName){
	console.log("edit function called");
	//load all data
	var listname = JSON.parse(localStorage.getItem("meta"))["list"];
	var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
	var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
	var log = JSON.parse(localStorage.getItem("log"));

	//edit in goalsNames. From: http://www.w3schools.com/jsref/jsref_splice.asp and http://www.w3schools.com/jsref/jsref_indexof_array.asp
	listNames.splice(listNames.indexOf(oldName),1,newName);

	//edit in goalsDetails
	listDetails[newName] = listDetails[oldName];
	delete listDetails[oldName];

	//add entry in log
	log.push(JSON.parse('{"key":"edit","list":"'+listname+'","pos":"'+listNames.indexOf(newName)+'","oldName":"'+oldName+'","newName":"'+newName+'"}'));

	//saving all data
	localStorage.setItem(listname+"Names",JSON.stringify(listNames));
	localStorage.setItem(listname+"Details",JSON.stringify(listDetails));
	localStorage.setItem("log",JSON.stringify(log));

	//reload list
	loadData();
}

function del(pos){
	console.log("del() function called");
	//load all data
	var meta = JSON.parse(localStorage.getItem("meta"));
	var listname = meta["list"];
	var listNames = JSON.parse(localStorage.getItem(listname+"Names"));
	var listDetails = JSON.parse(localStorage.getItem(listname+"Details"));
	var log = JSON.parse(localStorage.getItem("log"));

	//make a log entry
	log.push(JSON.parse('{"key":"del","list":"'+listname+'","pos":"'+pos+'","tag":"'+listDetails[listNames[pos]].tag+'"}'));

	//decrementing tag's count
	meta[listDetails[listNames[pos]].tag]--;

	//remove from listDetails
	delete listDetails[listNames[pos]];

	//remove from listNames. From: http://www.w3schools.com/jsref/jsref_splice.asp
	listNames.splice(pos,1);

	//saving listNames and listDetails
	localStorage.setItem("meta",JSON.stringify(meta));
	localStorage.setItem(listname+"Names",JSON.stringify(listNames));
	localStorage.setItem(listname+"Details",JSON.stringify(listDetails));
	localStorage.setItem("log",JSON.stringify(log));

	//reload list
	loadData();
}
Array.prototype.move = function (old_index, new_index) {
    this.splice(new_index, 0, this.splice(old_index, 1)[0]);
};