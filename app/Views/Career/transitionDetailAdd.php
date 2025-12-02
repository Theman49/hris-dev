<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php 
    $header = ['career code', 'position', 'level', 'career type', 'effective date', 'end date'];
    $headerAlias = ['career_code', 'pos_name','level_name', 'careertype_name', 'effective_date', 'end_date'];
    $positionAll = $position->getResultArray();
    $levelAll = $level->getResultArray();
    $careerTypeAll = $careerType->getResultArray();
    $tableName = 'Career/Detail';
?>

 <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form action="/career/detail/add" method="POST">

        <div class="mb-3">
            <label for="empId" class="form-label">Emp ID</label>
            <input value="<?=$empId?>" name="empId" type="text" class="form-control" id="empId" aria-describedby="emailHelp" readonly>
        </div>
        <div class="mb-3">
            <label for="careerType" class="form-label">Career Type</label><br>
            <select name="careerType" class="form-control" aria-label="Default select example" required>
            <?php
                foreach($careerTypeAll as $row){
                    ?>
                        <option value="<?=$row['careertype_code']?>"><?=$row['careertype_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="posCode" class="form-label">Position</label><br>
            <select name="posCode" class="form-control" aria-label="Default select example" required>
            <?php
                foreach($positionAll as $row){
                    ?>
                        <option value="<?=$row['pos_code']?>"><?=$row['pos_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="levelCode" class="form-label">Level</label><br>
            <select name="levelCode" class="form-control" aria-label="Default select example" required>
            <?php
                foreach($levelAll as $row){
                    ?>
                        <option value="<?=$row['level_code']?>"><?=$row['level_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="effectiveDate" class="form-label">Effective Date</label>
            <input name="effectiveDate" type="date" class="form-control" id="empId" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="endDate" class="form-label">End Date</label>
            <input name="endDate" type="date" class="form-control" id="empId" aria-describedby="emailHelp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>


<?= $this->endSection() ?>