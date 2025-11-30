<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php 
    $header = ['level code', 'level name', 'level order'];
    $headerAlias = ['level_code', 'level_name', 'level_order'];
    $data =  $query->getResultArray(); 
    $tableName = 'Setting/Level'
?>

<?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>