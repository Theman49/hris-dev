<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php
    $backUrl = 'setting/level';
?>

<div class="container-fluid">
    <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
    <form action="/setting/level/add" method="POST">
    <div class="mb-3">
        <label for="levelCode" class="form-label">Level Code</label>
        <input name="levelCode" type="text" class="form-control" id="levelCode" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="levelName" class="form-label">Level Name</label>
        <input name="levelName" type="text" class="form-control" id="levelName" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="levelOrder" class="form-label">Level Order</label>
        <input name="levelOrder" type="text" class="form-control" id="levelOrder" aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>

<?= $this->endSection() ?>