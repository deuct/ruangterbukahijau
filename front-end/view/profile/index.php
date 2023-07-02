<?php include_once('./environment.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile | Ruang Terbuka Hijau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>
<body>
    <div class="row justify-content-center">
        <div class="header-page">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <a class="btn btn-back" href="<?= $baseURL ?>/list">&#8826; Back</a>
                <div class="title-header">
                <h2>
                    Welcome to your profile
                </h2>
                </div>
                <div class="title-header-desc">
                Here you can see information of your profile
                </div>
            </div>
        </div>

        <div class="body-page">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <div class="d-block text-center">
                        <img src="<?= $baseURL ?>/assets/user-icon-vector.jpg" width="300" height="300" />
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Username</td>
                                <td>: farhan09</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>: Farhan Fadil</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: farhan@mail.com</td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>: Pd. Benda</td>
                            </tr>
                            <tr>
                                <td>Kelurahan</td>
                                <td>: Pamulang</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>: Pamulang, Tangerang Selatan</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-3 mb-4">
                        <a href="<?= $baseURL ?>/list" class="btn btn-secondary btn-sm">Back</a>
                        <button type="button" class="btn btn-success btn-sm">Edit</button>
                    </div>
                </div>
            </div>
            <!-- <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-sm-12">

                </div>
            </div> -->
        </div>
    </div>
                
    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

</body>

</html>