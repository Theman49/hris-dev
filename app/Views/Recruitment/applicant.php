 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
 <div class="container-fluid">
    <?php
        $header = ['recruitment code','applicant code', 'full name', 'address', 'last education', 'birth date', 'salary'];
        $headerAlias = ['rec_code', 'applicant_code', 'full_name','address', 'last_education', 'birth_date', 'salary' ];
        $data =  $query->getResultArray(); 
        $tableName = 'Recruitment/Applicant';
    ?>

    <?php include APPPATH . 'views/utilities/tables.php' ?>

</div>

<?= $this->endSection() ?>