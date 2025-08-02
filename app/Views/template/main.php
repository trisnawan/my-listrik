<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Home' ?> | <?= getenv('CI_TITLE') ?></title>
    <link href="<?= base_url('assets/css/style.min.css') ?>" rel="stylesheet">
</head>
<body>
    <?= $this->include('template/header') ?>
    <?= $this->renderSection('content') ?>
    <?= $this->include('template/footer') ?>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>