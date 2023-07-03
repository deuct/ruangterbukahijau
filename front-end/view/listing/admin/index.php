<?php
include_once('./environment.php');
?>

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
            <div class="row justify-content-center" style="overflow: auto !important">
                <div class="mb-3 d-flex">
                    <button type="button" onclick="generateNewId()" class="ms-auto d-block btn btn-secondary btn-sm btn-add-taman">Add New Data</button>
                </div>
                <table class="table" id="list-data">
                    <thead>
                        <tr>
                            <td>Code</td>
                            <td>Nama</td>
                            <td>Kota</td>
                            <td>Propinsi</td>
                            <td>Remove</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure want to delete this data ?
                        <input type="text" name="delete-id" hidden style="visibility:hidden; display:none" id="delete-id" value="" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="deleteDetail()" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        var baseURL = `<?= $baseURL ?>`;

        $(document).ready(function() {
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
                        // console.log(resJSON.data[0]);
                        assignValue(resJSON);
                    }
                },
                error: function() {
                    console.log("failed");
                }
            });
        })

        $(document).on("click", ".delete-confirm", function() {
            let deleteId = $(this).data('id');
            $(".modal-body #delete-id").val(deleteId);
            // console.log($(".modal-body #delete-id"));

            // console.log(document.getElementById("delete-id").value);
        });

        function assignValue(resJSON) {
            let data = resJSON.data;

            console.log(data);

            var tbodyRef = document.getElementById("list-data").getElementsByTagName("tbody")[0];

            for (let i = 0; i < data.length; i++) {
                // console.log(data[i]);
                // console.log(i);
                $(tbodyRef).append(`<tr>
                            <td><a href="` + baseURL + `/detail/edit?id=` + data[i].kode_rth + `">` + data[i].kode_rth + `</a></td>
                            <td>` + data[i].nama + `</td>
                            <td>` + data[i].kota + `</td>
                            <td>` + data[i].propinsi + `</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger delete-confirm" data-bs-toggle="modal" data-bs-target="#deleteConfirm" data-id="` + data[i].kode_rth + `">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>`);
            }
        }

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

        function deleteDetail(kodeTaman) {
            let deleteId = document.getElementById("delete-id").value;

            console.log(deleteId);
            $.ajax({
                url: baseURL + "/api/listing",
                type: "POST",
                data: {
                    data: {
                        kodeTaman: deleteId
                    },
                    action: "deleteDetailTaman",
                },
                success: function(response) {
                    var resJSON = $.parseJSON(response);

                    if (resJSON.status === "failed") {
                        console.log(resJSON.msg);
                    } else if (resJSON.status === "success") {
                        console.log("finish");
                        $('#deleteConfirm').modal('hide');
                        window.location.reload();
                    }
                },
                error: function() {
                    console.log("failed");
                }
            });
        }
    </script>
</body>

</html>