<?php include_once('./environment.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>List Taman | Ruang Terbuka Hijau</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link href="<?= $baseURL ?>/front-end/style/globalstyle.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <script type="text/javascript">
        window.history.forward();
    </script>
</head>

<body>
    <div class="row justify-content-center">
        <div class="header-page">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <a class="btn btn-back" onclick="test()" href="<?= $baseURL ?>/list">&#8826; Back</a>
                <div class="title-header">
                    <h2>
                        List Taman
                    </h2>
                </div>
                <div class="title-header-desc">
                    Here you can manage taman data
                </div>
            </div>
        </div>

        <div class="body-page">
            <div class="row justify-content-center">
                <div class="mb-3 d-flex">
                    <button type="button" onclick="generateNewId()" class="ms-auto d-block btn btn-secondary btn-sm btn-add-taman">Add New Data</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Code</td>
                            <td>Nama</td>
                            <td>Kota</td>
                            <td>Propinsi</td>
                            <td>Remove</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">TMN001</a></td>
                            <td>Taman Barito</td>
                            <td>Jakarta Selatan</td>
                            <td>DKI Jakarta</td>
                            <td><button type="button" class="btn btn-danger"><i class="bi bi-trash3"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        var baseURL = `<?= $baseURL ?>`;

        function generateNewId() {
            request = $.ajax({
                url: baseURL + "/api/listing",
                type: "POST",
                data: {
                    action: 'generateId'
                }
            });

            request.done(function(response, textStatus, jqXHR) {
                var resJSON = $.parseJSON(response);
                console.log(resJSON);

                if (resJSON.status === "failed") {
                    console.log(resJSON.msg);
                } else if (resJSON.status === "success") {
                    console.log(resJSON.msg);
                    window.location.href = baseURL + "/detail/add?id=" + resJSON.data;
                }
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error("error happens : " + textStatus, errorThrown);
            });
        }
    </script>
</body>

</html>