<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php 
    $header = ['position code', 'position name', 'parent code', 'job description'];
    $headerAlias = ['pos_code', 'pos_name', 'parent_code', 'pos_desc'];
    $allPos = $query->getResultArray();
    $tableName = 'Position'
?>


<div class="container-fluid">
    <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
    <form action="/setting/position/add" method="POST">
    <div class="mb-3">
        <label for="posCode" class="form-label">Position Code</label>
        <input name="posCode" type="text" class="form-control" id="posCode" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="posName" class="form-label">Position Name</label>
        <input name="posName" type="text" class="form-control" id="posName" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="parentCode" class="form-label">Parent Code</label><br>

        <select name="parentCode" class="form-control" aria-label="Default select example">
                <?php
                    foreach($allPos as $row){
                ?>
                    <option value="<?=$row['pos_code']?>"><?=$row['pos_name']?></option>
                <?php
            }
        ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="posDesc" class="form-label">Job Description</label>
        <textarea name="posDesc" class="form-control" id="posName" aria-describedby="emailHelp"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>

<?= $this->endSection() ?>