 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $session = session()->get('data');
        $allEmp = $allEmp->getResultArray();
        $data = $result->getResultArray()[0];
        $backUrl = 'leave';
        $tableName = 'Leave/Request'
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form id="formApproval" method="POST">
        <div class="mb-3">
            <label for="leaveCode" class="form-label">Leave Code</label>
            <input value="<?=$leaveCode?>" name="leaveCode" type="text" class="form-control" id="leaveCode" aria-describedby="emailHelp" readonly>
        </div>
        <div class="d-flex">
            <div class="mb-3 w-75 mr-3">
                <label for="reqFor" class="form-label">Request For</label><br>
                <select name="reqFor" id="reqFor" class="form-control" aria-label="Default select example" required disabled>
                <?php
                    foreach($allEmp as $row){
                        ?>
                            <option <?=($data['req_for'] == $row['emp_id']) ? 'selected' : ''?> value="<?=$row['emp_id']?>"><?=$row['full_name']?> (<?=$row['pos_name']?>-<?=$row['level_name']?>)</option>
                        <?php
                    }
                ?>
                </select>
            </div>
            <div class="mb-3 w-25">
                <label for="leaveBalance" class="form-label">Leave Balance</label>
                <input value="<?=$data['balance_value']?>" name="leaveBalance" type="number" class="form-control" id="leaveBalance" aria-describedby="emailHelp" readonly>
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 w-100 mr-3">
                <label for="leaveStartDate" class="form-label">Leave Start Date</label>
                <input value="<?=$data['leave_startdate']?>" name="leaveStartDate" min="<?=date('Y-m-d')?>" max="<?=date('Y')?>-12-31" type="date" class="form-control" id="leaveStartDate" aria-describedby="emailHelp" required readonly>
            </div>
            <div class="mb-3 w-100">
                <label for="leaveEndDate" class="form-label">Leave End Date</label>
                <input value="<?=$data['leave_enddate']?>" name="leaveEndDate" min="<?=date('Y-m-d')?>" max="<?=date('Y')?>-12-31" type="date" class="form-control" id="leaveEndDate" aria-describedby="emailHelp" required readonly>
            </div>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" readonly><?=$data['reason']?></textarea>
        </div>
        <?php
            if(
                ($data['req_status'] == 2 && $session['userLevelOrder'] == 4) // for HRD
                || ($data['req_status'] == 1 && $data['req_for'] != $session['userEmpId'] && in_array($session['userLevelOrder'], [2,3])) // for SPV / MGR
            ){
                ?>
                    <div class="mb-3">
                        <label for="reasonRevise" class="form-label">Reason Revise</label>
                        <textarea name="reasonRevise" class="form-control" id="reasonRevise" aria-describedby="emailHelp"><?=$data['reason_revise']?></textarea>
                    </div>
                    <button id="btn-approve" type="submit" class="btn btn-primary">Approve</button>
                    <button id="btn-revise" type="submit" class="btn btn-danger">Revise</button>
                <?php
            }

            if(
                ($data['req_status'] == 1 && $session['userLevelOrder'] == 4) // for HRD
            ){
                ?>
                    <p class="text-danger">SPV / MGR need to approved first</p>
                <?php
            }
        ?>
        </form>
    </div>

        <?php
            if(
                ($data['req_status'] == 2 && $session['userLevelOrder'] == 4) // for HRD
                || ($data['req_status'] == 1 && in_array($session['userLevelOrder'], [2,3])) // for SPV / MGR
            ){
                ?>
                    <script>
                        const btnRevise = document.getElementById('btn-revise');
                        btnRevise.addEventListener('click', function(event){
                            const note = document.getElementById('reasonRevise'); 
                            if(note.value === ''){
                                note.setAttribute('required', true);
                                note.focus();
                            }else{
                                if(confirm('Are you sure want to revise this request?')){
                                    const form = document.getElementById('formApproval');
                                    console.log('revise clicked')
                                    form.setAttribute('action', '/<?=strtolower($tableName)?>/revise');
                                    form.submit();
                                }else{
                                    event.preventDefault();
                                }
                            }
                        })
                        const btnApprove = document.getElementById('btn-approve');
                        btnApprove.addEventListener('click', function(event){
                            if(confirm('Are you sure want to approve this request?')){
                                const form = document.getElementById('formApproval');
                                console.log('approve clicked')
                                form.setAttribute('action', '/<?=strtolower($tableName)?>/approve');
                                form.submit();
                            }else{
                                event.preventDefault();
                            }
                        })
                    </script>
                <?php
            }
        ?>

<?= $this->endSection() ?>