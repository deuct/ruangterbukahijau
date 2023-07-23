<?php
include_once('./environment.php');
include_once('./back-end/sys/sessionlogin.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Map Taman | Ruang Terbuka Hijau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href="<?= $baseURL ?>/front-end/script/leaflet/src/L.Control.MapCenterCoord.css" />
    <script src="<?= $baseURL ?>/front-end/script/leaflet/src/L.Control.MapCenterCoord.js"></script>

    <link rel="stylesheet" href="<?= $baseURL ?>/front-end/script/leaflet/src/dist/leaflet-routing-machine.css" />
    <script src="<?= $baseURL ?>/front-end/script/leaflet/src/dist/leaflet-routing-machine.js"></script>
    <!-- End Leaflet -->
</head>

<body>
    <div class="row justify-content-center">
        <div class="header-page">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <a class="btn btn-back" href="<?= $baseURL ?>/list">&#8826; Back</a>
                <div class="title-header">
                    <h2>
                        Map Search
                    </h2>
                </div>
                <div class="title-header-desc">
                    Here you can search location of taman and get the directions.
                </div>
            </div>
        </div>

        <div class="body-page">
            <!-- <div class="row justify-content-center mb-3">
                <div class="col-lg-12 col-md-12 col-sm-12 d-flex">
                    <input type="text" class="form-control" id="search-location" name="search-location" placeholder="Search Location..." onchange="refreshForm()" />
                    <button type="button" onclick="searchTaman()" class=" btn btn-outline-primary btn-sm"><i class="bi bi-search d-block"></i></button>
                </div>
            </div> -->
            <!-- <div class="row justify-content-center mb-3">
                <div class="col-lg-12 col-md-12 col-sm-12 d-flex">
                    <div class="search-result" id="search-result" style="display: none;">
                    </div>
                    <div id="failed-msg"></div>
                    <div id="success-msg"></div>
                </div>
            </div> -->
            <div class="row justify-content-center">
                <div class="setmap">
                    <div id="map"></div>

                    <script type="text/javascript">
                        const map = L.map("map");
                        // map.setView([-6.33392, 106.71856], 19);
                        map.setView([-6.17523, 106.82707], 13);

                        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                        }).addTo(map);

                        // L.control
                        //     .mapCenterCoord()
                        //     .addTo(map);

                        // map.addControl(L.control.search());
                    </script>
                </div>
            </div>
        </div>
    </div>

    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        var userLatitude, userLongitude;
        var baseURL = "<?= $baseURL ?>";
        var imgDirShort = `<?= $imgDirShort ?>`;
        var imHere = `<div>You're Here</div>`;

        var meIcon = L.icon({
            iconUrl: '<?= $baseURL ?>/assets/standman.png',
            iconSize: [36, 46]
        });

        function refreshForm() {
            let searchValue = document.getElementById('search-location');

            if (searchValue.value === "") {
                searchValue.value = "";
                document.getElementById('success-msg').innerHTML = "";

                let resItemDel = document.querySelectorAll('.result-item-div');
                resItemDel.forEach(resdel => {
                    resdel.remove();
                });

                var searchResultEl = document.getElementById('search-result');
                searchResultEl.style = "display: none;";

                let failMsg = document.getElementById('failed-msg');
                failMsg.innerHTML = '';
            }
        }

        function searchTaman() {
            let searchValue = document.getElementById('search-location').value;

            if (searchValue !== "") {
                $.ajax({
                    url: baseURL + "/api/listing",
                    type: "POST",
                    data: {
                        data: {
                            searchValue: searchValue
                        },
                        action: "getSearchTaman",
                    },
                    success: function(response) {
                        var resJSON = $.parseJSON(response);
                        // console.log(resJSON);

                        if (resJSON.status === "failed") {
                            console.log(resJSON.msg);
                            document.getElementById('failed-msg').innerHTML = `<span>Sorry, can't find what are you looking for :(</span>`;
                            document.getElementById('success-msg').innerHTML = "";
                            let resItemDel = document.querySelectorAll('.result-item-div');
                            resItemDel.forEach(resdel => {
                                resdel.remove();
                            });
                        } else if (resJSON.status === "success") {
                            // console.log(resJSON.data);
                            searchResult(resJSON.data);
                        }
                    },
                    error: function() {
                        console.log("failed");
                    }
                });
            }
        }

        function searchResult(data) {
            var resultHTML, namaTaman, kotaTaman, propinsiTaman, kodeTaman, latitudeTaman, longitudeTaman;

            var searchResultEl = document.getElementById('search-result');
            searchResultEl.style = "display: block;";

            let resItemDel = document.querySelectorAll('.result-item-div');
            resItemDel.forEach(resdel => {
                resdel.remove();
            });

            for (let i = 0; i < data.length; i++) {
                namaTaman = data[i].nama;
                kotaTaman = data[i].kota;
                kodeTaman = data[i].kode_rth;
                propinsiTaman = data[i].propinsi;
                latitudeTaman = data[i].kordinat_1;
                longitudeTaman = data[i].kordinat_2;

                let resultHTMLDiv = document.createElement('div');
                resultHTMLDiv.className = "result-item-div";

                if (latitudeTaman !== null || longitudeTaman !== null) {
                    resultHTML = `<span class="result-item p-1" onclick="goSearch(` + latitudeTaman + `,` + longitudeTaman + `,'` + namaTaman + `','` + kodeTaman + `')">` + namaTaman + `, ` + kotaTaman + `, ` + propinsiTaman + `</span>`;
                    resultHTMLDiv.innerHTML = resultHTML;
                    searchResultEl.appendChild(resultHTMLDiv);
                }

                console.log(data[i]);
            }
        }

        function goSearch(latitude, longitude, namaTaman, kodeTaman) {
            map.setView([latitude, longitude], 19);

            document.getElementById('failed-msg').innerHTML = "";
            document.getElementById('success-msg').innerHTML = `<span>Showing result for : ` + namaTaman + `</span> <button onclick="getDirection(` + latitude + `,` + longitude + `,'` + namaTaman + `','` + kodeTaman + `')" class="btn btn-sm btn-outline-success">get direction</button> <button type="button" onclick="refreshForm()" class="btn btn-sm btn-outline-danger">clear</button>`;

            let resItemDel = document.querySelectorAll('.result-item-div');
            resItemDel.forEach(resdel => {
                resdel.remove();
            });

            document.getElementById('search-location').value = "";

            var searchResultEl = document.getElementById('search-result');
            searchResultEl.style = "display: none;";
        }

        function getDirection(latitude, longitude, namaTaman, kodeTaman) {
            document.getElementById('success-msg').innerHTML = `<span>Showing direction to : ` + namaTaman + `</span> <button onclick="refreshMap()" class="btn btn-sm btn-outline-danger">clear</button>`;


            // var editableLayers = new L.FeatureGroup();
            // editableLayers.clearLayers();
            map.removeLayer(marker)

            marker = new L.Marker(
                [userLatitude, userLongitude], {
                    icon: meIcon
                });
            marker.addTo(map).bindPopup(imHere);

            marker = new L.Marker(
                [latitude, longitude]);
            marker.addTo(map);

            L.Routing.control({
                waypoints: [
                    L.latLng(userLatitude, userLongitude),
                    L.latLng(latitude, longitude)
                ],
                routeWhileDragging: true
            }).addTo(map);
        }

        function refreshMap() {
            window.location.reload();
        }

        $(document).ready(function() {
            $.ajax({
                url: baseURL + "/api/listing",
                type: "POST",
                data: {
                    action: "getAllTaman"
                },
                success: function(response) {
                    var resJSON = $.parseJSON(response);
                    // console.log(resJSON);

                    if (resJSON.status === "failed") {
                        console.log(resJSON.msg);
                    } else if (resJSON.status === "success") {
                        // console.log(resJSON.data);
                        generatePoint(resJSON.data);
                    }
                },
                error: function() {
                    console.log("failed");
                }
            });
        })

        function generatePoint(data) {
            var marker, tamanDescription, thumbnail, nameTaman, descTaman, kodeTaman, tamanLatitude, tamanLongitude;

            for (let i = 0; i < data.length; i++) {
                thumbnail = data[i].lst_gambar !== "" ? JSON.parse(data[i].lst_gambar) : "";
                nameTaman = data[i].nama;
                descTaman = data[i].deskripsi;
                kodeTaman = data[i].kode_rth;
                tamanLatitude = data[i].kordinat_1;
                tamanLongitude = data[i].kordinat_2;

                // console.log(thumbnail[0]);

                tamanDescription = `<div>
                    <center>
                        <img src="` + baseURL + imgDirShort + `/` + thumbnail[0] + ` " height="120px" width="120px"/>
                    </center>
                    <h3 class="mt-2">` + nameTaman + `</h3>  
                    <div style="background: yellow;width: 100%;height: 1px" class="mb-3"></div>
                    <span>` + descTaman + `</span>
                    <span class="d-block mt-1"><a href="` + baseURL + `/detail?id=` + kodeTaman + `">More Information »</a></span>
                </div>`;

                // console.log(tamanLatitude);

                if (tamanLatitude !== null && tamanLongitude !== null) {
                    marker = new L.Marker(
                        [tamanLatitude, tamanLongitude]);
                    marker.addTo(map).bindPopup(tamanDescription);
                }
            }
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
        };

        const successCallback = (position) => {
            userLatitude = position.coords.latitude;
            userLongitude = position.coords.longitude;

            map.setView([userLatitude, userLongitude], 19);

            L.circle([userLatitude, userLongitude], {
                radius: 2000
            }).addTo(map);

            marker = new L.Marker(
                [userLatitude, userLongitude], {
                    icon: meIcon
                });
            marker.addTo(map).bindPopup(imHere);
        }

        const errorCallback = (error) => {
            alert("Please allow locations to use this feature");
        };

        // getLocation();

        function getLocation() {
            let confText = "Do you want to allow access to your location ?";
            if (confirm(confText) === true) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
            } else {
                window.location.href = "<?= $baseURL ?>/list";
            }
        }
    </script>
</body>

</html>