 <?= $this->extend('layout') ?>

 <?= $this->section('content') ?>
    <?php
        $tableName = 'Leave/Request';
        $allEmp = $query->getResultArray();
        $backUrl = 'leave';
    ?>

    <div class="container-fluid">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
        <form id="formReq" method="POST">

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
            <div class="mb-3 w-25">
                <label for="leaveBalance" class="form-label">Leave Balance</label>
                <input name="leaveBalance" type="number" class="form-control" id="leaveBalance" aria-describedby="emailHelp" readonly>
            </div>
        </div>

        <div class="d-flex">
            <div class="mb-3 w-100 mr-3">
                <label for="leaveStartDate" class="form-label">Leave Start Date</label>
                <input name="leaveStartDate" type="date" class="form-control" min="<?=date('Y-m-d')?>" max="<?=date('Y')?>-12-31" id="leaveStartDate" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3 w-100">
                <label for="leaveEndDate" class="form-label">Leave End Date</label>
                <input name="leaveEndDate" type="date" class="form-control" min="<?=date('Y-m-d')?>" max="<?=date('Y')?>-12-31" id="leaveEndDate" aria-describedby="emailHelp" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" id="reason" aria-describedby="emailHelp" required></textarea>
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

        const btnSubmit = document.getElementById('btn-submit');
        btnSubmit.addEventListener('click', function(event){

            //check leave end date
            const leaveStartDate = document.getElementById('leaveStartDate');
            const leaveEndDate = document.getElementById('leaveEndDate');
            const leaveBalance = document.getElementById('leaveBalance');

            if(leaveEndDate.value < leaveStartDate.value){
                alert("leave end date must be greather than start date");
                leaveEndDate.focus();
                event.preventDefault();
            }

            if(leaveBalance.value == 0){
                alert("this employee doesn't have balance this year");
                leaveBalance.focus();
                event.preventDefault();

            }

        })


    </script>

<?= $this->endSection() ?>