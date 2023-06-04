<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
</head>
<style>
.content {
  max-width: 600px;
  margin: auto;
}

</style>

<body>
                    
<div class="content">

<h2>Delete Form</h2>
 <span id="success" ></span>

<form  id="delete_form" method="post" action="<?php echo base_url();?>delete_row_data">
  
  <label for="lname">Mobile number:</label><br>
  <input type="text" id="mobile" name="mobile" required ><br><br>
  <input type="submit" value="Delete">

  
</form> 

   <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

</div>
</body>
</html>
<script>
  var base_url = $("#base_url").val(); 
   $(document).ready(function(){	   
	  $("#delete_form").submit(function(e)		
		{						
			var form_app_key  = $("#form_app_key").val();				
			var mobile  = $("#mobile").val();				
					 
		   $.ajax({  
				url :base_url+"delete_row_data",  
				type:"POST",    
				data: new FormData(this),
				processData: false,
				contentType: false,
				dataType:"JSON",
				success:function(data){ 											
				if(data.status=='success')
				{					
					$("#success").html(data.msg).fadeIn('slow').delay(3000).fadeOut('slow');
					location.reload();	
				/* $( '#delete_form' ).each(function(){
					this.reset();
					}); */
					}else if (data.status=='error')
					{				   
				$("#success").html(data.msg).fadeIn('slow').delay(3000).fadeOut('slow');					
					}	
			   }  
			 });  
			e.preventDefault();    		   
	   }); 
   }); 
		   </script>
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   