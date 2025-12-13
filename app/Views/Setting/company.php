<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php 
    $header = ['Parameter Code', 'Paramater Value'];
    $headerAlias = ['param_code', 'param_value'];
    $data =  $query->getResultArray(); 
    $tableName = 'Setting/Company';
    $hideAdd = true;
?>

<?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>