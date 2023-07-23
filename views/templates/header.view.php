<!DOCTYPE html>
<html>

<head>
    <link href="<?= BASEURL ?>/assets/img/dashboard.svg" rel="shortcut icon">
    <title><?= WEB_TITLE ?> | <?= $data['title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="./assets/style/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= BASEURL ?>/assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

</head>

<body>
    <div class="loading-Page">
        <div class="spinner-border text-info" role="status">
        </div>
    </div>
    <main>
        <?php App::Alert() ?>

        <?php
    // if (isset($_POST['profile']) || isset($_POST['profileChange'])) {
//     include "./view/components/modal_profile.php";
// }