 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
 <div class="container-fluid">
    <?php
        $header = ['filled count', 'request code', 'position', 'level', 'approval status', 'expected join date', 'request user', 'request date', 'approved date', 'modified date'];
        $headerAlias = ['rec_count', 'req_code', 'pos_name', 'level_name', 'status_name', 'expected_join_date', 'full_name', 'req_date', 'approved_date', 'modified_date'];
        $data =  $query->getResultArray(); 
        $tableName = 'Recruitment/Request'
    ?>

    <?php include APPPATH . 'views/utilities/tables.php' ?>

</div>

<?= $this->endSection() ?>