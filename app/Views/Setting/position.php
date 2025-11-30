<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php 
    $header = ['position code', 'position name', 'parent code', 'job description'];
    $headerAlias = ['pos_code', 'pos_name', 'parent_code', 'pos_desc'];
    $data = $query->getResultArray();
    $tableName = 'Setting/Position'
?>

<?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>