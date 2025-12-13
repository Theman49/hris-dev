<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php 
    $session = session()->get('data');
    $header = ['Leave balance ID', 'emp id', 'balance value', 'start period', 'end period', 'status',];
    $headerAlias = ['leavebalance_id', 'emp_id', 'balance_value', 'start_period', 'end_period', 'active_status',];
    $data =  $query->getResultArray(); 
    $tableName = 'Leave/Balance/Detail';
    if(
        ($session['userLevelOrder'] == 1)
        || (($session['userEmpId'] == $targetEmpId) && $session['userLevelOrder'] < 4)
    ){
        $hideAdd = true;
    }
    $backUrl = 'leave/balance';
?>

<div class="container-fluid">
    <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
</div>
<?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>