

// BIND SELECT OPTIONS 
function bindSelect2(elementID, data, selectionValue = null){ 
	// var sel = document.getElementsByClassName(elementClass);
	// console.log(elementClass);
	var sel = document.getElementById(elementID);
    
    // REMOVE ALL & BIND DEFAULT OPTION
    sel.innerText = "";
    var opt = document.createElement('option');
    opt.innerHTML = 'Please Select';
    opt.value = "";
    // opt.setAttribute('data-display', 'Please Select');
    sel.appendChild(opt);

        //console.log(data.length);
    // ITERATE TO BIND OPTIONS
    for(var i = 0; i < data.length; i++) {
        var opt = document.createElement('option');
        opt.innerHTML = data[i].name;
        opt.value = data[i].id;
        sel.appendChild(opt);
        for(var j = 0; j < data[i].get_attribute_values.length; j++){
        console.log(data[i].get_attribute_values[j].value);
        // SELECT, IF SELECTION VALUE AVAILABLE
        // if(selectionValue == data[i].id){
        //     sel.selectedIndex = i+1;
        // }
        }
    }
     // console.log(data[0].name);
}


function bindSelect3(elementID, data, selectionValue = null){ 
    console.log(data);
    temp = $('#mytemp').html();

    console.log($('#mytemp').html());

    // $('#mydynamic').append();

    // alert(elementID);
    // var ele=$('#'+elementID);
    // var template=$('#mytemp').html();
    // alert(template);
    // alert(ele.html());
    // for( var i=0; i< data.length; i++){
    //     ele.append(template);
    // }
}

function bindSelect(elementID, data, selectionValue = null){
    // GET THE ELEMENT
    var sel = document.getElementById(elementID);
    
    // REMOVE ALL & BIND DEFAULT OPTION
    sel.innerText = "";
    var opt = document.createElement('option');
    opt.innerHTML = 'Please Select';
    opt.value = "";
    // opt.setAttribute('data-display', 'Please Select');
    sel.appendChild(opt);

    // ITERATE TO BIND OPTIONS
    for(var i = 0; i < data.length; i++) {
        var opt = document.createElement('option');
        opt.innerHTML = data[i].name;
        opt.value = data[i].id;
        // console.log(opt);
        sel.appendChild(opt);

        // SELECT, IF SELECTION VALUE AVAILABLE
        if(selectionValue == data[i].id){
            sel.selectedIndex = i+1;
        }
    }
     console.log(sel);
}


// 	MULTIPLE DROPDOWN SELECTION...


// function getData(url){
// 		var response = fetch(url);
// 		// var data = await response.json();
// 		var data = (url);
// 		console.log(response);
// 	}

$('.child_category').on('change', function(){
	var url = '/api/get-attribute/'+(this.value);
	  $.get(url, function(data, status){

        data2=data.data;
	  	bindSelect3('mydynamic', data2);
	  	// bindSelect('attr1', data);
	    // console.log(data.length);
	  	//console.log(data2);
	  });
});


    












