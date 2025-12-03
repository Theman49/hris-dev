<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php 
    $session = session()->get('data');
    $header = ['career code', 'position', 'level', 'career type', 'effective date', 'end date'];
    $headerAlias = ['career_code', 'pos_name','level_name', 'careertype_name', 'effective_date', 'end_date'];
    $data =  $query->getResultArray(); 
    $tableName = 'Career/Detail';
    if($session['userLevelOrder'] == 1){
        $hideAdd = true;
    }
    $backUrl = 'career';
?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
    </div>
    <?php include APPPATH . 'views/utilities/tables.php' ?>


<?= $this->endSection() ?>