<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
?>

<div>

</div>

  <div class="container-fluid">
        <h1 class="mb-3">Update Password</h1>
         <form id="form" method="POST" class="user w-50">
            <div class="form-group">
                <input name="username" type="text" class="form-control form-control-user" required
                    id="username" aria-describedby="emailHelp"
                    placeholder="Username">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control form-control-user" required
                    id="password" placeholder="New Password">
            </div>
            <div class="form-group">
                <input name="confirmPassword" type="password" class="form-control form-control-user" required
                    id="confirmPassword" placeholder="Confirm New Password">
            </div>
            <button id="update-button" type="submit" class="btn btn-primary btn-user btn-block">
                Update
            </button>
        </form>

        <script>
            const btn = document.getElementById('update-button');

            btn.addEventListener('click', function(event){
                const passEl = document.getElementById('password');
                const confirmPassEl = document.getElementById('confirmPassword');

                if(passEl.value.length < 8 ){
                    event.preventDefault();        
                    alert('length of password must be greather than equal 8');
                    passEl.focus();
                    return false;
                }

                if(passEl.value !== confirmPassEl.value){
                    event.preventDefault();        
                    alert('please check the password again!');
                    confirmPassEl.focus();
                    return false;
                }

                const check = confirm('Are you sure want to update?');

                if(check){
                    const form = document.getElementById('form');
                    form.action = '/profile';
                    form.submit();
                }
            })

        </script>
    </div>


<?= $this->endSection() ?>