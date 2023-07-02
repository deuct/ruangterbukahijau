<?php
include_once('./environment.php');

function checkLogin($baseURL)
{
  session_start();

  if (isset($_SESSION['loggedin'])) {
    header('Location: ' . $baseURL . '/listing');
  }
}

checkLogin($baseURL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Ruang Terbuka Hijau</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link href="<?= $baseURL ?>/front-end/style/login/style.css" rel="stylesheet" />
  <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
</head>

<body>
  <div class="row justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-12">
      <img src="<?= $baseURL ?>/assets/login-image.jpeg" id="image-login" />
    </div>
  </div>
  <div class="row mb-4 justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-10 title">
      <h2>Welcome to</h2>
      <h2>Ruang Terbuka Hijau Apps</h2>
      <span class="title-desc">Please login before continue</span>
    </div>
  </div>
  <div class="row mt-2 justify-content-center">
    <div class="col-lg-8 col-md-8 col-sm-12">
      <form method="POST" id="form-login">
        <div class="mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
          <input type="submit" class="btn btn-login" value="Login">
        </div>
      </form>
      <span class="login-link">Doesn't have an account ? <a href="<?= $baseURL ?>/register">Sign Up</a></span>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      var request;
      var baseURL = `<?php echo $baseURL ?>`;

      $("#form-login").submit(function(e) {
        e.preventDefault();

        if (request) {
          request.abort();
        }

        var $form = $(this);
        var $inputs = $form.find("input, select, button, textarea");
        // var serializedData = $form.serialize();

        // console.log($form);

        // console.log($form.find('input[name="username"]'));
        // console.log($form.find('input[name="username"]').val());

        var username = $form.find('input[name="username"]').val();
        var password = $form.find('input[name="password"]').val()

        $inputs.prop("disabled", true);

        request = $.ajax({
          url: baseURL + "/api/authenticate",
          type: "POST",
          data: {
            data: {
              username: username,
              password: password
            },
            action: 'loginAuth'
          }
        });

        request.done(function(response, textStatus, jqXHR) {
          var resJSON = $.parseJSON(response);

          console.log(resJSON);

          if (resJSON.status === "failed") {
            alert(resJSON.msg);
          } else if (resJSON.status === "success") {
            alert(resJSON.msg);

            var urlListing = baseURL + "/list";
            window.location.replace(urlListing);
          }
        });

        request.fail(function(jqXHR, textStatus, errorThrown) {
          console.error("error happens : " + textStatus, errorThrown);
        });

        request.always(function() {
          $inputs.prop("disabled", false);
        });
      });
    })
  </script>
</body>

</html>