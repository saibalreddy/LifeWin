$(document).ready(function(){
//to detect pressing of Enter key  by user
$('body').on('keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code === 13) {
			start();
               }
        });
		});
		
var sec=0,time,SD,timer,state,setTarget,timer=$('#timer'),pomocount=0,statedisp=$('#state'),pomo=$('#pomo'),flag=0,rest=$('#rest');
$('#pause').css("opacity","0");
      state = {
               time:0,type: 0
               };
      	//function to switch between the states
		function Togstate()
		{
		//to display the pomodoro count
		pomo=$('#pomo');
		//to check to run for 4 pomodoros
		if(pomocount<8)
		{
	    if(state.type=='work')
		{
		state.type='brek';
		//to prettify the output
		state.time=$('#' +state.type).val() <=9 ? '0' +$('#' +state.type).val() : $('#' +state.type).val();
		timer.html('<span class="'+ state.type +'">' + state.time +':00</span>');
		statedisp.html('<span style=\"color:#FF3333;\">Break</span>');
		sec=0;if(state.time > 0){SD=setTimeout('countdown()',0);}
		}
		else if(state.type=='brek')
		{
		state.type='work';
		state.time=$('#' +state.type).val() <=9 ? '0' +$('#' +state.type).val() : $('#' +state.type).val();
		timer.html('<span class="'+ state.type +'">' +state.time+':00</span>');
		if(pomocount=='1')
		{pomo.html(pomocount+1);}
		else if(pomocount=='2'){pomo.html(pomocount);}
		else if(pomocount=='4'){pomo.html('3');}
		else if(pomocount=='6'){pomo.html('4');}
		statedisp.html('<span style=\"color:#0C3;\">Working</span>');
		sec=0; if(state.time > 0){SD=setTimeout('countdown()',0);}
		}
		pomocount++;
		}
		// to check for the rest time
		else if(pomocount>=8 && state.type=='brek' || state.type=='rest')
		{ 
		  sec=0;clearTimeout(SD);
		state.type='rest'; statedisp.html('<span style=\"color:blue\">Rest</span>'); 
		state.time=$('#' +state.type).val() <=9 ? '0' +$('#' +state.type).val() : $('#' +state.type).val();
		timer.html('<span class="'+ state.type +'">' +state.time+':00</span>');
		if(state.time > 0)
		{SD=setTimeout('countdown()',0);}
		}
		}
		//the function for rest time
		function rest()
		{                                                                                                                                                                                                                                                                                                                                                                                                       pomo=$('#pomo'); timer=$('#timer'),pomocount=0,statedisp=$('#state')
		 sec=0;clearTimeout(SD);
		state.type='rest'; statedisp.html('<span style=\"color:blue\">Rest</span>'); 
		state.time=$('#' +state.type).val() <=9 ? '0' +$('#' +state.type).val() : $('#' +state.type).val();
		timer.html('<span class="'+ state.type +'">' +state.time+':00</span>');
		if(state.time > 0)
		         {SD=setTimeout('countdown()',0);  }
				 else{
		      sec=0;clearTimeout(SD);
              pomocount=0;pomo.html('0'); pomo.html('1');
              state.type='brek';
              workv=$('#work').val();
              workval=workv <=9 ?"0" + workv:workv;
			   $('#timer').html('<span class=\"work\">0' + workv+':00</span>');
              $('#page').css("opacity","1");
               $('#pause').html('');
              $('#pause').css("opacity","0");
              
	      	  
		  }
		}
		
function start()
{
pomo=$('#pomo');
statedisp=$('#state');
if(statedisp.text()=='Stopped' && pomocount==0 && (state.time==0 || sec==0))
{
pomo.html('1');
state.type='brek';
workv=$('#work').val();
workval=workv <=9 ?"0" + workv:workv;
$('#start').html('Pause');
$('#page').css("opacity","1");
$('#pause').html('');
$('#pause').css("opacity","0");
$('#timer').html('<span class=\"work\">0' + workv+':00</span>');
SD=setTimeout('Togstate()',0);
}
else if(statedisp.text()!='Stopped' && (state.time!=0 || sec!=0) && flag==0)
{
flag=1;
$('#start').html('Restart');
dr=$('#page').css("opacity","0.1");
$('#pause').html('Paused<br/><span class=\"info\">(click or press Enter to Start/Stop)</span></small>');
$('#pause').css("opacity","1");
clearTimeout(SD);

}
else if(statedisp.text()!='Stopped' && flag==1)
{
$('#start').html('Pause');
$("#sound")[0].play();
$('#page').css("opacity","1");
$('#pause').html('');
$('#pause').css("opacity","0");
setTimeout('countdown()',0);flag=0;
}
else if($('#start').text()=='Reset' && flag==0)
{
sec=0;clearTimeout(SD);
$('#start').html('Start');flag=0;
$('#page').css("opacity","1");
$('#pause').html('');
$('#pause').css("opacity","0");
timer.html('00:00');state.time=0;pomocount=0;pomo.html('0');
statedisp.html('<span style=\"color:#000;\">Stopped</span>');
}
}

function countdown()
{
timer=$('#timer');statedisp=$('#state');
if(state.type=='work')
{
statedisp.html('<span style=\"color:#0C3;\">Working</span>');
}
else if(state.type=='brek')
{
statedisp.html('<span style=\"color:#FF3333;\">Break</span>');
}
else if(state.type=='rest')
{
statedisp.html('<span style=\"color:blue\">Rest</span>');
flag=0; timer.html('<span style=\"color:blue;\">00:00</span>'); pomocount=0;pomo.html('');
}
sec--;
if(sec==-1)
{
sec=59;  state.time=state.time-1;
}
if (sec<=9) 
{ sec = "0" + sec; }
time = (state.time<=9 ? "0" + state.time : state.time) + " : " + sec + "";
SD=setTimeout('countdown()',1000);
if(state.time=='00'&& sec=='00' )
{
if(state.type=='rest'){
clearTimeout(SD); pomocount=0; pomo.html('1'); 
state.type='brek'; workv=$('#work').val(); 
workval=workv <=9 ?"0" + workv:workv; 
$('#timer').html('<span class=\"work\">0' + workv+':00</span>');
SD=setTimeout('Togstate()',0);}
else{clearTimeout(SD);  SD=setTimeout('Togstate()',0);
}}
else 
{timer.html('<span class="'+ state.type +'">' +time+'</span>');}
}
function reset()
{
sec=0;clearTimeout(SD);
$('#start').html('Start');flag=0;
timer.html('00:00');state.time=0;pomocount=0;pomo.html('0');
statedisp.html('<span style=\"color:#999;\">Stopped</span>');
}