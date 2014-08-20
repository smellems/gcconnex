function disconnect() {
	unpublish();
	session.disconnect();
	hide('navigation');
	show('endcall');
	var div = document.getElementById('canvas');
	div.parentNode.removeChild(div);
	eval(resize +'300,330);');
}

function sessionConnectedHandler(event) {			
	hide('loading');
	show('canvas');

	for (var i = 0; i < event.streams.length; i++) {

		if (event.streams[i].connection.connectionId != session.connection.connectionId) {
			totalStreams++;
		}
		addStream(event.streams[i]);
	}

	eval(publishFunction);

	resizeWindow();
	show('navigation');
	show('unpublishLink');
	hide('publishLink');
}
function addStream(stream) {
	if (stream.connection.connectionId == session.connection.connectionId) {
		return;
	}
	var div = document.createElement('div');	
	var divId = stream.streamId;	
	div.setAttribute('id', divId);	
	div.setAttribute('class', 'camera');
	document.getElementById('otherCamera').appendChild(div);
	var params = {width: vidWidth, height: vidHeight};
	subscribers[stream.streamId] = session.subscribe(stream, divId, params);
}

function publish() {
	if (!publisher) {
		var parentDiv = document.getElementById("myCamera");
		var div = document.createElement('div');		
		div.setAttribute('id', 'opentok_publisher');
		parentDiv.appendChild(div);
		var params = {width: vidWidth, height: vidHeight , name: name};
		publisher = session.publish('opentok_publisher', params); 	
		resizeWindow();
		show('unpublishLink');
		hide('publishLink');
	}
}

function inviteUser() {
	eval(invitefunction + '("' + baseUrl + 'plugins/broadcast/invite.php?action=invite&roomid='+ sessionId +'","invite","status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=400,height=190",400,190,"'+broadcast_language_11+'");'); 
}

function resizeWindow() {
	if (publisher) {
		width = (totalStreams+1)*(vidWidth+30);
		document.getElementById('canvas').style.width = (totalStreams+1)* vidWidth +'px';
	} else {
		width = (totalStreams)*(vidWidth+30);
		document.getElementById('canvas').style.width = (totalStreams)* vidWidth +'px';
	}

	if (width < vidWidth + 30) { width = vidWidth+30; }
	if (width < 300) { width = 300; }

	eval(resize +'width,' + vidHeight +'+ 165);');

	var h = vidHeight;
	if( typeof( window.innerWidth ) == 'number' ) {
		h = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		h = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		h = document.body.clientHeight;
	}

	if (document.getElementById('canvas') && document.getElementById('canvas').style.display != 'none') {
		if (h > vidHeight){
			offset = (h-30-vidHeight)/2;
			document.getElementById('canvas').style.marginTop = offset+'px';
		} else {
			document.getElementById('canvas').style.marginTop = '0px';
		}
	}

}

function connect() {
	session.connect(apiKey, token);
}

function unpublish() {

	if (publisher) {
		session.unpublish(publisher);
	}
	
	publisher = null;
	
	show('publishLink');
	hide('unpublishLink');
	resizeWindow();
}

function streamCreatedHandler(event) {

	for (var i = 0; i < event.streams.length; i++) {
		if (event.streams[i].connection.connectionId != session.connection.connectionId) {
			totalStreams++;
		}
		addStream(event.streams[i]);
	}
	resizeWindow();
}

function streamDestroyedHandler(event) {

	for (var i = 0; i < event.streams.length; i++) {
		if (event.streams[i].connection.connectionId != session.connection.connectionId) {
			totalStreams--;
		}
	}
	resizeWindow();
}

function sessionDisconnectedHandler(event) {
	publisher = null;
}

function connectionDestroyedHandler(event) {
}

function connectionCreatedHandler(event) {
}

function exceptionHandler(event) {
}


function show(id) {
	document.getElementById(id).style.display = 'block';
}

function hide(id) {
	document.getElementById(id).style.display = 'none';
}