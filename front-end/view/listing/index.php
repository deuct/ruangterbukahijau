<?php
include_once('./environment.php');
include_once('./back-end/sys/sessionlogin.php');
include_once('./back-end/sys/sessiondestroy.php');

// if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
//   $url = "https://";
// else
//   $url = "http://";
// // Append the host(domain name, ip) to the URL.   
// $url .= $_SERVER['HTTP_HOST'];

// // Append the requested resource location to the URL   
// $url .= $_SERVER['REQUEST_URI'];
$qSearch = isset($_GET['q']) ? $_GET['q'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Listing | Ruang Terbuka Hijau</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- <script type="text/javascript">
    window.history.forward();
  </script> -->
</head>

<body>
  <div class="row justify-content-center">
    <div class="header-page">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <a class="btn btn-back" href="<?= $baseURL ?>/list?logout=true">&#8826; Logout</a>
        <div class="title-header">
          <h2>
            Welcome back, <br />
            <?= $fullname ?>
          </h2>
        </div>
        <div class="title-header-desc">
          You can search the information of Ruang Terbuka Hijau here.
        </div>
      </div>
    </div>
    <div class="body-page">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-sm-12">
          <span class="listing-title">List of Ruang Terbuka Hijau :</span>
          <div class="form-flex mt-2 mb-4">
            <input type="text" class="form-control" id="listing-search" placeholder="Search something..." />
            <button type="button" class="btn btn-search btn-sm" onclick="searchRTH()">
              <img src="<?= $baseURL ?>/assets/search-icon.png" onclick="searchRTH()" width="25px" />
            </button>
          </div>
          <div id="desc-search"></div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div id="body-list" class="col-lg-10 col-md-10 col-sm-12">
        </div>
      </div>
    </div>
  </div>

  <?php include_once './front-end/view/component/footer.php' ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    var baseURL = `<?= $baseURL ?>`;
    var imgDirShort = `<?= $imgDirShort ?>`;
    var qSearch = `<?= $qSearch ?>`;

    function searchRTH() {
      let searchValue = document.getElementById("listing-search").value;
      window.location.href = "http://localhost:8080/ruangterbukahijau/list?q=" + searchValue;
    }

    $(document).ready(function() {
      if (qSearch !== "") {
        $.ajax({
          url: baseURL + "/api/listing",
          type: "POST",
          data: {
            data: {
              searchValue: qSearch
            },
            action: "getSearchTaman",
          },
          success: function(response) {
            var resJSON = $.parseJSON(response);
            // console.log(resJSON);

            if (resJSON.status === "failed") {
              console.log(resJSON.msg);
            } else if (resJSON.status === "success") {
              // console.log(resJSON.data);
              assignValue(resJSON.data);
            }
          },
          error: function() {
            console.log("failed");
          }
        });
      } else {
        $.ajax({
          url: baseURL + "/api/listing",
          type: "POST",
          data: {
            action: "getAllTaman",
          },
          success: function(response) {
            var resJSON = $.parseJSON(response);
            // console.log(resJSON);

            if (resJSON.status === "failed") {
              console.log(resJSON.msg);
            } else if (resJSON.status === "success") {
              // console.log(resJSON.data);
              assignValue(resJSON.data);
            }
          },
          error: function() {
            console.log("failed");
          }
        });
      }
    })

    function assignValue(data) {
      let descSearch = document.getElementById("desc-search");
      descSearch.style = "margin-bottom: 15px;";
      if (qSearch !== "") {
        descSearch.innerHTML = `Showing search for : <button class="btn btn-outline-primary btn-sm">` + qSearch + `</button>`;
      }
      let thumbnail;
      let nameTaman;

      for (let i = 0; i < data.length; i++) {
        thumbnail = data[i].lst_gambar !== "" ? JSON.parse(data[i].lst_gambar) : "";
        nameTaman = data[i].nama;
        statusTaman = data[i].status;
        descTaman = data[i].deskripsi;
        kodeTaman = data[i].kode_rth;

        if (thumbnail !== "") {
          thumbnail = thumbnail[0];
        }

        let cardListing = document.createElement('div');
        cardListing.id = "card-listing";
        // cardListing.className = "card-listing";
        cardListing.innerHTML = `
          <a class="card-listing" style="text-decoration: none !important; color: #000" href="` + baseURL + `/detail?id=` + kodeTaman + `">
            <div class="card-image">
              <img src="` + baseURL + imgDirShort + `/` + thumbnail + ` "/>
            </div>
            <div class="card-fill">
              <div class="card-title">
                <h4>` + nameTaman + `</h4>
              </div>
              <div class="card-status">` + statusTaman + `</div>
              <div class="card-desc">
                ` + descTaman + `
              </div>
            </div>
          </a>`;

        let bodyList = document.getElementById('body-list');
        bodyList.appendChild(cardListing);
      }
    }
  </script>
</body>

</html>