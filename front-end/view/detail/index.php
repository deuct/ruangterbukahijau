<?php include_once('./environment.php') ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail | Ruang Terbuka Hijau</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link
      href="<?= $baseURL ?>/front-end/style/globalstyle.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />

    <!-- Leaflet -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""
    />
    <script
      src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""
    ></script>
    <!-- End Leaflet -->
  </head>

  <body>
    <div class="row justify-content-center">
      <!-- <?php
        include_once './front-end/view/component/header-detail.php';
        getHeader('Detail Information of', 'Taman Barito');
        ?> -->

      <div class="header-page">
        <div class="col-lg-10 col-md-10 col-sm-12">
          <button class="btn btn-back">&#8826; Back</button>
          <div class="title-header">
            <h2>Detail Information of</h2>
          </div>
          <div class="title-header-desc">Taman Barito</div>
        </div>
      </div>
    </div>

    <div class="body-page body-page-detail">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-sm-12">
          <div class="gallery">
            <h2 class="title-detail">Gallery</h2>
            <div class="wrapper">
              <ul class="items">
                <li class="item">
                  <img
                    src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg"
                    class="myImg"
                    id="pict01"
                    onClick="showImage(this.id)"
                  />
                </li>
                <li class="item">
                  <img
                    src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg"
                    class="myImg"
                    id="pict02"
                    onClick="showImage(this.id)"
                  />
                </li>
                <li class="item">
                  <img
                    src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg"
                    class="myImg"
                    id="pict03"
                    onClick="showImage(this.id)"
                  />
                </li>
                <li class="item">
                  <img
                    src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg"
                    class="myImg"
                    id="pict04"
                    onClick="showImage(this.id)"
                  />
                </li>
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
                <td>Lorem ipsum dolor sit.</td>
              </tr>
              <tr>
                <td>Jenis RTH</td>
                <td>:</td>
                <td>Lorem ipsum dolor sit amet consectetur.</td>
              </tr>
              <tr>
                <td>Kategori Taman</td>
                <td>:</td>
                <td>Lorem, ipsum dolor.</td>
              </tr>
              <tr>
                <td>Kapasitas</td>
                <td>:</td>
                <td>10</td>
              </tr>
              <tr>
                <td>Luas Area</td>
                <td>:</td>
                <td>120m</td>
              </tr>
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
              const map = L.map("map");
              map.setView([-6.33392, 106.71856], 19);

              L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution:
                  '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
              }).addTo(map);

              L.marker([-6.33392, 106.71856], {
                title: "Taman Barito",
              }).addTo(map);
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>

    <script type="text/javascript">
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
      span.onclick = function () {
        modal.style.display = "none";
      };
    </script>
  </body>
</html>
