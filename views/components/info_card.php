<div class="col-lg-3 d-lg-block d-none d-md-none">
    <div class="card p-5 rounded shadow">
        <div class="card-body text-center d-flex justify-content-center flex-column">
            <img class="card-img-top" src="<?= BASEURL ?>/assets/img/logo.png" alt="" style="width: 100%;">
            <h4 class="card-title mt-4 fw-bold" style="font-size:1.3vw">
                <?= $_SESSION['user']['name'] ?>
            </h4>
            <p class="card-text text-capitalize" style="font-size:.9vw">
                <?= $_SESSION['user']['level_user']; ?>
            </p>
        </div>
    </div>
</div>