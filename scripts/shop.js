function selcity() {
	$('#point').empty();
	$.ajax({
	    type: "POST",
	    url: "server/city.php",
	    data: "base="+$('#base').val(),
	    success: function(data){
	        var str = JSON.parse(data);
	        $('#point').append("<option>Все</option>");
	        for (i = 0; i < str.length; i++)
	            $('#point').append("<option>"+str[i].name+"</option>");
	    }
	});
}

$.ajax({
    type: "POST",
    url: "server/city.php",
    data: "base="+$('#base').val(),
    success: function(data){
        var str = JSON.parse(data);
        for (i = 0; i < str.length; i++)
            $('#point').append("<option>"+str[i].name+"</option>");
    }
});

function selshop() {
	$.ajax({
	    type: "POST",
	    url: "server/shop.php",
	    data: "base="+$('#base').val()+"&city="+$('#point').val()+
	    	"&dat1="+$('#date1').val()+"&dat2="+$('#date2').val()+"&sort="+$('#sort').val(),
	    success: function(data){
	        str = data.split("/");
	        $('#report').empty();
	        for (i = 0; i < str.length - 2; i++)
	        	if ((!(str[i].split(",")[0] === undefined)) 
	        		|| (!(str[i].split(",")[0] === null))
	        		|| (!(str[i].split(",")[0] === " "))) {
	        		if (i % 2 == 0) {
			            $('#report').append(
			            	"<tr>"+
			            	"<td>"+str[i].split(",")[0]+"</td>"+
			            	"<td>"+str[i].split(",")[1]+"</td>"+
			            	"<td>"+str[i].split(",")[2]+"</td>"+
			            	"<td>"+str[i].split(",")[3]+"</td>"+
			            	"</tr>"
			            	);
		        	} else {
		        		$('#report').append(
			            	"<tr>"+
			            	"<td class='active'>"+str[i].split(",")[0]+"</td>"+
			            	"<td class='active'>"+str[i].split(",")[1]+"</td>"+
			            	"<td class='active'>"+str[i].split(",")[2]+"</td>"+
			            	"<td class='active'>"+str[i].split(",")[3]+"</td>"+
			            	"</tr>"
			            	);
		        	}
	           	}
	    }
	});
}