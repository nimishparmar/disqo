<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>DISQO Coding Challenge</title>
</head>

<body>
  <h1 class="text-center">DISQO E-Commerce Platform</h1>

  <div class="container w-25">
  <div id="error_message"></div>
    <form>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password">
      </div>
      <button type="submit" id="ajaxSubmit" class="btn btn-primary">Submit</button>
    </form>
  </div>


  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
  </script>

  <script>
    jQuery(document).ready(function() {
      jQuery('#ajaxSubmit').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });
        jQuery.ajax({
          // The POST URL would be stored in a config file in production systems instead of being hardcoded here
          url: "http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com:8000/api/v1/login",
          method: 'post',
          data: {
            email: jQuery('#email').val(),
            password: jQuery('#password').val()
          },
          success: function(result) {
            // Upon successful authentication,
            // Set the JWT token in a cookie and
            // redirect to search page
            if (result.token) {
              document.cookie = "jwt=" + result.token
              // The redirect URL would be stored in a config file in production systems instead of being hardcoded here
              window.location.replace("http://ec2-52-41-118-144.us-west-2.compute.amazonaws.com/search");
            }
          },
          error: function(err) {
            // Display error message upon failed authentication
            jQuery('#error_message').addClass('alert alert-danger')
            jQuery('#error_message').text('Invalid credentials. Please try again.')
          }
        });
      });
    });
  </script>
</body>

</html>