 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $header = ['filled count', 'request code', 'position', 'level', 'approval status', 'expected join date', 'request user', 'request date', 'approved date', 'modified date'];
        $headerAlias = ['rec_count', 'req_code', 'pos_name', 'level_name', 'status_name', 'expected_join_date', 'full_name', 'req_date', 'approved_date', 'modified_date'];
        $tableName = 'Recruitment/Request';
        $allPos = $posAll->getResultArray();
        $allLevel = $levelAll->getResultArray();
        $backUrl = $tableName;
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form action="/recruitment/request/add" method="POST">
        <div class="mb-3">
            <label for="recCount" class="form-label">Head Count</label>
            <input name="recCount" type="number" min="1" class="form-control" id="recCount" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="posCode" class="form-label">Position</label><br>

            <select name="posCode" class="form-control" aria-label="Default select example" required>
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
            <label for="levelCode" class="form-label">Level</label><br>

            <select name="levelCode" class="form-control" aria-label="Default select example" required>
            <?php
                foreach($allLevel as $row){
                    ?>
                        <option value="<?=$row['level_code']?>"><?=$row['level_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="expectedJoinDate" class="form-label">Expected Join Date</label>
            <input name="expectedJoinDate" type="date" class="form-control" id="expectedJoindate" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

<?= $this->endSection() ?>