
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <style type="text/css">
        body {
            background-color: #e9f1f9;
        }
        .output {
            background-color:white;
            height:200px;
            overflow-y: scroll;
            display: none;
}
        }

    </style>
<style type="text/css">
    /***********************
  GRADIENT BUTTONS
************************/
.btn-primary.gradient {
	background: -moz-linear-gradient(top,  #33a6cc 50%, #0099cc 50%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,#33a6cc), color-stop(50%,#0099cc)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #33a6cc 50%,#0099cc 50%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #33a6cc 50%,#0099cc 50%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #33a6cc 50%,#0099cc 50%); /* IE10+ */
	background: linear-gradient(to bottom,  #33a6cc 50%,#0099cc 50%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#33a6cc', endColorstr='#0099cc',GradientType=0 ); /* IE6-9 */
}
.btn-primary.gradient:hover, .btn-primary.gradient:focus, .btn-primary.gradient:active, .btn-primary.gradient.active, .open > .dropdown-toggle.btn-primary {
	background: -moz-linear-gradient(top,  #66b2cc 50%, #33a6cc 50%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,#66b2cc), color-stop(50%,#33a6cc)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #66b2cc 50%,#33a6cc 50%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #66b2cc 50%,#33a6cc 50%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #66b2cc 50%,#33a6cc 50%); /* IE10+ */
	background: linear-gradient(to bottom,  #66b2cc 50%,#33a6cc 50%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#66b2cc', endColorstr='#33a6cc',GradientType=0 ); /* IE6-9 */
}
.btn-primary.gradient:active, .btn-primary.gradient.active {
	background: -moz-linear-gradient(top,  #267c99 50%, #007299 50%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(50%,#267c99), color-stop(50%,#007299)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #267c99 50%,#007299 50%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #267c99 50%,#007299 50%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #267c99 50%,#007299 50%); /* IE10+ */
	background: linear-gradient(to bottom,  #267c99 50%,#007299 50%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#267c99', endColorstr='#007299',GradientType=0 ); /* IE6-9 */
}

    </style>
  <title>Control Manager</title>
</head>
<body>
     <div class="row" >
          <h1 class="m-auto pt-5"> Cập nhật</h1>
    </div>
   
  <div class="container m-auto">
         
    <div class="row">
     
        <div class=" ml-auto mr-auto pt-1">
        <div class="btn-group btn-group-justified">
            <a href="crawler.php?key=1" class="btn btn-primary gradient m-5 p-5 round-3">Nhà nghỉ</a>
            <a href="crawler.php?key=2" class="btn btn-primary gradient m-5 p-5">Khách Sạn</a>
            <a href="crawler.php?key=3" class="btn btn-primary gradient m-5 p-5">Phòng cho thuê</a>
        </div>
      
        </div>
         <div class=" ml-auto mr-auto pt-1">
        <div class="btn-group btn-group-justified">
            <a href="crawler.php?key=4" class="btn btn-primary  gradient m-5 p-5 round-3">Nhà Ở</a>
            <a href="crawler.php?key=5" class="btn btn-primary gradient m-5 p-5">Biệt thự cho thuê</a>
            <a href="crawler.php?key=0" class="btn btn-primary gradient m-5 p-5">Cập nhật tất cả</a>
        </div>
      
        </div>
    </div>
</div>

  <div class="row" >
      <div class="container m-auto p-4">
            <div class="row" >
                <h1 class="m-auto pt-5 d-none" style="color:#1c8fe0" id="status"> isLoading...</h1>
            </div>
   
            <div class="progress d-none" style="height:10px" >
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-   valuemin="0" aria-valuemax="100" style="width:100%; background-color: rgba(10, 138, 187, 0.83)" >
                </div>
            </div>
        <div class="output" id="output">

             <a href="#" id="view_ouput" class="ml-auto"><h1 class="ml-auto" style="color:red">View logs online </h1></a>
             <a href="Database.xlsx" id="view_ouput" class="ml-auto"><h1 class="ml-auto" style="color:red">Database Here</h1></a>
             <a href="Log.xlsx" id="view_ouput" class="ml-auto"><h1 class="ml-auto" style="color:red">Logs Here</h1></a>

      </div>
      </div>
    </div>
 <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
 <script type="text/javascript" src="assets/js/xlsx.full.min.js"></script>
 <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
 <script type="text/javascript" src="assets/js/jquery.session.js"></script>
<script>
    var isLoading=false;
    $(".btn-primary").click(function(event){
            event.preventDefault();
            event.stopPropagation();
            if(isLoading) {
                alert ("please wait a moment");
                return false;
            };
            isLoading=true;
            $("#status").text("Loading...");
            $(".progress").removeClass("d-none");
            $("#status").removeClass("d-none");
           
            $("#output").css("display","block");
           
            $('html, body').animate({
                scrollTop: $("#output").offset().top
            }, 1200);
            $("#output").scrollTop($("#output")[0].scrollHeight);
            var murl=this.href;
           $.get(murl, function(data, status){
               alert (data);
               if(data.trim().localeCompare("success")==0)
                   $("#status").text("Load Complete!");
               else
                   $("#status").text("Load Fail!");
                isLoading=false;
                $(".progress").addClass("d-none");
           });
    });

    $("#view_ouput").click(function(){
        window.open('database.php', '_blank');
    });
</script>
</body>
</html>