<?php include_once('./environment.php') ?>

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
      <img src="<?= $baseURL ?>/assets/register.jpeg" id="image-login" />
    </div>
  </div>
  <div class="row mb-4 justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-10 title">
      <h2>Register to</h2>
      <h2>Ruang Terbuka Hijau Apps</h2>
      <span class="title-desc">Fill up the data</span>
    </div>
  </div>
  <div class="row mt-2 justify-content-center">
    <div class="col-lg-8 col-md-8 col-sm-12">
      <div class="container">
        <form method="POST" id="form-register">
          <div class="mb-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" />
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" />
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" />
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" />
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan" />
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Kelurahan" />
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="rt" id="rt" placeholder="RT" />
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="rw" id="rw" placeholder="RW" />
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" />
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Re-Password" />
          </div>

          <input type="submit" class="btn btn-login" value="Register">
        </form>
      </div>
      <span class="login-link">Already have an account ?
        <a href="<?= $baseURL ?>/login">Sign In</a></span>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      var request;
      var baseURL = `<?php echo $baseURL ?>`;

      $("#form-register").submit(function(e) {
        e.preventDefault();

        if (request) {
          request.abort();
        }

        var $form = $(this);
        var $inputs = $form.find("input, select, button, textarea");
        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        request = $.ajax({
          url: baseURL + "/api/register",
          type: "POST",
          data: serializedData
        });

        request.done(function(response, textStatus, jqXHR) {
          console.log("running well ajax");
          console.log(response);

          var resJSON = $.parseJSON(response);

          console.log(resJSON);

          if (resJSON.status === "failed") {
            alert(resJSON.msg);
          } else if (resJSON.status === "success") {
            alert(resJSON.msg);

            var urlLogin = baseURL + "/login";
            window.location.replace(urlLogin);
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