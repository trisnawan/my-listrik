<?php 
    $request = request();
    $uri = $request->getUri();
    $session = session();
    $user = $session->get();
?>
<nav class="navbar navbar-expand-lg bg-primary navbar-dark sticky-top shadow-sm border-bottom">
    <div class="container py-2">
        <a class="navbar-brand text-white" href="<?= base_url() ?>">
            <i class="bi-lightning"></i>
            <?= getenv('CI_TITLE') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('billing') ?>">Tagihan</a>
                </li>
                <?php if($user['is_admin'] ?? false): ?>
                <li class="nav-item app-dropdown-nav dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin Panel
                    </a>
                    <ul class="app-dropdown-menu">
                        <li>
                            <a class="app-dropdown-item" href="<?= base_url('rates') ?>">Biaya Listrik</a>
                        </li>
                        <li>
                            <a class="app-dropdown-item" href="<?= base_url('customer') ?>">Data Pelanggan</a>
                        </li>
                        <li>
                            <a class="app-dropdown-item" href="<?= base_url('customer/billing') ?>">Tagihan Pelanggan</a>
                        </li>
                    </ul>
                </li>
                <?php endif ?>
                <?php if($user['id'] ?? false): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-person"></i> Profile
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light mt-3" style="width:100%; min-width:320px;">
                        <div>
                            <div class="ps-3 pe-3 pt-2 pb-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="font-weight-bold">
                                            <a href="<?= base_url('account') ?>" class="decoration-none text-dark">
                                                <?= substr($user['full_name'] ?? '', 0, 20) ?><?= strlen($user['full_name'] ?? '') > 20 ? '...' : '' ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('account') ?>" style="text-decoration:none;">
                                <div class="text-dark pt-2 pb-2 ps-3 pe-3 bg-white border-bottom">
                                    <i class="bi-person me-2"></i> Profile
                                </div>
                            </a>
                            <a href="<?= base_url('account/logout') ?>" style="text-decoration:none;">
                                <div class="text-danger pt-2 pb-2 ps-3 pe-3 bg-white border-bottom">
                                    <i class="bi-x-circle me-2"></i> Logout
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <?php else: ?>
                <li class="nav-item ms-0 ms-lg-4">
                    <a class="btn btn-light" href="<?= base_url('account/login') ?>">Sign In</a>
                    <a class="btn btn-outline-light d-none d-xl-inline-block" href="<?= base_url('account/register') ?>">Sign Up</a>
                </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>