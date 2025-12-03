 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $session = session()->get('data');
        $header = ['filled count', 'request code', 'position', 'level', 'approval status', 'expected join date', 'request user', 'request date', 'approved date', 'modified date'];
        $headerAlias = ['rec_count', 'req_code', 'pos_name', 'level_name', 'status_name', 'expected_join_date', 'full_name', 'req_date', 'approved_date', 'modified_date'];
        $tableName = 'Recruitment/Request';
        $allPos = $posAll->getResultArray();
        $allLevel = $levelAll->getResultArray();
        $data = $query->getResultArray()[0];
        $backUrl = $tableName;
    ?>

    <?php if($session['userLevelOrder'] == 4){
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form id="formApprove" method="POST">
        <div class="mb-3">
            <label for="reqCode" class="form-label">Recruitment Request Code</label>
            <input value="<?=$data['req_code']?>" name="reqCode" type="text" min="1" class="form-control" id="reqCount" aria-describedby="emailHelp" readonly>
        </div>
        <div class="mb-3">
            <label for="recCount" class="form-label">Recruitment People</label>
            <input value="<?=$data['rec_count']?>" name="recCount" type="number" min="1" class="form-control" id="recCount" aria-describedby="emailHelp" readonly>
        </div>
        <div class="mb-3">
            <label for="posCode" class="form-label">Position</label><br>

            <select name="posCode" class="form-control" aria-label="Default select example" required disabled>
            <?php
                foreach($allPos as $row){
                    ?>
                        <option <?=($row['pos_code'] == $data['pos_code']) ? 'selected' : ''?> value="<?=$row['pos_code']?>"><?=$row['pos_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="levelCode" class="form-label">Level</label><br>

            <select name="levelCode" class="form-control" aria-label="Default select example" required disabled>
            <?php
                foreach($allLevel as $row){
                    ?>
                        <option <?=($row['level_code'] == $data['level_code']) ? 'selected' : ''?> value="<?=$row['level_code']?>"><?=$row['level_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="expectedJoinDate" class="form-label">Expected Join Date</label>
            <input value="<?=$data['expected_join_date']?>" name="expectedJoinDate" type="date" class="form-control" id="expectedJoindate" aria-describedby="emailHelp" readonly>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" readonly><?=$data['reason']?></textarea>
        </div>
        <?php if($data['req_status'] < 3){
            ?>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea placeholder="note revision input here..." name="note" class="form-control" id="note" aria-describedby="emailHelp"></textarea>
        </div>
            <button id="btn-approve" type="submit" class="btn btn-primary">Approve</button>
            <button id="btn-revise" type="submit" class="btn btn-danger">Revise</button>
            <?php
        }
        ?>

        </form>

    </div>

    <?php if($data['req_status'] < 3){
        ?>
    <script>
        const btnRevise = document.getElementById('btn-revise');
        btnRevise.addEventListener('click', function(event){
            const note = document.getElementById('note'); 
            if(note.value === ''){
                note.setAttribute('required', true);
                note.focus();
            }else{
                if(confirm('Are you sure want to revise this request?')){
                    const form = document.getElementById('formApprove');
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
                const form = document.getElementById('formApprove');
                console.log('approve clicked')
                form.setAttribute('action', '/<?=strtolower($tableName)?>/approve');
                form.submit();
            }else{
                event.preventDefault();
            }
        })

    </script>
    <?php } ?>

    <?php
    }else{
        ?>
    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form id="formApprove" method="POST">
        <div class="mb-3">
            <label for="reqCode" class="form-label">Recruitment Request Code</label>
            <input value="<?=$data['req_code']?>" name="reqCode" type="text" min="1" class="form-control" id="reqCount" aria-describedby="emailHelp"  readonly>
        </div>
        <div class="mb-3">
            <label for="recCount" class="form-label">Recruitment People</label>
            <input value="<?=$data['rec_count']?>" name="recCount" type="number" min="1" class="form-control" id="recCount" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="posCode" class="form-label">Position</label><br>

            <select name="posCode" class="form-control" aria-label="Default select example" required>
            <?php
                foreach($allPos as $row){
                    ?>
                        <option <?=($row['pos_code'] == $data['pos_code']) ? 'selected' : ''?> value="<?=$row['pos_code']?>"><?=$row['pos_name']?></option>
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
                        <option <?=($row['level_code'] == $data['level_code']) ? 'selected' : ''?> value="<?=$row['level_code']?>"><?=$row['level_name']?></option>
                    <?php
                }
            ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="expectedJoinDate" class="form-label">Expected Join Date</label>
            <input value="<?=$data['expected_join_date']?>" name="expectedJoinDate" type="date" class="form-control" id="expectedJoindate" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" required><?=$data['reason']?></textarea>
        </div>
        <?php if($data['req_status'] == 4){
            ?>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control" id="note" aria-describedby="emailHelp" readonly><?=$data['reason_revise']?></textarea>
                </div>
                <button id="btn-submit" type="submit" class="btn btn-primary">Send to Approver</button>
        <?php
            }
        ?>
        </form>

    </div>

    <script>
        <?php if($data['req_status'] == 4){
        ?>
        const btnSubmit = document.getElementById('btn-submit');
        btnSubmit.addEventListener('click', function(event){
            if(confirm('Are you sure want to send to approver?')){
                const form = document.getElementById('formApprove');
                console.log('submit clicked')
                form.setAttribute('action', '/<?=strtolower($tableName)?>/resubmit');
                form.submit();
            }else{
                event.preventDefault();
            }
        })
        <?php } ?>

    </script>
        <?php
    }
    ?>

<?= $this->endSection() ?>