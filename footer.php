  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        
        $(".toggleForm").click(function(){

            $("#signUpForm").toggle();
            $("#logInForm").toggle();

        });

        $('#diary').bind('input propertychange', function() {

      		$.ajax({
			  method: "POST",
			  url: "updateDB.php",
			  data: { content: $('#diary').val() }
			})
			  .done(function( msg ) {
			    console.log( "Data Saved: " + msg );
			  });
      
		});

    </script>

</body>
</html>