<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php
    $data = $query->getResultArray()[0];
?>

<div class="container-fluid">
    <?php include APPPATH . 'views/utilities/button.php' ?>
    <form action="#" method="POST">
    <div class="mb-3">
        <label for="levelCode" class="form-label">Level Code</label>
        <input value="<?=$data['level_code']?>" name="levelCode" type="text" class="form-control" id="levelCode" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="levelName" class="form-label">Level Name</label>
        <input value="<?=$data['level_name']?>" name="levelName" type="text" class="form-control" id="levelName" aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>

<?= $this->endSection() ?>