 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $tableName = 'Leave/Request';
        $allEmp = $query->getResultArray();
        $backUrl = 'leave';
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form id="formReq" method="POST" enctype="multipart/form-data">

        <div class="d-flex">
            <div class="mb-3 w-75 mr-3">
                <label for="reqFor" class="form-label">Request For</label><br>

                <select name="reqFor" class="form-control" aria-label="Default select example" onChange="getBalance(this)" required>
                    <option value="">---</option>
                <?php
                    foreach($allEmp as $row){
                        ?>
                            <option value="<?=$row['emp_id']?>"><?=$row['full_name']?> (<?=$row['pos_name']?>-<?=$row['level_name']?>)</option>
                        <?php
                    }
                ?>
                </select>
            </div>
            <div class="mb-3 mr-3">
                <label for="leaveBalance" class="form-label">Leave Balance</label>
                <input name="leaveBalance" type="number" class="form-control" id="leaveBalance" aria-describedby="emailHelp" readonly>
            </div>
            <div class="mb-3">
                <label for="checkForSick" class="form-label">Sick Request</label>
                <input name="checkForSick" type="checkbox" class="form-control" id="checkForSick" aria-describedby="emailHelp" onclick="toggleSick()">
                <input name="reqForSick" type="hidden" class="form-control" id="reqForSick" aria-describedby="emailHelp">
            </div>
        </div>

        <div class="d-flex">
            <div class="mb-3 w-100 mr-3">
                <label for="leaveStartDate" class="form-label">Leave Start Date</label>
                <input name="leaveStartDate" type="date" class="form-control" min="<?=date('Y-m-d')?>"  id="leaveStartDate" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3 w-100">
                <label for="leaveEndDate" class="form-label">Leave End Date</label>
                <input name="leaveEndDate" type="date" class="form-control" min="<?=date('Y-m-d')?>"  id="leaveEndDate" aria-describedby="emailHelp" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" required></textarea>
        </div>
        <div class="mb-3" id="boxAttachment" style="position: absolute; left:-9999px">
            <label for="attachment" class="form-label"><span class="text-danger">*</span> Attachment (.jpg,.jpeg,.png)</label>
            <input name="attachment" type="file" class="form-control" accept=".jpg,.jpeg,.png"  id="attachment" aria-describedby="emailHelp" required>
        </div>
        <button id="btn-submit" type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>




    <script>

        async function getBalance(e){
            const formData = new FormData();
            formData.append('selectedEmpId', e.value);
            formData.action = '/leave/balance/get';
            formData.method = 'POST';

            const response = await fetch('<?=base_url('/leave/balance/get')?>', {
                method: "POST",
                body: formData,
            });
            const balanceField = document.getElementById('leaveBalance');
            const result = await response.json()
            balanceField.value = result.balance_value;
        }

        

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
        }

        onFirstLoad();



       

        const btnSubmit = document.getElementById('btn-submit');
        btnSubmit.addEventListener('click', function(event){

            //check leave end date
            const leaveStartDate = document.getElementById('leaveStartDate');
            const leaveEndDate = document.getElementById('leaveEndDate');
            const leaveBalance = document.getElementById('leaveBalance');


            if(leaveStartDate.value == ''){
                alert("leave start date required");
                leaveStartDate.focus();
                event.preventDefault();
                return 0;
            }

            if(leaveEndDate.value == ''){
                alert("leave end date required");
                leaveEndDate.focus();
                event.preventDefault();
                return 0;
            }

            if(leaveEndDate.value < leaveStartDate.value){
                alert("leave end date must be greather than start date");
                leaveEndDate.focus();
                event.preventDefault();
            }


            const reqForSick = document.getElementById('reqForSick');
            const attachment = document.getElementById('attachment');
            const reason = document.getElementById('reason');

            if(reqForSick.value == 1 && attachment.value == ''){
                alert("attachment required");
                attachment.focus();
                event.preventDefault();
                return 0;
            }
            if(reason.value == ''){
                alert("reason required");
                reason.focus();
                event.preventDefault();
                return 0;
            }
            // if not req sick, compare req leave with balance 
            if(reqForSick.value != 1){

                async function getLeaveSetting(){
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

                    console.log('isDeduct', isDeduct);
                    console.log('listDayOff', listDayOff);

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

                    const date1 = new Date(leaveStartDate.value)
                    const date2 = new Date(leaveEndDate.value)
                    const diffInMs = date2.getTime() - date1.getTime()
                    let diffInDays = (diffInMs / (1000 * 60 * 60 * 24)) + 1

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
                    }


                }

                getLeaveSetting();

                if(leaveBalance.value == 0){
                    alert("this employee doesn't have balance this year");
                    leaveBalance.focus();
                    event.preventDefault();

                }

                
                

            }


        const form = document.getElementById('formReq');
        form.action = '/leave/request/add';
        form.submit();

        // event.preventDefault();
        })


    </script>

<?= $this->endSection() ?>