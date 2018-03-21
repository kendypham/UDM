$('form.login_admin').on('submit',function(){
 

   var  username= $("[name='username']").val(),
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
				if(!response.trim().localeCompare("success"))
					console.log("OK");
			}
		});
	
  return false;
})