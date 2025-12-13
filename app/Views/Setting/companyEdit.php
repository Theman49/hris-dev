<?= $this->extend('layout') ?>


<?= $this->section('content') ?>
<?php
    $data = $query->getResultArray()[0];
    $tableName = 'company';
    $idBtnDel = 'btnDelete';
    $valueCode = $data['param_code'];
    $nameCode = 'paramCode'
?>
<?php
    $backUrl = 'setting/company';


    $days = [
        ['value' => 0, 'text' => 'Sunday'],
        ['value' => 1, 'text' => 'Monday'],
        ['value' => 2, 'text' => 'Tuesday'],
        ['value' => 3, 'text' => 'Wednesday'],
        ['value' => 4, 'text' => 'Thursday'],
        ['value' => 5, 'text' => 'Friday'],
        ['value' => 6, 'text' => 'Saturday'],
    ];

?>

<div class="container-fluid">
    <div class="d-flex justify-content-between">
        <?php include APPPATH . 'views/utilities/buttonBack.php' ?>
    </div>
       
    <form action="/setting/company/edit" method="POST">
    <div class="mb-3">
        <label for="paramCode" class="form-label">Parameter Code</label>
        <input value="<?=$data['param_code']?>" name="paramCode" type="text" class="form-control" id="levelCode" aria-describedby="emailHelp" readonly>
    </div>
    <?php
        if($data['param_code'] == 'leave_deduct'){
            ?>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="radioDefault1" <?=($data['param_value']) == 1 ? 'checked' : '' ?> name="paramValue" value="1" >
                    <label class="form-check-label" for="radioDefault1">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="radioDefault2"  <?=($data['param_value']) == 0 ? 'checked' : '' ?> name="paramValue" value="0" >
                    <label class="form-check-label" for="radioDefault2">
                        No
                    </label>
                </div>
            </div>
            <?php
        }else if($data['param_code'] == 'leave_day_off'){
            $arrValue = explode(',', $data['param_value']);
            ?>
                <div class="mb-3">
                    <input name="paramValue" type="hidden" id="paramValue">
                    <select name="value[]" class="form-control" style="height: 200px" aria-label="Default select example" multiple onchange="adjustValue(this)" required>
                    <?php
                        foreach($days as $row){
                            ?>
                                <option <?=(in_array($row['value'], $arrValue)) ? 'selected' : '' ?> value="<?=$row['value']?>"><?=$row['text']?></option>
                            <?php
                        }
                    ?>
                    </select>
                </div>
            <?php
        }    

    ?>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
        function adjustValue(e){
            const paramValue = document.getElementById('paramValue');
            const selectedValues = Array.from(e.selectedOptions).map(option => option.value);
            console.log(selectedValues);
            paramValue.value = selectedValues.join(',')
        }
    </script>


</div>

<?= $this->endSection() ?>