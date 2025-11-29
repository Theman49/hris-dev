    <form id="formDel"  method="POST">
        <input value="<?=$valueCode?>" name="<?=$nameCode?>" type="text" class="form-control d-none"aria-describedby="emailHelp">
        <button type="submit" class="btn btn-danger" id="btn-delete" >Remove</button>
    </form>

    <script>
        const btnDel = document.getElementById('btn-delete');
        btnDel.addEventListener('click', function(event){
            if(confirm('Are you sure want to remove this item?')){
                const form = document.getElementById('formDel');
                console.log('tekljswtlk')
                form.setAttribute('action', '/setting/<?=strtolower($tableName)?>/delete');
                form.submit();
            }else{
                event.preventDefault();
            }
        })
    </script>