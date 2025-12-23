<?php

namespace App\Controllers;

class User extends BaseController
{
    public function profile(): string
    {
        $db = db_connect();
        $session = session()->get('data');

        $builder = $db->table('hrmemployee emp')
                    ->join('hrmuser user', 'emp.user_id = user.user_id')
                    ->where('emp.emp_id', $session['userEmpId'])
                    ->select('user.username, user.password')
                    ->get();
        
        $result = $builder->getResultArray()[0];

        $data = [
            'result' => $result
        ];
        return view('User/profile', $data);
    }

    public function profileUpdate()
    {
        $db = db_connect();
        $session = session()->get('data');

        $builder = $db->table('hrmemployee emp')
                    ->where('emp.emp_id', $session['userEmpId'])
                    ->select('emp.user_id')
                    ->get();
        
        $result = $builder->getResultArray()[0];

        $newUsername = $_POST['username'];
        $newPassword = $_POST['password'];

        $query =  $db->table('hrmuser')
                        ->where('user_id', $result['user_id'])
                        ->set([
                            'username' => $newUsername,
                            'password' => $newPassword,
                        ])
                        ->update();
        if($query){
            echo "<script>alert('success update')</script>";
        }else{
            echo "<script>alert('failed update')</script>";
        }

        return view('dashboard');
    }
}
