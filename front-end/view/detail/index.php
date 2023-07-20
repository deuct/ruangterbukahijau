<?php
include_once('./environment.php');
include_once('./back-end/sys/sessionlogin.php');

$kodeTaman = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Detail | Ruang Terbuka Hijau</title>
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
    <!-- <?php
          include_once './front-end/view/component/header-detail.php';
          getHeader('Detail Information of', $namaTaman);
          ?> -->

    <div class="header-page">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <button class="btn btn-back">&#8826; Back</button>
        <div class="title-header">
          <h2>Detail Information of</h2>
        </div>
        <div class="title-header-desc" id="title-taman-edited"></div>
      </div>
    </div>
  </div>

  <div class="body-page body-page-detail">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <div class="gallery">
          <h2 class="title-detail">Gallery</h2>
          <div class="wrapper">
            <ul class="items" id="items">
              <!-- <li class="item">
                <img src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg" class="myImg" id="pict01" onClick="showImage(this.id)" />
              </li>
              <li class="item">
                <img src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg" class="myImg" id="pict02" onClick="showImage(this.id)" />
              </li>
              <li class="item">
                <img src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg" class="myImg" id="pict03" onClick="showImage(this.id)" />
              </li>
              <li class="item">
                <img src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg" class="myImg" id="pict04" onClick="showImage(this.id)" />
              </li> -->
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <h2 class="title-detail mt-3">Description</h2>
        <div class="box-detail">
          <table class="table box-detail-table">
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td>
                <input type="text" id="nama-rth" name="nama-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Status</td>
              <td>:</td>
              <td>
                <input type="text" id="status-rth" name="status-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Kategori</td>
              <td>:</td>
              <td>
                <input type="text" id="kategori-rth" name="kategori-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Kapasitas</td>
              <td>:</td>
              <td>
                <input type="text" id="kapasitas-rth" name="kapasitas-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Deskripsi</td>
              <td>:</td>
              <td>
                <input type="text" id="deskripsi-rth" name="deskripsi-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Luas Area</td>
              <td>:</td>
              <td>
                <input type="text" id="luasarea-rth" name="luasarea-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Propinsi</td>
              <td>:</td>
              <td>
                <input type="text" id="propinsi-rth" name="propinsi-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Kota</td>
              <td>:</td>
              <td>
                <input type="text" id="kota-rth" name="kota-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Kecamatan</td>
              <td>:</td>
              <td>
                <input type="text" id="kecamatan-rth" name="kecamatan-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>Kelurahan</td>
              <td>:</td>
              <td>
                <input type="text" id="kelurahan-rth" name="kelurahan-rth" class="form-control" readonly />
              </td>
            </tr>
            <!--- di comment rtrw sementara
            <tr>
              <td>RT</td>
              <td>:</td>
              <td>
                <input type="text" id="rt-rth" name="rt-rth" class="form-control" readonly />
              </td>
            </tr>
            <tr>
              <td>RW</td>
              <td>:</td>
              <td>
                <input type="text" id="rw-rth" name="rw-rth" class="form-control" readonly />
              </td>
            </tr>
            --->
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <h2 class="title-detail">Location</h2>

        <div class="detail-location">
          <div id="map"></div>
          <script type="text/javascript">
            // const map = L.map("map", {
            //   center: [0, 0],
            //   dragging: false,
            //   scrollWheelZoom: "center",
            // });
            const map = L.map("map");
            map.setView([-6.33392, 106.71856], 19);

            L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
              maxZoom: 19,
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(map);

            // L.control
            //   .mapCenterCoord()
            //   .addTo(map);

            // L.marker([-6.33392, 106.71856], {
            //   title: "Taman Barito",
            // }).addTo(map);
          </script>
        </div>
      </div>
    </div>
  </div>

  <!-- The Modal -->
  <div id="myModal" class="modal">
    <!-- The Close Button -->
    <span class="close">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01" />

    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
  </div>

  <?php include_once './front-end/view/component/footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    var baseURL = `<?= $baseURL ?>`;
    var imgDirShort = `<?= $imgDirShort ?>`;
    var kodeTaman = `<?= $kodeTaman ?>`;

    $(document).ready(function() {
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
            // console.log(resJSON.data);
            assignValue(resJSON.data[0]);
          }
        },
        error: function() {
          console.log("failed");
        }
      });
    })

    function assignValue(data) {
      arrImage = JSON.parse(data.lst_gambar);

      console.log(data);

      var namaRth = document.getElementById('nama-rth');
      var statusRth = document.getElementById('status-rth');
      var kategoriRth = document.getElementById('kategori-rth');
      var kapasitasRth = document.getElementById('kapasitas-rth');
      var deskripsiRth = document.getElementById('deskripsi-rth');
      var luasareaRth = document.getElementById('luasarea-rth');
      var propinsiRth = document.getElementById('propinsi-rth');
      var kotaRth = document.getElementById('kota-rth');
      var kecamatanRth = document.getElementById('kecamatan-rth');
      var kelurahanRth = document.getElementById('kelurahan-rth');
      var rtRth = document.getElementById('rt-rth');
      var rwRth = document.getElementById('rw-rth');

      document.getElementById('title-taman-edited').innerHTML = data.nama;

      // var htmlTest = `<div>
      //   <img src="https://www.bhaktiphotos.com/wp-content/uploads/2018/04/Mahadev-Bhagwan-Photo-for-Devotee.jpg" width="120px" height="120px" />
      //   <h2>Test</h2>  
      // </div>`;

      map.setView([data.kordinat_1, data.kordinat_2], 19);
      var marker = new L.Marker([data.kordinat_1, data.kordinat_2]);
      marker.addTo(map);

      namaRth.value = data.nama;
      statusRth.value = data.status;
      kategoriRth.value = data.nama_kategori;
      kapasitasRth.value = data.kapasitas;
      deskripsiRth.value = data.deskripsi;
      luasareaRth.value = data.luas_area;
      propinsiRth.value = data.propinsi;
      kotaRth.value = data.kota;
      kecamatanRth.value = data.kecamatan;
      kelurahanRth.value = data.kelurahan;
      rtRth.value = data.rt;
      rwRth.value = data.rw;

      for (let i = 0; i < arrImage.length; i++) {
        let itemImage = document.createElement("li");
        itemImage.className = "item";

        itemImage.innerHTML = `
            <img src="` + baseURL + imgDirShort + `/` + arrImage[i] + `" class="myImg" id="pict` + (i + 1) + `" onClick="showImage(this.id)" />
          `;

        let items = document.getElementById("items");
        items.appendChild(itemImage);
      }
    }

    let isDown = false;
    let startX;
    let scrollLeft;
    const slider = document.querySelector(".items");

    const end = () => {
      isDown = false;
      slider.classList.remove("active");
    };

    const start = (e) => {
      isDown = true;
      slider.classList.add("active");
      startX = e.pageX || e.touches[0].pageX - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
    };

    const move = (e) => {
      if (!isDown) return;

      e.preventDefault();
      const x = e.pageX || e.touches[0].pageX - slider.offsetLeft;
      const dist = x - startX;
      slider.scrollLeft = scrollLeft - dist;
    };

    (() => {
      slider.addEventListener("mousedown", start);
      slider.addEventListener("touchstart", start);

      slider.addEventListener("mousemove", move);
      slider.addEventListener("touchmove", move);

      slider.addEventListener("mouseleave", end);
      slider.addEventListener("mouseup", end);
      slider.addEventListener("touchend", end);
    })();

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    // var img = document.querySelectorAll(".myImg");

    // console.log(img);

    // img.onclick = function () {
    function showImage(idimage) {
      var modalImg = document.getElementById(idimage);
      var modalImgShow = document.getElementById("img01");
      var captionText = document.getElementById("caption");

      modal.style.display = "block";
      // modalImg.src = this.src;
      // captionText.innerHTML = this.alt;
      modalImgShow.src = modalImg.src;
      captionText.innerHTML = modalImg.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    };
  </script>
</body>

</html>