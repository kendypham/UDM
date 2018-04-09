$('#formLogin').on('submit',function(){
	var username= $("[name='username']").val(),
		password= $("[name='password']").val();
	var request = {
		username : username,
		password : password
	};
	
	$.ajax({
			url: "func_login.php",
			type: "POST",
			data :request,
			success: function(response) {
				//Login success
				console.log(response.trim());
				//=0-> true
				if(response.trim().localeCompare("success")==0){
					location.href="manage.php";
					//console.log("sufwfewrgeccess");
					$("#failAlert").addClass("invisible");
				}
				else{
					$("#failAlert").removeClass("invisible");
				}
			}
		});
	
  return false;
})
$("#btnLogin").click(function(event) {

	//Fetch form to apply custom Bootstrap validation
	var form = $("#formLogin")

	if (form[0].checkValidity() === false) {
	  event.preventDefault()
	  event.stopPropagation()
	}
	
	form.addClass('was-validated');
});


