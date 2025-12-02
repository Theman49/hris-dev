 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
 <div class="container-fluid">
    <?php
        $session = session()->get('data');
        $header = ['filled count', 'request code', 'position', 'level', 'approval status', 'expected join date', 'request user', 'request date', 'approved date', 'modified date'];
        $headerAlias = ['filled_count', 'req_code', 'pos_name', 'level_name', 'status_name', 'expected_join_date', 'full_name', 'req_date', 'approved_date', 'modified_date'];
        //$data =  $query->getResultArray(); 
        $data =  $result; 
        $tableName = 'Recruitment/Request';

        if($session['userLevelOrder'] == 4){
            $hideAdd = true;
        }
    ?>

    <?php include APPPATH . 'views/utilities/tables.php' ?>

</div>

<?= $this->endSection() ?>