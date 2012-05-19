Y.one('#sport_select_bet').on('change',
	function(e)
	{ 
		Y.one('#eventValues').setContent();
		Y.one('#groupContent').setContent();
		Y.one('#eventsTypesContent').setContent();
		Y.one('#eventsContent').setContent();
		Y.one('#eventStart').setContent('');
	 	Y.one('#eventEnds').setContent('');
		
		var uri ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicehtml','action'=>'view','params'=>'view=View_Admin_Widgets_GroupsSelect')) ?>&sports_id='+e.currentTarget.get('value');
		var cfg = { 
	    	method: 'POST', 
	         on: { 
					success: function(id, o, args) 
					{ 	 
						var result = Y.JSON.parse(o.responseText);
						if(result.status=='ok')
				      	{   
							 Y.one('#groupContent').setContent(result.html); 
							 setGroupListner(); 
							 eval(result.javascript);
						}
				      	else if(result.status=='error')
				      	{
				      		alert("Error on server, please try later")
				      	}
					},
					failure: function(){alert("Error on server, please try later")},
			}, 
	    }; 
		Y.io(uri, cfg);  
		
		var uriEventsTypes ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicehtml','action'=>'view','params'=>'view=View_Admin_Widgets_EventTypesSelect')) ?>&sports_id='+e.currentTarget.get('value');
		var cfgEventsTypes = { 
	    	method: 'POST', 
	         on: { 
					success: function(id, o, args) 
					{ 	 
						var result = Y.JSON.parse(o.responseText);
						if(result.status=='ok')
				      	{   
							 Y.one('#eventsTypesContent').setContent(result.html);
							 setEventTypesListener(); 
							 eval(result.javascript);
						}
				      	else if(result.status=='error')
				      	{
				      		alert("Error on server, please try later")
				      	}
					},
					failure: function(){alert("Error on server, please try later")},
			}, 
	    }; 
		Y.io(uriEventsTypes, cfgEventsTypes);  
	}
)
 
 
Y.one('#saveBet').on('click',
	function(e)
	{    
		disableError('#errorGroup'); 
		disableError('#errorEventsContent');
		disableError('#errorTypesContent');
		disableError('#errorBetName'); 
		var isValid = true;
		
		var  oddsData ="";
		Y.all('.oddsInput').each(function (node) 
		{
		    oddsData+='&model[Model_EventBetsModel][odds_data]['+node.getAttribute('valueid')+']='++node.getAttribute('value');
		   
		});
		 
		if(Y.one('select[name=groups_id]')==null)
		{ 
			Y.one('#errorGroup').setStyle('display','block'); 
			Y.one('#errorGroup').setContent('Please select group'); 
			isValid = false;
		} 
		else
		{
			if(Y.one('select[name=groups_id]').get('value')=='')
			{
				Y.one('#errorGroup').setStyle('display','block'); 
				Y.one('#errorGroup').setContent('Please select group');
				isValid = false;
			}
		}
		 
		if(Y.one('#betName').get('value')=='')
		{
			Y.one('#errorBetName').setStyle('display','block'); 
			Y.one('#errorBetName').append('<br />Please set event name');
			isValid = false;
		}
		 
		if(Y.one('select[name=event_types_id]')==null)
		{ 
			Y.one('#errorTypesContent').setStyle('display','block'); 
			Y.one('#errorTypesContent').setContent('Event Type not set'); 
			isValid = false;
		} 
		else
		{
			if(Y.one('select[name=event_types_id]').get('value')=='')
			{
				Y.one('#errorTypesContent').setStyle('display','block'); 
				Y.one('#errorTypesContent').setContent('Event type not set');
				isValid = false;
			}
		}
		
		if(Y.one('select[name=bets_id]')==null)
		{ 
			Y.one('#errorEventsContent').setStyle('display','block'); 
			Y.one('#errorEventsContent').setContent('Event not set'); 
			isValid = false;
		} 
		else
		{
			if(Y.one('select[name=bets_id]').get('value')=='')
			{
				Y.one('#errorEventsContent').setStyle('display','block'); 
				Y.one('#errorEventsContent').setContent('Event not set');
				isValid = false;
			}
		}
		   
		if(isValid == false)
		{
			return;
		}
		   
		var postData = '&model[Model_EventBetsModel][bets_id_FK]='+Y.one('select[name=bets_id]').get('value'); 
		postData+= '&model[Model_EventBetsModel][event_types_id_FK]='+Y.one('select[name=event_types_id]').get('value'); 
		postData+= '&model[Model_EventBetsModel][event_bets_name]='+Y.one('#betName').get('value'); 
		
		 
		 
		var uri ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicejson','action'=>'model')) ?>';
		var cfg = { 
	    	method: 'POST', 
	    	data:'method=insert'+postData,
	         on: { 
	         
					success: function(id, o, args) 
					{ 	 
						var result = Y.JSON.parse(o.responseText);
						if(result.status=='ok')
				      	{   
							alert('Event saved')
						}
				      	else if(result.status=='error')
				      	{
				      		alert("Error on server, please try later")
				      	}
					},
					failure: function(){alert("Error on server, please try later")},
			}, 
	    }; 
		var request = Y.io(uri, cfg);  
	}
)
  
