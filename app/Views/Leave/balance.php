<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php 
    $header = ['employee ID', 'full name', 'address', 'last education', 'birth date', 'position', 'level',];
    $headerAlias = ['emp_id', 'full_name','address', 'last_education', 'birth_date', 'pos_name', 'level_name', ];
    $data =  $query->getResultArray(); 
    $tableName = 'Leave/Balance';
    $hideAdd = true;
?>

<?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>