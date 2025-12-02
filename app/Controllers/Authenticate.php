<?php

namespace App\Controllers;

class Authenticate extends BaseController
{
    public function login(): string
    {
        return view('login');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
    public function loginSubmit() 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = db_connect();
        $builder = $db->table('hrmuser');
        $builder->join('hrmemployee', 'hrmuser.user_id = hrmemployee.user_id', 'left');
        $builder->join('hrmcareer', 'hrmemployee.emp_id = hrmcareer.emp_id', 'left');
        $builder->join('hrmlevel', 'hrmcareer.level_code = hrmlevel.level_code', 'left');
        $builder->where('hrmuser.username', $username);
        $builder->orderBy('hrmcareer.effective_date DESC');
        $query = $builder->get();
        if(!$query){
            echo "<script>alert('login failed')</script>";
            return $this->login();
        }

        $data = $query->getResultArray();
        if($data && ($data[0]['password'] == $password)){
            $query = $builder->get();
            $emp = $query->getResultArray()[0];


            $session = session();

            $newData = [
                'userId' => $data[0]['user_id'],
                'username' => $data[0]['username'],
                'userLevel' => $data[0]['level_code'],
                'userFullName' => $data[0]['full_name'],
                'userEmpId' => $data[0]['emp_id'],
                'userLevelOrder' => $data[0]['level_order'],
                'userPosCode' => $data[0]['pos_code'],
                'isLogin' => 1,
            ];

            $session->set('data', $newData);

            echo "<script>alert('login success')</script>";
            return redirect()->to('/');
        }else{
            echo "<script>alert('login failed')</script>";
            return $this->login();
        }
    }
}
