<nav class="container navbar navbar-expand-lg navbar-light">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <a class="navbar-brand mt-2 mt-lg-0 mx-auto row d-flex" href="<?= BASEURL ?>/">
            <strong class='navbar-title col'>
                <?= WEB_TITLE ?>
            </strong>
        </a>
        <!-- Right elements -->
        <div class="d-flex align-items-center">
            <?php if (!App::CheckUser()) { ?>
                <a class="nav-link" href="<?= BASEURL ?>/Login/">Login</a>
            <?php
            } else { ?>
                <a class="nav-link" href="<?= BASEURL ?>/Logout/">Logout</a>
            <?php } ?>
        </div>
        <!-- Right elements -->
    </div>
</nav>