<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php
    $data = $query->getResultArray()[0];
    $tableName = 'level';
    $idBtnDel = 'btnDelete';
    $valueCode = $data['level_code'];
    $nameCode = 'levelCode'
?>
<?php
    $backUrl = 'setting/level';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <?php include APPPATH . 'views/utilities/buttonDelete.php' ?>
    </div>
       
    <form action="/setting/level/edit" method="POST">
    <div class="mb-3">
        <label for="levelCode" class="form-label">Level Code</label>
        <input value="<?=$data['level_code']?>" name="levelCode" type="text" class="form-control" id="levelCode" aria-describedby="emailHelp" readonly>
    </div>
    <div class="mb-3">
        <label for="levelName" class="form-label">Level Name</label>
        <input value="<?=$data['level_name']?>" name="levelName" type="text" class="form-control" id="levelName" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="levelOrder" class="form-label">Level Order</label>
        <input value="<?=$data['level_order']?>" name="levelOrder" type="text" class="form-control" id="levelOrder" aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>

<?= $this->endSection() ?>