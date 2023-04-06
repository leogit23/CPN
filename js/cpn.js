function send(pac){
	var r;
	
	$.ajax({
		url: "servidor.php",
		type: "post",
		data: "pac=" + pac,
		async:false,
		success: function(data) {
			r = data;
		}
	});
	
	return r;
}

//@2023

function informationRequest(requestHeader, requestBody){
	var r;
	
	$.ajax({
		url: "servidor.php",
		type: "post",
		data: {
			'requestHeader': requestHeader,
			'requestBody': requestBody
		},
		async:false,
		success: function(data) {
			r = data;
		}
	});
	
	return JSON.parse(r);
}

function getJSONByFieldValue(json, field, value){
	for (const currentValue of json){
		if(currentValue[field] == value){ return currentValue; }
		//console.log( currentValue[field] );
	}
	return "Not-found";
}

//@2023

function isScripter(){
	//alert(window.navigator.userAgent);
	if(window.navigator.userAgent == "ExNet"){ return true; } return false;
}

function openMobileChat(serial){
	//alert(serial);
	setURL("/conv.php?id=" + serial + "&anticache=5a4564sd564a6d5as4d");
}

function setURL(url){
	window.location.href = url;
}

function refresh(){
	window.location.reload(false);
}

function intBol(num){
	if(num == 1) { return true; }
	return false;
}

function cheArrContem(arr, val){
	for(a = 0; a < arr.length; a++){
		if(arr[a] == val){
			return true;
		}
	}
	return false;
}

function allByType(type){
	var inputs = document.getElementsByTagName('input');

	var outputs = [];
	var c = 0;
	for(i = 0; i < inputs.length; i++) {
		if(inputs[i].id.includes(type)){
			outputs[c] = inputs[i];
			c++;
		}
	}
	
	return outputs;
}

function popTexs(texs, data){
	for(i = 0; i < texs.length; i++){
		texs[i].value = data[i];
	}
}

function serTexs(texs){
	var r = "";
	for(i = 0; i < texs.length; i++){
		r += texs[i].value + "";
	}
	return rlc(r);
}

function rlc(str){ //remove last char
	return str.substring(0, str.length - 1);
}