function disableError(id)
{
		Y.one(id).setStyle('display','none'); 
		Y.one(id).setContent(''); 
}


function setGroupListner()
{  
 	Y.one('select[name=groups_id]').on('change',
		function(e)
		{  
			var uri ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicehtml','action'=>'view','params'=>'view=View_Admin_Widgets_TeamsTable')) ?>&groups_id='+e.currentTarget.get('value');
			var cfg = { 
		    	method: 'POST', 
		         on: { 
						success: function(id, o, args) 
						{ 	 
							var result = Y.JSON.parse(o.responseText);
							if(result.status=='ok')
					      	{   
								 Y.one('#teamsContent').setContent(result.html);
								 eval(result.javascript);
							}
					      	else if(result.status=='error')
					      	{
					      		alert("Error on server, please try later")
					      	}
						},
						failure: function(){alert("Error on server, please try later")},
				}, 
		    }; 
			Y.io(uri, cfg);  
		 
			var uriEvents ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicehtml','action'=>'view','params'=>'view=View_Admin_Widgets_EventsSelect')) ?>&groups_id='+e.currentTarget.get('value');
			var cfgEvents = { 
		    	method: 'POST', 
		         on: { 
						success: function(id, o, args) 
						{ 	 
							var result = Y.JSON.parse(o.responseText);
							if(result.status=='ok')
					      	{   
								 Y.one('#eventsContent').setContent(result.html);
								   setBetsListener();
								 eval(result.javascript);
							}
					      	else if(result.status=='error')
					      	{
					      		alert("Error on server, please try later")
					      	}
						},
						failure: function(){alert("Error on server, please try later")},
				}, 
		    }; 
			Y.io(uriEvents, cfgEvents);  
		} 
	)
} 

function setEventTypesListener()
{  
 	Y.one('select[name=event_types_id]').on('change',
		function(e)
		{  
			var uri ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicehtml','action'=>'view','params'=>'view=View_Admin_Widgets_CreateBetOddsTable')) ?>&event_types_id='+e.currentTarget.get('value');
			var cfg = { 
		    	method: 'POST', 
		         on: { 
						success: function(id, o, args) 
						{ 	 
							var result = Y.JSON.parse(o.responseText);
							if(result.status=='ok')
					      	{   
								 Y.one('#eventValues').setContent(result.html); 
								 eval(result.javascript);
							}
					      	else if(result.status=='error')
					      	{
					      		alert("Error on server, please try later")
					      	}
						},
						failure: function(){alert("Error on server, please try later")},
				}, 
		    }; 
			Y.io(uri, cfg);   
		} 
	)
}

function setBetsListener()
{  
 	Y.one('select[name=bets_id]').on('change',
		function(e)
		{   
			var uri ='<?php echo  Application::getRouter()->getFullUrl(array('controller'=>'servicejson','action'=>'model')) ?>';
			 
			var cfg = { 
		    	method: 'POST', 
		    	data:'method=select&model[Model_BetsModel][filter][bets_id]='+e.currentTarget.get('value'),
		         on: { 
						success: function(id, o, args) 
						{ 	 
							var result = Y.JSON.parse(o.responseText);
							if(result.status=='ok')
					      	{   
					      		 var add = result.data.add_date; 
					      		 var end = result.data.end_date;
					      		 
					      		 Y.one('#eventStart').setContent(add);
	 							 Y.one('#eventEnds').setContent(end);
					      		  
								 eval(result.javascript);
								 return;
							}
					      	else if(result.status=='error')
					      	{
					      		alert("Error on server, please try later")
					      	}
						},
						failure: function(){alert("Error on server, please try later")},
				}, 
		    }; 
			Y.io(uri, cfg);   
		} 
	)
}