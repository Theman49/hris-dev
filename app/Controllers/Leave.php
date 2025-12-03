<?php

namespace App\Controllers;

class Leave extends BaseController
{
    public function request(): string
    {
        $session = session()->get('data');
        $db = db_connect();

        // $builder = $db->table('hrmemployee');
        // $builder->select('emp.*, MAX(ca.effective_date) as effective_date, max(pos.pos_code), pos.pos_name, lev.level_code, lev.level_name');
        // $builder->join('hrmcareer ca', 'emp.emp_id = ca.emp_id');
        // $builder->join('hrmposition pos', 'ca.pos_code = pos.pos_code', 'left');
        // $builder->join('hrmlevel lev', 'ca.level_code = lev.level_code', 'left');
        // $builder->groupBy('emp.emp_id');

        $builder = $db->table('hrmleave lv'); // Set the main table with alias
        $builder->select('lv.*, emp.full_name as req_for_name,  aprvSts.status_name');
        // Joins
        $builder->join('hrmemployee emp', 'lv.req_for = emp.emp_id');
        $builder->join('hrmposition pos', 'emp.pos_code = pos.pos_code');
        $builder->join('hrmlevel lev', 'emp.level_code = lev.level_code');
        //$builder->join('hrmemployee reqUser', 'lv.req_user = reqUser.emp_id');
        $builder->join('hrmapprovalstatus aprvSts', 'lv.req_status = aprvSts.status_code');

        if($session['userLevelOrder'] != 4){
            // $builder->where('req_for', $session['userEmpId']);
            // $builder->orWhere('req_user', $session['userEmpId']);
            // $builder->where('parent_code', $session['userPosCode']);
        }else if($session['userLevelOrder'] == 1){
            $builder->where('req_user', $session['userEmpId']);
            $builder->orWhere('req_for', $session['userEmpId']);
        }

        $query = $builder->get();
        $data['result'] = $query->getResultArray();
        return view('Leave/request', $data);
    }

    public function requestAdd(): string
    {
        $session = session()->get('data');
        $db = db_connect();

        // Subquery for latest career per employee
        $subquery = "
            SELECT c1.*
            FROM hrmcareer c1
            JOIN (
                SELECT emp_id, MAX(effective_date) AS latest_date
                FROM hrmcareer
                GROUP BY emp_id
            ) c2 ON c1.emp_id = c2.emp_id 
                AND c1.effective_date = c2.latest_date
        ";

        // Main builder
        $builder = $db->table("($subquery) data");

        $builder->select('data.*, emp.*, pos.pos_code, pos.pos_name, lev.level_code, lev.level_name, pos.parent_code');
        $builder->join('hrmemployee emp', 'data.emp_id = emp.emp_id');
        $builder->join('hrmposition pos', 'data.pos_code = pos.pos_code', 'left');
        $builder->join('hrmlevel lev', 'data.level_code = lev.level_code', 'left');

        $builder->where('lev.level_order <=', $session['userLevelOrder']);
        if($session['userLevelOrder'] == 1){
            $builder->where('data.emp_id', $session['userEmpId']);
        }
        else if($session['userLevelOrder'] != 4){
            $builder->where('data.pos_code', $session['userPosCode']);
            $builder->orWhere('pos.parent_code', $session['userPosCode']);
        }

        $query = $builder->get();
        $data['query'] = $query;
        return view('Leave/requestAdd', $data);
    }

