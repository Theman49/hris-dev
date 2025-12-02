 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $tableName = 'Recruitment/Applicant';
        $allAppStatus = $appStatusAll->getResultArray();
        $data = $query->getResultArray()[0];
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form action="/recruitment/applicant/edit" method="POST">

        <div class="d-flex justify-content-between">
            <div class="mb-3 w-100 mr-3">
                <label for="recruitmentCode" class="form-label">Recruitment Code</label>
                <input value="<?=$data['rec_code']?>" name="recruitmentCode" type="text" class="form-control" id="recruitmentCode" aria-describedby="emailHelp" readonly>
            </div>
            <div class="mb-3 w-100 mr-3">
                <label for="applicantCode" class="form-label">Applicant Code</label>
                <input value="<?=$data['applicant_code']?>" name="applicantCode" type="text" class="form-control" id="applicantCode" aria-describedby="emailHelp" readonly>
            </div>
            <div class="mb-3 w-100">
                <label for="applicantStatus" class="form-label">Applicant Status</label><br>
                <select name="applicantStatus" class="form-control" aria-label="Default select example" required>
                <?php
                    foreach($allAppStatus as $row){
                        ?>
                            <option <?=($data['applicant_status'] == $row['status_code']) ? 'selected' : ''?> value="<?=$row['status_code']?>"><?=$row['status_name']?></option>
                        <?php
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input value="<?=$data['full_name']?>" name="fullName" type="text" class="form-control" id="fullName" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="lastEducation" class="form-label">Last Education</label>
            <input value="<?=$data['last_education']?>" name="lastEducation" type="text" class="form-control" id="lastEducation" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="birthDate" class="form-label">Birth Date</label>
            <input value="<?=$data['birth_date']?>" name="birthDate" type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input value="<?=$data['salary']?>" name="salary" type="number" min="0" class="form-control" id="salary" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" id="address" aria-describedby="emailHelp"><?=$data['address']?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

<?= $this->endSection() ?>