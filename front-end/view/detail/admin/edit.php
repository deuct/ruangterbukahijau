<?php
include_once('./environment.php');
include_once('./back-end/sys/sessionlogin.php');
include_once('./back-end/sys/sessiondestroy.php');

$idTaman = $_GET['id'];
$setmap = isset($_GET['setmap']) ? $_GET['setmap'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add New Detail | Ruang Terbuka Hijau</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <link rel="stylesheet" href="<?= $baseURL ?>/front-end/script/leaflet/src/L.Control.MapCenterCoord.css" />
  <script src="<?= $baseURL ?>/front-end/script/leaflet/src/L.Control.MapCenterCoord.js"></script>
  <!-- End Leaflet -->
  <script type="text/javascript">
    window.history.forward();
  </script>
</head>

<body>
  <div class="row justify-content-center">
    <div class="header-page">
      <div class="col-lg-10 col-md-10 col-sm-12">
        <button type="button" class="btn btn-back" onclick="back()">&#8826; Back</button>
        <div class="title-header">
          <h2>Edit Page for</h2>
        </div>
        <div id="taman-name" class="title-header-desc"></div>
      </div>
    </div>
  </div>

  <form method="POST" id="add-taman">
    <div class="body-page body-page-detail">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-sm-12">
          <h2 class="title-detail">Description</h2>
          <div class="box-detail">
            <input id="kode-taman" name="kode-taman" type="text" class="form-control" hidden style="visibility: none; display: hidden" value="" />
            <table class="table box-detail-table">
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                  <input id="nama-taman" name="nama-taman" type="text" class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Kategori</td>
                <td>:</td>
                <td>
                  <select id="kategori-taman" name="kategori-taman" class="form-select" aria-label="Select Kategori">
                  </select>
                </td>
              </tr>
              <tr>
                <td>Kapasitas</td>
                <td>:</td>
                <td>
                  <input id="kapasitas-taman" name="kapasitas-taman" type="text" class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Luas Area</td>
                <td>:</td>
                <td>
                  <input id="luasarea-taman" name="luasarea-taman" type="text" class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                  <select id="status-taman" name="status-taman" class="form-select" aria-label="Select Status">
                    <option value="0">Close</option>
                    <option value="1">Open</option>
                    <option value="2">Under Maintenance</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td>
                  <textarea id="deskripsi-taman" name="deskripsi-taman" class="form-control" style="height: 100px"></textarea>
                </td>
              </tr>
              <tr>
                <td>Propinsi</td>
                <td>:</td>
                <td>
                  <input id="propinsi" name="propinsi" type="text" class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Kota</td>
                <td>:</td>
                <td>
                  <input id="kota" name="kota" type="text" class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Kecamatan</td>
                <td>:</td>
                <td>
                  <input id="kecamatan" name="kecamatan" type="text" class="form-control" />
                </td>
              </tr>
              <tr>
                <td>Kelurahan</td>
                <td>:</td>
                <td>
                  <input id="kelurahan" name="kelurahan" type="text" class="form-control" id="kelurahan" name="kelurahan" />
                </td>
              </tr>
              <tr>
                <td>RT</td>
                <td>:</td>
                <td>
                  <input id="rt" name="rt" type="text" class="form-control" id="rt" name="rt" />
                </td>
              </tr>
              <tr>
                <td>RW</td>
                <td>:</td>
                <td>
                  <input id="rw" name="rw" type="text" class="form-control" id="rw" name="rw" />
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-sm-12">
          <h2 class="title-detail">Gallery Upload</h2>
          <div class="box-gallery" id="box-gallery">
          </div>

          <div class="d-flex justify-content-end">
            <input type="file" id="fileupload" name="fileupload" id="fileupload" class="form-control" />
            <button type="button" id="upload-img" name="upload-img" value="upload-img" class="btn btn-green">Upload </button>
          </div>
        </div>
      </div>

      <div class="row justify-content-center mb-3 mt-4">
        <div class="col-lg-10 col-md-10 col-sm-12">
          <h2 class="title-detail">Edit Map</h2>
          <div class="d-flex justify-content-end">
            <input type="submit" value="Set Location" class="btn btn-green" onclick="saveForm()" />
          </div>

          <div class="detail-location">
            <div class="map-edit">
              <div id="map"></div>
            </div>

            <script type="text/javascript">
              var map = L.map("map");
              map.setView([-6.33392, 106.71856], 19);

              L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
              }).addTo(map);

              L.control
                .mapCenterCoord()
                .addTo(map);
            </script>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-10 col-md-10 col-sm-12 text-center">
        <div class="btn-edit-submit">
          <input type="submit" class="btn btn-green" onclick="finishForm()" value=" Submit">
        </div>
      </div>
    </div>
  </form>

  <?php include_once './front-end/view/component/footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    var baseURL = `<?= $baseURL ?>`;
    var imgDirShort = `<?= $imgDirShort ?>`;
    var request;
    var kodeTaman = getURLParam();
    let arrImgUpload = new Array();
    var URLRedirect = "";

    function back() {
      let text = "Are you sure want to cancel the process ?";
      if (confirm(text) == true) {
        window.location.replace("<?= $baseURL ?>/list-admin");
      }
    }

    assignKodeTaman(kodeTaman);

    function assignKodeTaman(kodeTaman) {
      var hdn_kodeTaman = document.getElementById("kode-taman");
      hdn_kodeTaman.value = kodeTaman;
    }

    getDetailTaman();

    function getDetailTaman() {
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
            console.log(resJSON);
            assignValue(resJSON);

            // console.log(resJSON.data[0].nama);
          }
        },
        error: function() {
          console.log("failed");
        }
      });
    }

    function assignValue(resJSON) {
      let data = resJSON.data[0];
      let lstGambar = data.lst_gambar !== "" ? JSON.parse(data.lst_gambar) : "";
      document.getElementById("taman-name").innerHTML = data.nama;
      document.getElementById("nama-taman").value = data.nama;
      document.getElementById("kategori-taman").value = data.kode_kategori;
      document.getElementById("kapasitas-taman").value = data.kapasitas;
      document.getElementById("luasarea-taman").value = data.luas_area;
      document.getElementById("status-taman").value = data.status;
      document.getElementById("deskripsi-taman").value = data.deskripsi !== "" ? data.deskripsi : "";
      document.getElementById("propinsi").value = data.propinsi;
      document.getElementById("kecamatan").value = data.kecamatan;
      document.getElementById("kelurahan").value = data.kelurahan;
      document.getElementById("kota").value = data.kota;
      document.getElementById("rt").value = data.rt;
      document.getElementById("rw").value = data.rw;

      // console.log(JSON.parse(data.lst_gambar));
      if (lstGambar !== "") {
        for (let i = 0; i < lstGambar.length; i++) {
          let gmbShowName = lstGambar[i].slice(15, lstGambar[i].length);
          let gmbSrc = baseURL + "/" + imgDirShort + "/" + lstGambar[i];
          arrImgUpload.push(lstGambar[i]);
          generateNewImage(gmbSrc, gmbShowName, lstGambar[i]);
        }
      }
      map.setView([data.kordinat_1, data.kordinat_2], 19);
    }

    $(document).ready(function() {
      $("#upload-img").click(function() {
        const fileupload = $('#fileupload').prop('files')[0];

        if (fileupload !== "") {
          let formData = new FormData();
          formData.append('fileupload', fileupload);
          formData.append('nama_img', fileupload.name);
          formData.append('action', "addImage");
          formData.append('kode_taman', kodeTaman);

          $.ajax({
            url: baseURL + "/api/detail",
            type: "POST",
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            success: function(msg) {
              var resJSON = $.parseJSON(msg);
              console.log(resJSON);

              arrImgUpload.push(resJSON.data.real_name);
              generateNewImage(resJSON.data.src, resJSON.data.show_name, resJSON.data.real_name);
              // $("#fileupload").val(null);
              document.getElementById("fileupload").value = null;

              console.log(arrImgUpload);
            },
            error: function() {
              console.log("failed");
            }
          });
        }
      })
    })

    function deleteImage(imgRealName) {
      if (imgRealName !== "") {
        $.ajax({
          url: baseURL + "/api/detail",
          type: "POST",
          data: {
            data: {
              imgName: imgRealName
            },
            action: "deleteImage",
          },
          success: function(msg) {
            console.log("finish request");

            var boxImage = document.getElementById(imgRealName);
            boxImage.remove();

            arrImgUpload = arrImgUpload.filter(e => e !== imgRealName);

            console.log(arrImgUpload);
          },
          error: function() {
            console.log("failed");
          }
        });
      }
    }

    function generateNewImage(imgURL, imgShowName, imgRealName) {
      var boxGallery = document.getElementById("box-gallery");

      const boxImage = document.createElement("div");
      boxImage.classList.add("gallery-img");
      boxImage.id = imgRealName;
      boxImage.innerHTML = `
                <img src="` + imgURL + `" />
                <span class="gallery-img-alt">` + imgShowName + `</span>
                <button type="button" onclick="deleteImage('` + imgRealName + `')" class="btn btn-del-img">X</button>
            `;

      boxGallery.appendChild(boxImage);
    }

    function getURLParam() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      id = urlParams.get('id');

      return id;
    }

    function getListKategori() {
      var listKategori = [];

      request = $.ajax({
        url: baseURL + "/api/detail",
        type: "POST",
        data: {
          action: 'getListKategori'
        }
      });

      request.done(function(response, textStatus, jqXHR) {
        var resJSON = $.parseJSON(response);
        // console.log(resJSON);

        if (resJSON.status === "failed") {
          console.log(resJSON.msg);
        } else if (resJSON.status === "success") {
          var kategoriTaman = document.getElementById("kategori-taman");
          var lstKategori = resJSON.data;

          for (var i = 0; i < lstKategori.length; i++) {
            // console.log(lstKategori[i]);
            var opt = document.createElement("option");
            opt.value = lstKategori[i].kode_kategori;
            opt.innerHTML = lstKategori[i].nama_kategori;
            kategoriTaman.add(opt);
          }
        }
      });
    }

    getListKategori();

    function saveForm() {
      URLRedirect = "<?= $baseURL ?>/detail/setmap?id=<?= $idTaman ?>&edit=true";
    }

    function finishForm() {
      URLRedirect = "<?= $baseURL ?>/list-admin";
    }

    $("#add-taman").submit(function(e) {
      e.preventDefault();

      if (request) {
        request.abort();
      }

      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea");

      var namaTaman = $form.find('input[name="nama-taman"]').val();
      var kategoriTaman = $form.find('select[name="kategori-taman"]').val();
      var kapasitasTaman = $form.find('input[name="kapasitas-taman"]').val();
      var luasareaTaman = $form.find('input[name="luasarea-taman"]').val();
      var statusTaman = $form.find('select[name="status-taman"]').val();
      var deskripsiTaman = $form.find('textarea[name="deskripsi-taman"]').val();
      var propinsi = $form.find('input[name="propinsi"]').val();
      var kota = $form.find('input[name="kota"]').val();
      var kecamatan = $form.find('input[name="kecamatan"]').val();
      var kelurahan = $form.find('input[name="kelurahan"]').val();
      var rt = $form.find('input[name="rt"]').val();
      var rw = $form.find('input[name="rw"]').val();

      $inputs.prop("disabled", true);

      if (arrImgUpload.length > 0) {
        arrImgUploadSend = arrImgUpload;
      } else {
        arrImgUploadSend = [];
      }

      request = $.ajax({
        url: baseURL + "/api/detail",
        type: "POST",
        data: {
          data: {
            kodeTaman: kodeTaman,
            namaTaman: namaTaman,
            kategoriTaman: kategoriTaman,
            kapasitasTaman: kapasitasTaman,
            luasareaTaman: luasareaTaman,
            statusTaman: statusTaman,
            deskripsiTaman: deskripsiTaman,
            propinsi: propinsi,
            kota: kota,
            kecamatan: kecamatan,
            kelurahan: kelurahan,
            rt: rt,
            rw: rw,
            arrImgUpload: arrImgUploadSend
          },
          action: 'addTaman'
        }
      });

      request.done(function(response, textStatus, jqXHR) {
        // console.log("finish");
        var resJSON = $.parseJSON(response);
        // console.log(resJSON);

        if (resJSON.status === "failed") {
          alert(resJSON.msg);
        } else if (resJSON.status === "success") {
          if (URLRedirect !== "") {
            window.location.replace(URLRedirect);
            // console.log(URLRedirect);
          }
        }
      });

      request.fail(function(jqXHR, textStatus, errorThrown) {
        console.error("error happens : " + textStatus, errorThrown);
      });

      request.always(function() {
        $inputs.prop("disabled", false);
      });
    });
  </script>
</body>

</html>