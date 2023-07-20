<?php
include_once('./environment.php');
include_once('./back-end/sys/sessionlogin.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kategori | Ruang Terbuka Hijau</title>
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
                        Kategori Setting
                    </h2>
                </div>
                <div class="title-header-desc">
                    Here you can setting the kategori.
                </div>
            </div>
        </div>

        <div class="body-page">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <div class="mb-3 d-block">
                        <button type="button" class="ms-auto btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#masterdata-addmodal">Add New Data</button>
                    </div>
                    <table class="table" id="list-data">
                        <thead>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add masterdata-->
    <div class="modal" id="masterdata-addmodal" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="POST" id="add-masterdata">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="masterdata-title">Add New Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="masterdata-code" id="masterdata-code" placeholder="Kode Kategori">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="masterdata-name" id="masterdata-name" placeholder="Nama Kategori">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="masterdata-desc" id="masterdata-desc" placeholder="Description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-secondary btn-sm" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal edit masterdata -->
    <div class="modal" id="masterdata-editmodal" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="POST" id="edit-masterdata">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="masterdata-title">Edit Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="code-masterdata" readonly disabled />
                        <div class="mb-3">
                            <label for="edit-masterdata-code" class="form-label">Code : </label>
                            <input type="text" class="form-control" name="edit-masterdata-code" id="edit-masterdata-code" placeholder="Kode Kategori" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="edit-masterdata-name" class="form-label">Name : </label>
                            <input type="text" class="form-control" name="edit-masterdata-name" id="edit-masterdata-name" placeholder="Nama Kategori">
                        </div>
                        <div class="mb-3">
                            <label for="edit-masterdata-desc" class="form-label">Desc : </label>
                            <input type="text" class="form-control" name="edit-masterdata-desc" id="edit-masterdata-desc" placeholder="Description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" onclick="deleteMasterData()">Delete</button>
                        <input type="submit" class="btn btn-secondary btn-sm" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php include_once './front-end/view/component/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        var baseURL = `<?php echo $baseURL ?>`;

        function deleteMasterData() {
            let codeMasterData = document.getElementById('code-masterdata').value;
            let confirmDelete = "Are you sure want to delete this masterdata ?";
            if (confirm(confirmDelete) == true) {
                request = $.ajax({
                    url: baseURL + "/api/masterdata",
                    type: "POST",
                    data: {
                        data: {
                            masterdataCode: codeMasterData,
                        },
                        action: 'deleteMasterData'
                    }
                });

                request.done(function(response, textStatus, jqXHR) {
                    var resJSON = $.parseJSON(response);
                    console.log(resJSON);

                    if (resJSON.status === "failed") {
                        alert(resJSON.msg);
                    } else if (resJSON.status === "success") {
                        alert(resJSON.msg);
                        $('#masterdata-editmodal').modal('hide');
                        window.location.reload();
                    }
                });

                request.fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("error happens : " + textStatus, errorThrown);
                });
            }
        }

        $("#edit-masterdata").submit(function(e) {
            e.preventDefault();

            if (request) {
                request.abort();
            }

            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");

            var masterdataCode = $form.find('input[name="edit-masterdata-code"]').val();
            var masterdataName = $form.find('input[name="edit-masterdata-name"]').val();
            var masterdataDesc = $form.find('input[name="edit-masterdata-desc"]').val();

            $inputs.prop("disabled", true);

            request = $.ajax({
                url: baseURL + "/api/masterdata",
                type: "POST",
                data: {
                    data: {
                        masterdataCode: masterdataCode,
                        masterdataName: masterdataName,
                        masterdataDesc: masterdataDesc
                    },
                    action: 'editMasterData'
                }
            });

            request.done(function(response, textStatus, jqXHR) {
                var resJSON = $.parseJSON(response);
                console.log(resJSON);

                if (resJSON.status === "failed") {
                    alert(resJSON.msg);
                } else if (resJSON.status === "success") {
                    alert(resJSON.msg);
                    $('#masterdata-addmodal').modal('hide');
                    window.location.reload();
                }
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error("error happens : " + textStatus, errorThrown);
            });

            request.always(function() {
                $inputs.prop("disabled", false);
            });
        });

        $(document).ready(function() {
            var request;

            $("#add-masterdata").submit(function(e) {
                e.preventDefault();

                if (request) {
                    request.abort();
                }

                var $form = $(this);
                var $inputs = $form.find("input, select, button, textarea");

                var masterdataCode = $form.find('input[name="masterdata-code"]').val();
                var masterdataName = $form.find('input[name="masterdata-name"]').val();
                var masterdataDesc = $form.find('input[name="masterdata-desc"]').val();

                $inputs.prop("disabled", true);

                request = $.ajax({
                    url: baseURL + "/api/masterdata",
                    type: "POST",
                    data: {
                        data: {
                            masterdataCode: masterdataCode,
                            masterdataName: masterdataName,
                            masterdataDesc: masterdataDesc
                        },
                        action: 'addMasterData'
                    }
                });

                request.done(function(response, textStatus, jqXHR) {
                    var resJSON = $.parseJSON(response);
                    console.log(resJSON);

                    if (resJSON.status === "failed") {
                        alert(resJSON.msg);
                    } else if (resJSON.status === "success") {
                        alert(resJSON.msg);
                        $('#masterdata-addmodal').modal('hide');
                        window.location.reload();
                    }
                });

                request.fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("error happens : " + textStatus, errorThrown);
                });

                request.always(function() {
                    $inputs.prop("disabled", false);
                });
            });

            function getListData(baseURL) {
                request = $.ajax({
                    url: baseURL + "/api/masterdata",
                    type: "POST",
                    data: {
                        action: 'getMasterDataList'
                    }
                });

                request.done(function(response, textStatus, jqXHR) {
                    var resJSON = $.parseJSON(response);

                    if (resJSON.status === "failed") {
                        // alert(resJSON.msg);
                        console.log("failed load list data");
                    } else if (resJSON.status === "success") {
                        var listData = JSON.stringify(resJSON.data);
                        listData = JSON.parse(listData);
                        // console.log(typeof (listData);
                        showListData(listData, baseURL);
                        // console.log(listData);
                    }
                });

                request.fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("error happens : " + textStatus, errorThrown);
                });
            }

            getListData(baseURL);

            function showListData(listData, baseURL) {
                var tbodyRef = document.getElementById("list-data").getElementsByTagName("tbody")[0];

                let i = 0;
                while (i < listData.length) {
                    $(tbodyRef).append(`<tr>
                        <td><button type="button" class="btn btn-link p-0" onclick="editModal('` + listData[i].kode_kategori + `','` + baseURL + `')">` + listData[i].kode_kategori + `</button></td>
                        <td>` + listData[i].nama_kategori + `</td>
                        <td>` + listData[i].kategori_desc + `</td>
                        </tr>`);

                    i++;
                }
            }
        });

        function editModal(masterdataCode, baseURL) {
            request = $.ajax({
                url: baseURL + "/api/masterdata",
                type: "POST",
                data: {
                    data: {
                        masterdataCode: masterdataCode,
                    },
                    action: 'getMasterData'
                }
            });

            request.done(function(response, textStatus, jqXHR) {
                var resJSON = $.parseJSON(response);

                if (resJSON.status === "failed") {
                    alert(resJSON.msg);
                    console.log("failed load list data");
                } else if (resJSON.status === "success") {
                    document.getElementById('code-masterdata').value = resJSON.data[0].kode_kategori;
                    document.getElementById('edit-masterdata-code').value = resJSON.data[0].kode_kategori;
                    document.getElementById('edit-masterdata-name').value = resJSON.data[0].nama_kategori;
                    document.getElementById('edit-masterdata-desc').value = resJSON.data[0].kategori_desc;
                    $('#masterdata-editmodal').modal('show');

                }
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error("error happens : " + textStatus, errorThrown);
            });
        }
    </script>
</body>

</html>