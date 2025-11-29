 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
 <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">Recruitment Request</p>

    <?php include APPPATH . 'views/tables.php' ?>

</div>

<?= $this->endSection() ?>