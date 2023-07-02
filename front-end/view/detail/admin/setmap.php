<?php
include_once('./environment.php');
$id = $_GET['id'];
$isEdit = isset($_GET['edit']) ? $_GET['edit'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Detail | Ruang Terbuka Hijau</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <link rel="stylesheet" href="<?= $baseURL ?>/front-end/script/leaflet/src/L.Control.MapCenterCoord.css" />
  <script src="<?= $baseURL ?>/front-end/script/leaflet/src/L.Control.MapCenterCoord.js"></script>
  <!-- End Leaflet -->
</head>

<body>
  <div class="row justify-content-center">
    <div class="header-page">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <!-- <button class="btn btn-back" onclick="">&#8826; Back</button> -->
        <div class="title-header">
          <h2>Edit Page for</h2>
        </div>
        <div class="title-header-desc">Taman Barito</div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-12">
      <div class="setmap">
        <div id="map"></div>

        <script type="text/javascript">
          const map = L.map("map");
          map.setView([-6.33392, 106.71856], 19);

          L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
          }).addTo(map);

          // L.control
          //   .mapCenterCoord({
          //     latlngFormat: "DMS",
          //   })
          //   .addTo(map);
          L.control
            .mapCenterCoord()
            .addTo(map);
        </script>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <div class="btn-setmap">
      <button type="button" class="btn btn-green" onclick="getCoord()">Submit</button>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    var arrCoor;
    var kodeTaman = `<?= $id ?>`;
    var baseURL = `<?= $baseURL ?>`;
    var isEdit = `<?= $isEdit ?>`;

    if (isEdit === "true") {
      var detailTaman = getDetail();
    }

    function getDetail() {
      $.ajax({
        url: baseURL + "/api/detail",
        type: "POST",
        data: {
          data: {
            kodeTaman: kodeTaman
          },
          action: "getDetailTaman",
        },
        success: function(response) {
          var resJSON = $.parseJSON(response);
          // console.log(resJSON);

          if (resJSON.status === "failed") {
            console.log(resJSON.msg);
          } else if (resJSON.status === "success") {
            let data = resJSON.data[0];
            var kordinat1 = data.kordinat_1;
            var kordinat2 = data.kordinat_2;

            map.setView([kordinat1, kordinat2], 19);
          }
        },
        error: function() {
          console.log("failed");
        }
      });

      // return [kordinat1, kordinat2];
    }

    function getCoord() {
      let coord = document.getElementsByClassName('leaflet-control-mapcentercoord');
      coord = coord[0].innerHTML;
      coord = coord.split(" | ");

      for (let i = 0; i < coord.length; i++) {
        console.log(coord[i]);
        coord[i] = coord[i].replace('º', '');
      }

      sendMap(coord);
    }

    function sendMap(coord) {
      $.ajax({
        url: baseURL + "/api/detail",
        type: "POST",
        data: {
          data: {
            coord: coord,
            kodeTaman: kodeTaman
          },
          action: "addCoord",
        },
        success: function(msg) {
          window.location.href = baseURL + "/detail/edit?id=" + kodeTaman + "&setmap=1";
        },
        error: function() {
          console.log("failed");
        }
      });
    }
  </script>
</body>

</html>