$(document).ready(function(){

$("#signup").click(function(){
	$("#log").slideUp("slow", function(){
		$("#reg").slideDown("slow");
	});
});

$("#signin").click(function(){
	$("#reg").slideUp("slow", function(){
		$("#log").slideDown("slow");
	});
});


});