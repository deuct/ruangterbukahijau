<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

// $currDir = dirname(__FILE__); // buat get current directory
//   echo "<br />" . $_FILES['fileupload']['error']; // buat check error fileupload

require("./environment.php");
require("./back-end/sys/connection.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;
$data = isset($_POST['data']) ? json_encode($_POST['data']) : null;

if ($data !== null) {
    $data = json_decode($data);
}

if (isset($action)) {
    if ($action == 'addTaman') {
        addTaman($conn, $baseURL, $data);
    } else if ($action == 'getListKategori') {
        getListKategori($conn, $baseURL);
    } else if ($action == 'addImage') {
        addImage($conn, $baseURL, $imgDir, $imgDirShort);
    } else if ($action == 'deleteImage') {
        deleteImage($conn, $baseURL, $data, $imgDir);
    } else if ($action == 'addCoord') {
        addCoord($conn, $baseURL, $data);
    } else if ($action == 'getDetailTaman') {
        getDetailTaman($conn, $baseURL, $data);
    }
}

// if (isset($_POST['nama_file'])) {
//     addImage($conn, $baseURL, $data);
// }

function getDetailTaman($conn, $baseURL, $data)
{
    $responseObj = new stdClass();
    $kodeTaman = $data->kodeTaman;

    $qGetDetailTaman = "SELECT detail.kode_rth, detail.nama, detail.kode_kategori, detail.lst_gambar, detail.kapasitas, detail.luas_area, coor.kordinat_1, coor.kordinat_2, detail.status, detail.deskripsi, detail.kota, detail.propinsi, detail.kecamatan, detail.kelurahan, detail.rt, detail.rw FROM detail_rth detail 
    LEFT JOIN kordinat_rth coor ON coor.kode_taman = detail.kode_rth AND coor.kode_kordinat = detail.kode_kordinat 
    WHERE detail.kode_rth = '$kodeTaman'";
    $stmt = $conn->prepare($qGetDetailTaman);
    $stmt->execute();
    $detailTaman = $stmt->get_result();

    // foreach ($detailTaman as $dt) {
    //     $kode_rth = $dt['kode_rth'];
    //     $nama = $dt['nama'];
    //     $kode_kategori = $dt['kode_kategori'];
    //     $lst_gambar = $dt['lst_gambar'];
    //     $kapasitas = $dt['kapasitas'];
    //     $luas_area = $dt['luas_area'];
    //     $kordinat_1 = $dt['kordinat_1'];
    //     $kordinat_2 = $dt['kordinat_2'];
    //     $status = $dt['status'];
    //     $deskripsi = $dt['deskripsi'];
    //     $kota = $dt['kota'];
    //     $propinsi = $dt['propinsi'];
    //     $kecamatan = $dt['kecamatan'];
    //     $kelurahan = $dt['kelurahan'];
    //     $rt = $dt['rt'];
    //     $rw = $dt['rw'];
    // }

    $resultArr = array();
    foreach ($detailTaman as $key => $rs) {
        $resultArr[] = $rs;
    }

    if (count($resultArr) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}

function addCoord($conn, $baseURL, $data)
{
    $responseObj = new stdClass();
    $dateNow = date("Y-m-d H:i:s");
    $superadmin = 'superadmin';

    $coord = $data->coord;
    $kodeTaman = $data->kodeTaman;

    $qGetCoordExist = "SELECT kode_kordinat, kode_taman FROM kordinat_rth WHERE kode_taman = '$kodeTaman'";
    $stmt = $conn->prepare($qGetCoordExist);
    $stmt->execute();
    $coordExist = $stmt->get_result();
    $coordStore = "";

    foreach ($coordExist as $ce) {
        $coordStore = $ce['kode_taman'];
    }

    if ($coordStore === "") {
        $qInsertCoord = "INSERT INTO kordinat_rth (kode_taman, kordinat_1, kordinat_2, created_at, created_by, modified_at, modified_by) VALUES ('$kodeTaman', '$coord[0]', '$coord[1]', '$dateNow', '$superadmin', '$dateNow', '$superadmin')";
        $stmt = $conn->prepare($qInsertCoord);
        $stmt->execute();
    } else {
        $qUpdateCoord = "
            UPDATE kordinat_rth 
            SET kordinat_1 = '$coord[0]', 
            kordinat_2 = '$coord[1]', 
            modified_at = '$dateNow', 
            modified_by = '$superadmin'
            WHERE kode_taman = '$kodeTaman'";
        $stmt = $conn->prepare($qUpdateCoord);
        $stmt->execute();
    }

    $qGetCodeCoor = "SELECT kode_kordinat FROM kordinat_rth WHERE kode_taman = '$kodeTaman'";
    $stmt = $conn->prepare($qGetCodeCoor);
    $stmt->execute();

    $codeCoor = $stmt->get_result();
    $codeCoor = $codeCoor->fetch_assoc();
    $codeCoor = $codeCoor['kode_kordinat'];

    $qUpdateDetail = "UPDATE detail_rth SET kode_kordinat = '$codeCoor' WHERE kode_rth = '$kodeTaman'";
    $stmt = $conn->prepare($qUpdateDetail);
    $stmt->execute();
}

function addTaman($conn, $baseURL, $data)
{
    $responseObj = new stdClass();
    $dateNow = date("Y-m-d H:i:s");

    // echo $data->luasareaTaman;
    $kodeTaman = $data->kodeTaman;
    $namaTaman = $data->namaTaman;
    $kategoriTaman = $data->kategoriTaman;
    $kapasitasTaman = !empty($data->kapasitasTaman) ? $data->kapasitasTaman : 0;
    $luasareaTaman = !empty($data->luasareaTaman) ? $data->luasareaTaman : 0;
    $statusTaman = $data->statusTaman;
    $deskripsiTaman = $data->deskripsiTaman;
    $propinsi = $data->propinsi;
    $kota = $data->kota;
    $kecamatan = $data->kecamatan;
    $kelurahan = $data->kelurahan;
    $rt = !empty($data->rt) ? $data->rt : 0;
    $rw = !empty($data->rw) ? $data->rw : 0;
    // $kodeKordinat = isset($_POST['kodeKordinat']) ? $data->kodeKordinat : "";
    if (!empty($data->arrImgUpload)) {
        $arrImgUpload = json_encode($data->arrImgUpload);
    } else if (empty($data->arrImgUpload)) {
        $arrImgUpload = "";
    }

    $qInsertDetail = "
        UPDATE detail_rth SET 
        nama = '$namaTaman',
        kode_kategori = '$kategoriTaman',
        lst_gambar = '$arrImgUpload',
        kapasitas = '$kapasitasTaman',
        luas_area = '$luasareaTaman',
        status = '$statusTaman',
        deskripsi = '$deskripsiTaman',
        kota = '$kota',
        propinsi = '$propinsi',
        kecamatan = '$kecamatan',
        kelurahan = '$kelurahan',
        rt = '$rt',
        rw = '$rw',
        modified_at = '$dateNow',
        modified_by = 'superadmin'
        WHERE kode_rth = '$kodeTaman'";
    $stmt = $conn->prepare($qInsertDetail);
    $stmt->execute();

    $responseObj->status = "success";
    $responseObj->msg = "Successfully insert data";
    $responseJSON = json_encode($responseObj);

    echo $responseJSON;
}

function getListKategori($conn, $baseURL)
{
    $responseObj = new stdClass();

    $qGetListKategori = "SELECT kode_kategori, nama_kategori FROM kategori_rth";
    $stmt = $conn->prepare($qGetListKategori);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultArr = array();
    foreach ($result as $key => $rs) {
        $resultArr[] = $rs;
    }

    if (count($resultArr) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}

function addImage($conn, $baseURL, $imgDir, $imgDirShort)
{
    $responseObj = new stdClass();
    $responseImg = new stdClass();

    $temp = $imgDir;
    $fileupload = $_FILES['fileupload']['tmp_name'];
    $ImageName = $_FILES['fileupload']['name'];
    $ImageType = $_FILES['fileupload']['type'];
    $kodeTaman = $_POST['kode_taman'];

    if (!empty($fileupload) && !empty($kodeTaman)) {
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt = str_replace('.', '', $ImageExt); // Extension
        $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        $NewImageName = str_replace(' ', '', $ImageName . '.' . $ImageExt);
        $NewImageName = $kodeTaman . "_" . $NewImageName;

        move_uploaded_file($_FILES["fileupload"]["tmp_name"], "$temp/$NewImageName");

        $responseImg->show_name = $ImageName . "." . $ImageExt;
        $responseImg->real_name = $NewImageName;
        $responseImg->src = $baseURL . "/" . $imgDirShort . "/" . $NewImageName;

        $responseObj->status = "success";
        $responseObj->msg = "Successfully upload image";
        $responseObj->data = $responseImg;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    } else {
        echo "Data Gagal Diupload";
    }
}

function deleteImage($conn, $baseURL, $data, $imgDir)
{
    $imgName = $data->imgName;
    unlink("$imgDir/$imgName");
}
