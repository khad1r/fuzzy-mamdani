<!doctype html>
<html lang="en">

<head>
    <link href="<?= 'https://' . $_SERVER['HTTP_HOST'] ?>/assets/img/logo-pertashop.png" rel="shortcut icon">
    <title>404 Halaman Tidak ada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= 'https://' . $_SERVER['HTTP_HOST'] ?>/assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <style type="text/css">
        h3 {
            font-size: 2.5em;
        }

        .mohon {
            font-size: 1.8em;
        }

        .text {
            font-size: 1.2em;
            text-align: center;
        }

        .btn-large {
            margin-top: 20px;
            font-size: 1.4em;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            /* place-content: center; */
            height: 100%;

        }

        body {
            height: 100vh;
        }

        h1 {
            font-size: 20rem
        }
    </style>

</head>

<body>
    <div class="container">
        <h1>404!!</h1>
        <h3 class="text-danger fw-bolder">
            <strong>
                Halaman yang di request tidak ada.
            </strong>
        </h3>
        <a href="<?= 'https://' . $_SERVER['HTTP_HOST'] . '/' ?>" class="btn btn-info">
            Kembali</a>
    </div>
</body>

</html>