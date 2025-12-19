 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $session = session()->get('data');
        $allEmp = $allEmp->getResultArray();
        $data = $result->getResultArray()[0];
        $backUrl = 'leave';
        $tableName = 'Leave/Request';
    ?>







    
    <?php
        // FORM REVISE HERE
        if($data['req_status'] == 4 && $data['req_user'] == $session['userEmpId']){
            ?>
     <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form id="formApproval" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="leaveCode" class="form-label">Leave Code</label>
            <input value="<?=$leaveCode?>" name="leaveCode" type="text" class="form-control" id="leaveCode" aria-describedby="emailHelp" readonly>
        </div>
        <div class="d-flex">
            <div class="mb-3 w-75 mr-3">
                <label for="reqFor" class="form-label">Request For</label><br>
                <select name="reqFor" id="reqFor" class="form-control" aria-label="Default select example" required>
                <?php
                    foreach($allEmp as $row){
                        ?>
                            <option <?=($data['req_for'] == $row['emp_id'] || old('reqFor') == $row['emp_id']) ? 'selected' : ''?> value="<?=$row['emp_id']?>"><?=$row['full_name']?> (<?=$row['pos_name']?>-<?=$row['level_name']?>)</option>
                        <?php
                    }
                ?>
                </select>
            </div>
            <div class="mb-3 mr-3">
                <label for="leaveBalance" class="form-label">Leave Balance</label>
                <input value="<?=(old('leaveBalance') !== null) ? old('leaveBalance') : $data['balance_value']?>" name="leaveBalance" type="number" class="form-control" id="leaveBalance" aria-describedby="emailHelp" readonly>
            </div>
            <div class="mb-3">
                <label for="checkForSick" class="form-label">Sick Request</label>
                <input name="checkForSick" <?=$data['is_sick_leave'] == 1 || old('reqForSick') == 1 ? 'checked' : ''?> type="checkbox" class="form-control" id="checkForSick" aria-describedby="emailHelp" onclick="toggleSick()">
                <input name="reqForSick" value="<?=(old('reqForSick') !== null) ? old('reqForSick') : $data['is_sick_leave']?>" type="hidden" class="form-control" id="reqForSick" aria-describedby="emailHelp">
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 w-100 mr-3">
                <label for="leaveStartDate" class="form-label">Leave Start Date</label>
                <input value="<?=(old('leaveStartDate') !== null) ? old('leaveStartDate') : $data['leave_startdate']?>" name="leaveStartDate" min="<?=date('Y-m-d')?>" max="<?=date('Y')?>-12-31" type="date" class="form-control" id="leaveStartDate" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3 w-100">
                <label for="leaveEndDate" class="form-label">Leave End Date</label>
                <input value="<?=(old('leaveEndDate') !== null) ? old('leaveEndDate') : $data['leave_enddate']?>" name="leaveEndDate" min="<?=date('Y-m-d')?>" max="<?=date('Y')?>-12-31" type="date" class="form-control" id="leaveEndDate" aria-describedby="emailHelp" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp"><?=(old('reason') !== null) ? old('reason') : $data['reason']?></textarea>
        </div>
        <div class="mb-3" id="boxAttachment" style="<?=($data['is_sick_leave'] == 1 ) ? 'position: relative; left:0px' : 'position: absolute; left:-9999px'?>">
            <label for="attachment" class="form-label"><span class="text-danger">*</span> Resubmit Attachment (.jpg,.jpeg,.png)</label>
            <input name="attachment" type="file" class="form-control" accept=".jpg,.jpeg,.png"  id="attachment" aria-describedby="emailHelp" required>
        </div>
            <div class="mb-3">
                <label for="reasonRevise" class="form-label">Reason Revise</label>
                <textarea name="reasonRevise" class="form-control" id="reasonRevise" aria-describedby="emailHelp" readonly><?=$data['reason_revise']?></textarea>
            </div>
            <button id="btn-resubmit" type="submit" class="btn btn-primary">Submit to Approver</button>
        </form>
        <script>

                        function toggleSick(){
                            const checkForSick = document.getElementById('checkForSick');
                            const reqForSick = document.getElementById('reqForSick');
                            const boxAttachment = document.getElementById('boxAttachment');

                            if(checkForSick.checked){
                                reqForSick.value = 1
                                boxAttachment.style.position = 'relative'
                                boxAttachment.style.left = '0'
                            }else{
                                reqForSick.value = ''
                                boxAttachment.style.position = 'absolute'
                                boxAttachment.style.left = '-9999px'
                            }
                        }


                         async function onFirstLoad(){
                                    const response = await fetch('<?=base_url('/leave/setting/get')?>', {
                                        method: "GET",
                                    });
                                    const result = await response.json()
                                    console.log('LEAVE SETTING', result)

                                    let isDeduct = 0; //0 is inactive
                                    let listDayOff = [];

                                    result.forEach((item) => {
                                        if(item.name == 'leave_deduct'){
                                            isDeduct = item.value
                                        }else if(item.name == 'leave_day_off'){
                                            temp = item.value.split(',')
                                            listDayOff = temp.map((item) => {
                                                return parseInt(item)
                                            })
                                        }
                                    })

                                
                                    // if isDeduct active 
                                    // Everything except day off based on setting 
                                    if(isDeduct == 1){
                                        const validate = dateString => {
                                            const day = (new Date(dateString)).getDay();
                                            if (listDayOff.includes(day)) {
                                                return false;
                                            }
                                            return true;
                                        }

                                        // Sets the value to '' in case of an invalid date
                                        document.querySelector('#leaveStartDate').onchange = evt => {
                                            if (!validate(evt.target.value)) {
                                                evt.target.value = '';
                                            }
                                        }
                                        // Sets the value to '' in case of an invalid date
                                        document.querySelector('#leaveEndDate').onchange = evt => {
                                            if (!validate(evt.target.value)) {
                                                evt.target.value = '';
                                            }
                                        }
                                    }

                                    return {
                                        'isDeduct' : isDeduct,
                                        'listDayOff' : listDayOff,
                                    }
                        }

                        onFirstLoad();
                        



                    

                        const btnSubmit = document.getElementById('btn-resubmit');
                        btnSubmit.addEventListener('click', async function(event){

                            $checkPassed = true;

                            //check leave end date
                            const leaveStartDate = document.getElementById('leaveStartDate');
                            const leaveEndDate = document.getElementById('leaveEndDate');
                            const leaveBalance = document.getElementById('leaveBalance');
                            const attachment = document.getElementById('attachment');

                            if(leaveEndDate.value < leaveStartDate.value){
                                alert("leave end date must be greather than start date");
                                leaveEndDate.focus();
                                event.preventDefault();
                                $checkPassed = false;
                            }


                            const reqForSick = document.getElementById('reqForSick');
                            // if not req sick, compare req leave with balance 
                            if(reqForSick.value != 1){

                               
                                    const date1 = new Date(leaveStartDate.value)
                                    const date2 = new Date(leaveEndDate.value)
                                    const diffInMs = date2.getTime() - date1.getTime()
                                    let diffInDays = (diffInMs / (1000 * 60 * 60 * 24)) + 1

                                    x = await onFirstLoad();
                                    let isDeduct = x.isDeduct;
                                    let listDayOff = x.listDayOff;


                                    // substract by day off setting when isdeduct == 1
                                    if(isDeduct == 1){
                                        diffInDays = 0;
                                        while(date1 <= date2){
                                            const day = date1.getDay();

                                            if(!listDayOff.includes(day)){
                                                diffInDays += 1;
                                            }

                                            date1.setDate(date1.getDate() + 1);
                                        }

                                    }
                                    console.log('diffindays', diffInDays)

                                    if(diffInDays > leaveBalance.value){
                                        alert(`total request leave (${diffInDays} days) can't greater than balance value`);
                                        leaveEndDate.focus();
                                        event.preventDefault();
                                        $checkPassed = false;
                                    }


                                if(leaveBalance.value == 0){
                                    alert("this employee doesn't have balance this year");
                                    leaveBalance.focus();
                                    event.preventDefault();
                                    $checkPassed = false;
                                }


                                
                                

                            }

                            if(reqForSick.value == 1 && attachment.value == ''){
                                alert("attachment required");
                                attachment.focus();
                                event.preventDefault();
                                $checkPassed = false;
                            }

                            if($checkPassed == true){
                                if(confirm('Are you sure want to resubmit this request?')){
                                    const form = document.getElementById('formApproval');
                                    console.log('resubmit clicked')
                                    form.setAttribute('action', '/<?=strtolower($tableName)?>/resubmit');
                                    form.submit();
                                }else{
                                    event.preventDefault();
                                }
                            }


                        // event.preventDefault();
                        })





                    </script>
    </div>

            <?php
        }else{
            // View or Approver FORM
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
                <input type="hidden" name="reqForHidden" value="<?=$data['req_for']?>"/>
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
            <div class="mb-3 w-100 mr-3">
                <label for="reqUser" class="form-label">Request User</label><br>
                <select name="reqUser" id="reqUser" class="form-control" aria-label="Default select example" required disabled>
                <?php
                    foreach($allEmp as $row){
                        ?>
                            <option <?=($data['req_user'] == $row['emp_id']) ? 'selected' : ''?> value="<?=$row['emp_id']?>"><?=$row['full_name']?> (<?=$row['pos_name']?>-<?=$row['level_name']?>)</option>
                        <?php
                    }
                ?>
                </select>
            </div>
            <div class="mb-3 mr-3">
                <label for="leaveBalance" class="form-label">Leave Balance</label>
                <input value="<?=$data['balance_value']?>" name="leaveBalance" type="number" class="form-control" id="leaveBalance" aria-describedby="emailHelp" readonly>
            </div>
            <div class="mb-3">
                <label for="checkForSick" class="form-label">Sick Request</label>
                <input name="checkForSick" <?=$data['is_sick_leave'] == 1 ? 'checked' : ''?> type="checkbox" class="form-control" id="checkForSick" aria-describedby="emailHelp" disabled>
                <input name="reqForSick" value="<?=$data['is_sick_leave']?>" type="hidden" class="form-control" id="reqForSick" aria-describedby="emailHelp">
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
        <?php
            if($data['is_sick_leave'] == 1){
                ?>
                    <div class="mb-3">
                        <p>Attachment</p>
                        <img class="w-50" src="<?= site_url('leave/image/' . $data['attachment']) ?>" alt="Uploaded Image">
                    </div>
                <?php
            } 
        ?>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" readonly><?=$data['reason']?></textarea>
        </div>
        <?php
            // 1 -> waiting approval
            // 2 -> partially
            // 3 -> final
            // 4 -> revise
            if(
                ($data['req_status'] == 2 && $session['userLevelOrder'] == 4) // for HRD
                || (($data['req_status'] == 1 && $data['req_user'] != $session['userEmpId'] && in_array($session['userLevelOrder'], [2,3]))) // for SPV / MGR
                || ($data['req_status'] == 1 && in_array($data['req_user_level_order'], [2,3])  && $session['userLevelOrder'] == 4)
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
                ($data['req_status'] == 1 && in_array($data['req_user_level_order'], [1]) && $session['userLevelOrder'] == 4) // for HRD
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
                || (($data['req_status'] == 1 && $data['req_user'] != $session['userEmpId'] && in_array($session['userLevelOrder'], [2,3]))) // for SPV / MGR
                || ($data['req_status'] == 1 && in_array($data['req_user_level_order'], [2,3])  && $session['userLevelOrder'] == 4) // for HRD case req spv / mgr
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
            <?php
        }
        ?>

<?= $this->endSection() ?>