    public function requestSubmit(): string
    {
        $session = session()->get('data');

        $newLeaveCode = 'LVR' . date('Ymdhis');
        $newReqFor = $_POST['reqFor'];
        $newLeaveStartDate = $_POST['leaveStartDate'];
        $newLeaveEndDate = $_POST['leaveEndDate'];
        $newReqUser = $session['userEmpId'];
        $newReqDate = date('Y-m-d');

        $date1 = new \DateTime($newLeaveStartDate);
        $date2 = new \DateTime($newLeaveEndDate);

        $diff = $date1->diff($date2);
        $useBalance = $diff->days + 1; 

        $newReqStatus = 1; 
        if($session['userLevelOrder'] == 4){
            $newReqStatus = 3; 
        }
        else if($newReqFor != $newReqUser){
            $newReqStatus = 2; 
        }
        $newReason = $_POST['reason'];


        $newData = [
            'leave_code' => $newLeaveCode,
            'req_for' => $newReqFor,
            'leave_startdate' => $newLeaveStartDate,
            'leave_enddate' => $newLeaveEndDate,
            'req_user' => $newReqUser,
            'req_date' => $newReqDate,
            'req_status' => $newReqStatus,
            'reason' => $newReason,
        ];


        $db = db_connect();
        $builder = $db->table('hrmleave');
        $builder->set($newData);
        $query1 = $builder->insert();

        // update leave balance
        if($newReqStatus == 3){
            $builder = $db->table('hrmleavebalance');
            $builder->where('year', date('Y'));
            $builder->where('active_status', 1);
            $builder->where('emp_id', $newReqFor);
            $query2 = $builder->get();
            $dataBalance = $query2->getResultArray()[0];

            $builder = $db->table('hrmleavebalance');
            $builder->set([
                'balance_value' => intval($dataBalance['balance_value']) - intval($useBalance),
            ]);
            $builder->where('year', date('Y'));
            $builder->where('active_status', 1);
            $builder->where('emp_id', $newReqFor);
            $query3 = $builder->update();

            if($query3){
                echo "<script>alert('success add request')</script>";
            }else{
                echo "<script>alert('failed add request')</script>";
            }
        }

        if($query1){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->request();

    }


    public function requestEdit($leaveCode): string
    {
        $session = session()->get('data');
        $db = db_connect();

        // Subquery for latest career per employee
        $subquery = "
            SELECT c1.*
            FROM hrmcareer c1
            JOIN (
                SELECT emp_id, MAX(effective_date) AS latest_date
                FROM hrmcareer
                GROUP BY emp_id
            ) c2 ON c1.emp_id = c2.emp_id 
                AND c1.effective_date = c2.latest_date
        ";

        // Main builder
        $builder = $db->table("($subquery) data");

        $builder->select('data.*, emp.*, pos.pos_code, pos.pos_name, lev.level_code, lev.level_name, pos.parent_code');
        $builder->join('hrmemployee emp', 'data.emp_id = emp.emp_id');
        $builder->join('hrmposition pos', 'data.pos_code = pos.pos_code', 'left');
        $builder->join('hrmlevel lev', 'data.level_code = lev.level_code', 'left');

        $builder->where('lev.level_order <=', $session['userLevelOrder']);
        if($session['userLevelOrder'] == 1){
            $builder->where('data.emp_id', $session['userEmpId']);
        }
        else if($session['userLevelOrder'] != 4){
            $builder->where('data.pos_code', $session['userPosCode']);
            $builder->orWhere('pos.parent_code', $session['userPosCode']);
        }

        $query = $builder->get();
        $data['allEmp'] = $query;

        $builder = $db->table("hrmleave lv");
        $builder->select('lv.*, reqFor.full_name as req_for_name, reqUser.full_name as req_user_name, aprvSts.status_name, lvbal.balance_value');
        $builder->join('hrmemployee reqFor', 'lv.req_for = reqFor.emp_id', 'left');
        $builder->join('hrmemployee reqUser', 'lv.req_user = reqUser.emp_id', 'left');
        $builder->join('hrmapprovalstatus aprvSts', 'lv.req_status = aprvSts.status_code', 'left');
        $builder->join('hrmleavebalance lvbal', 'lv.req_for = lvbal.emp_id', 'left');
        $builder->where('lvbal.year', date('Y'));
        $builder->where('lvbal.active_status', 1);
        if($session['userLevelOrder'] != 4){
            $builder->where('lv.req_for', $session['userEmpId']);
            $builder->orWhere('lv.req_user', $session['userEmpId']);
        }
        $builder->where('lv.leave_code', $leaveCode);
        $query = $builder->get();
        $data['result'] = $query;
        $data['leaveCode'] = $leaveCode;
        return view('Leave/requestEdit', $data);
    }

    public function requestRevise(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmleave');

        $leaveCode = $_POST['leaveCode'];
        $reqFor = $this->request->getPost('reqFor');
        $reqUser = $session['userEmpId'];
        $newReasonRevise = $_POST['reasonRevise'];

        $builder->set([
            'req_status' => 4,
            'reason_revise' => $newReasonRevise,
        ]);

        $builder->where('leave_code', $leaveCode);
        $builder->where('req_for', $reqFor);
        $builder->where('req_user', $reqUser);
        $query = $builder->update();

        if($query){
            echo "<script>alert('success update revised')</script>";
        }else{
            echo "<script>alert('failed update revised')</script>";
        }
        return $this->request();

    }





    // API
    public function getBalance()
    {
        $session = session()->get('data');
        $empId = $_POST['selectedEmpId'];

        $db = db_connect();

        $builder = $db->table('hrmleavebalance'); 
        $builder->where('emp_id', $empId);
        $builder->where('year', date('Y'));
        $builder->where('active_status', 1);
        $query = $builder->get();
        $balanceValue = 0;
        if($query->getResultArray()){
            $balanceValue = $query->getResultArray()[0]['balance_value']; 
        }
        $result = [
            'balance_value' => $balanceValue
        ];
        return json_encode($result); 
    }
}