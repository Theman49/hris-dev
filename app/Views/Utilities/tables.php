 <div class="container-fluid">

 <?php
    $hrefPage = '/setting/' . strtolower($tableName);
 ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?=$tableName?></h6>
            <a class="m-0 font-weight-bold text-primary" href="<?=$hrefPage?>/add">+ Add</a>
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
                                                    if(str_contains($alias, 'code') && !str_contains($alias, 'parent')){
                                                        $hrefPage2 =  $hrefPage . "/edit/" . $item[$alias];
                                                        ?>
                                                        <th><a href="<?=$hrefPage2?>"><?=$item[$alias]?></a></th>
                                                        <?php
                                                    }else{
                                                    ?>
                                                        <th><?=$item[$alias]?></th>
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