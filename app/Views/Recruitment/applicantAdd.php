 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $tableName = 'Recruitment/Applicant';
        // $allRecCode = $recCodeAll->getResultArray();
        $allRecCode = $result;
        $backUrl = $tableName; 
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form action="/recruitment/applicant/add" method="POST">

        <div class="mb-3">
            <label for="recruitmentCode" class="form-label">Recruitment Code</label><br>
            <select name="recruitmentCode" class="form-control" aria-label="Default select example" required>
            <?php
                foreach($allRecCode as $row){
                    ?>
                        <option value="<?=$row['req_code']?>"><?=$row['req_code']?> (<?=$row['pos_code'] . '-' . $row['level_code']?>)</option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input name="fullName" type="text" class="form-control" id="fullName" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="lastEducation" class="form-label">Last Education</label>
            <input name="lastEducation" type="text" class="form-control" id="lastEducation" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="birthDate" class="form-label">Birth Date</label>
            <input name="birthDate" type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input name="salary" type="number" min="0" class="form-control" id="salary" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" id="address" aria-describedby="emailHelp"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

<?= $this->endSection() ?>