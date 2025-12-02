 <div class="container-fluid">

 <?php
    $hrefPage = strtolower($tableName);
 ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?=$tableName?></h6>
            <?php 
                if(!isset($hideAdd)) {
                    $nextPath = '/add';
                    if(str_contains(strtolower($tableName), 'career/detail')){
                        $nextPath .= '/' . $empId;
                    }
                    ?>
                        <a class="m-0 font-weight-bold text-primary" href="/<?=$hrefPage . $nextPath?>">+ Add</a>
                    <?php
                }
            ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <?php
                                foreach($header as $item){
                                    ?>
                                        <th><?=$item?></th>
                                    <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                foreach($data as $item){
                                    ?>
                                        <tr>
                                            <?php
                                                foreach($headerAlias as $alias){
                                                    if(
                                                       (str_contains(strtolower($tableName), 'setting/position') && $alias == 'pos_code') //for setting position page 
                                                       || (str_contains(strtolower($tableName), 'setting/level') && $alias == 'level_code') //for setting position page 
                                                       // || (str_contains(strtolower($tableName), 'employee') && $alias == 'emp_id') //for employee page 
                                                       || (str_contains(strtolower($tableName), 'recruitment/applicant') && $alias == 'applicant_code') //for applicant page
                                                       || (str_contains(strtolower($tableName), 'recruitment/request') && $alias == 'req_code') //for recruitment request page
                                                       || (str_contains(strtolower($tableName), 'career') && $alias == 'emp_id') //for career transition page
                                                    ){
                                                        $hrefPage2 =  '/' . $hrefPage . "/edit/" . $item[$alias];
                                                        if(str_contains(strtolower($tableName), 'career') && $alias == 'emp_id'){ //for career transition page
                                                            $hrefPage2 =  '/' . $hrefPage . "/detail/" . $item[$alias];
                                                        }
                                                        ?>
                                                        <td><a href="<?=$hrefPage2?>"><?=$item[$alias]?></a></td>
                                                        <?php
                                                    }else{
                                                    ?>
                                                        <td 
                                                            class="<?php
                                                                if(str_contains($item[$alias], 'finally approved')){
                                                                    echo 'bg-success text-dark';
                                                                }else if(str_contains($item[$alias], 'revised')){
                                                                    echo 'bg-warning text-dark';
                                                                }else if(str_contains($item[$alias], 'waiting for approval')){
                                                                    echo 'bg-secondary text-light';
                                                                }
                                                            ?>">
                                                        <?=$item[$alias]?></td>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    <?php
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>