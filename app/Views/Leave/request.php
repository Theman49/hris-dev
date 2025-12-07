 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
 <div class="container-fluid">
    <?php
        $session = session()->get('data');
        $header = ['leave code', 'request for', 'leave start date', 'leave end date', 'request user',  'request date', 'request status', 'approved date', 'modified date','modified user'];
        $headerAlias = ['leave_code', 'req_for_name', 'leave_startdate', 'leave_enddate', 'req_user_name',  'req_date', 'status_name', 'approved_date', 'modified_date','modified_user'];
        $data =  $result; 
        $tableName = 'Leave/Request';
    ?>

    <?php include APPPATH . 'views/utilities/tables.php' ?>

</div>

<?= $this->endSection() ?>