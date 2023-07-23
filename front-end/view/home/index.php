<?php
include_once('./environment.php');
include_once('./back-end/sys/anonymouselogin.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Home | Ruang Terbuka Hijau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    <div class="row justify-content-center">
        <div class="header-page">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <!-- <a class="btn btn-back" href="<?= $baseURL ?>/list">&#8826; Back</a> -->
                <div class="title-header">
                    <h2>
                        Welcome Back To
                        <br />
                        Ruang Terbuka Hijau
                    </h2>
                </div>
                <!-- <div class="title-header-desc">
                    Here you can setting the masterdata.
                </div> -->
            </div>
        </div>

        <div class="body-page">
            <div class="row justify-content-center">
                <img src="<?= $baseURL ?>/assets/Ruangterbukahijau-sample.jpeg" class="mb-3" />
                <div class=" about-title">
                    About Ruang Terbuka Hijau
                </div>
                <div class="about-separator"></div>
                <div class="about-desc">
                    Ruang Terbuka Hijau adalah aplikasi untuk menampilkan data taman yang ada di DKI Jakarta. Dalam aplikasi ini publik bisa melihat tentang informasi taman, lokasi taman, pencarian taman, dan mendapatkan arah ke lokasi taman.
                </div>
                <div class="about-title mt-4">
                    Fitur Ruang Terbuka Hijau
                </div>
                <div class="about-separator"></div>
                <div class="about-desc mb-5">
                    Fitur fitur yang tersedia untuk diakses oleh publik antara dapat dilihat pada table dibawah ini
                    <table class="table table-bordered mt-2" style="border: 1px solid #69b578; border-radius: 4px">
                        <thead style=" background: #69b578; color: white;" class="text-center">
                            <td>No</td>
                            <td>Nama Menu</td>
                            <td>Deskripsi</td>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Home</td>
                                <td>Tentang Ruang Terbuka Hijau</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Map Taman</td>
                                <td>Untuk user melihat titik taman sesuai yang ada di peta</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>List Taman</td>
                                <td>Untuk user melihat list dari taman yang ada di DKI Jakarta</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Map Search</td>
                                <td>Untuk user melakukan pencarian taman dan mendapatkan arah ke taman tersebut</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

</body>

</html>