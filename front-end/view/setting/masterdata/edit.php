<?php include_once('./environment.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Master Data | Ruang Terbuka Hijau</title>
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
                    Edit Data Setting
                </h2>
                </div>
                <div class="title-header-desc">
                Here you can edit the masterdata.
                </div>
            </div>
        </div>

        <div class="body-page">
            <div class="row justify-content-center">
                Edit master data
            </div>
        </div>
    </div>
                
    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>