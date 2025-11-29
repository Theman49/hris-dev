<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php 
    $header = ['level code', 'level name'];
    $headerAlias = ['level_code', 'level_name', ];
    $data =  $query->getResultArray(); 
    $tableName = 'Level'
?>

<?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>