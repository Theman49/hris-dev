<?php

namespace App\Controllers;

class Leave extends BaseController
{
    public function request(): string
    {
        $session = session()->get('data');
        $db = db_connect();


        // Build reusable subquery
        $subQuery = $db->table('hrmemployee a')
            ->select('a.emp_id')
            ->join('hrmposition b', 'a.pos_code = b.pos_code')
            ->join('hrmlevel c', 'a.level_code = c.level_code')
            ->groupStart()
                ->where('c.level_order <=', $session['userLevelOrder'])
                ->orWhere('a.pos_code', $session['userPosCode'])
                ->orWhere('b.parent_code', $session['userPosCode'])
            ->groupEnd()
            ->getCompiledSelect();
        if($session['userLevelOrder'] == 1){
            $subQuery = $db->table('hrmemployee a')
                ->select('a.emp_id')
                ->join('hrmposition b', 'a.pos_code = b.pos_code')
                ->join('hrmlevel c', 'a.level_code = c.level_code')
                ->where('a.emp_id', $session['userEmpId'])
                ->getCompiledSelect();
        }

        // Build main query
        $query = $db->table('hrmleave d')
            ->select('d.*, reqfor.full_name as req_for_name, req.full_name as req_user_name, e.status_name')
            ->join('hrmapprovalstatus e', 'd.req_status = e.status_code')
            ->join('hrmemployee req', 'd.req_user = req.emp_id')
            ->join('hrmemployee reqfor', 'd.req_for = reqfor.emp_id')
            ->where("req_for IN ($subQuery)")
            ->orWhere("req_user IN ($subQuery)")
            ->get();



        // if($session['userLevelOrder'] != 4){
        //     // $builder->where('req_for', $session['userEmpId']);
        //     // $builder->orWhere('req_user', $session['userEmpId']);
        //     // $builder->where('parent_code', $session['userPosCode']);
        // }else if($session['userLevelOrder'] == 1){
        //     $builder->where('req_user', $session['userEmpId']);
        //     $builder->orWhere('req_for', $session['userEmpId']);
        // }

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

    public function requestSubmit()
    {
        $session = session()->get('data');

        $newLeaveCode = 'LVR' . date('Ymdhis');
        $newReqFor = $_POST['reqFor'];
        $newLeaveStartDate = $_POST['leaveStartDate'];
        $newLeaveEndDate = $_POST['leaveEndDate'];
        $newReqUser = $session['userEmpId'];
        $newReqDate = date('Y-m-d');
        $newReason = $_POST['reason'];
        $newReqForSick = $_POST['reqForSick'];


        // check if req date has exist
        $checkIsExist = $this->checkIsExist($newReqFor, $newLeaveStartDate, $newLeaveEndDate);

        if($checkIsExist){
            return redirect()->to('/leave/request/add')
                    ->withInput()
                    ->with('error', 'request date has been existed');
        }

        // $date1 = new \DateTime($newLeaveStartDate);
        // $date2 = new \DateTime($newLeaveEndDate);

        // $diff = $date1->diff($date2);
        // $useBalance = $diff->days + 1; 
        $useBalance = $this->countUseBalance($newLeaveStartDate, $newLeaveEndDate);

        // when req for sick, not deduct
        // and save attachment
        $newAttachment = '';
        if($newReqForSick == 1){
            $useBalance = 0;

            $file = $this->request->getFile('attachment');


            // Move file to writable/uploads
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $newAttachment = $newName;
        }

        $newReqStatus = 1; 
        if($session['userLevelOrder'] == 4){
            $newReqStatus = 3; 
        }
        else if($newReqFor != $newReqUser){
            $newReqStatus = 2; 
        }


        $newData = [
            'leave_code' => $newLeaveCode,
            'req_for' => $newReqFor,
            'leave_startdate' => $newLeaveStartDate,
            'leave_enddate' => $newLeaveEndDate,
            'req_user' => $newReqUser,
            'req_date' => $newReqDate,
            'req_status' => $newReqStatus,
            'reason' => $newReason,
            'is_sick_leave' => $newReqForSick,
            'attachment' => $newAttachment,
        ];


        $db = db_connect();
        $builder = $db->table('hrmleave');
        $builder->set($newData);
        $query1 = $builder->insert();

        // update leave balance
        if($newReqStatus == 3){
            $builder = $db->table('hrmleavebalance');
            $builder->where('start_period <=', date('Y-m-d'));
            $builder->where('end_period >=', date('Y-m-d'));
            $builder->where('active_status', 1);
            $builder->where('emp_id', $newReqFor);
            $query2 = $builder->get();
            $dataBalance = $query2->getResultArray()[0];

            $builder = $db->table('hrmleavebalance');
            $builder->set([
                'balance_value' => intval($dataBalance['balance_value']) - intval($useBalance),
            ]);
            $builder->where('start_period <=', date('Y-m-d'));
            $builder->where('end_period >=', date('Y-m-d'));
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

         // Build reusable subquery
        $builder = $db->table('hrmemployee a')
            ->select('a.*, b.pos_name, c.level_name')
            ->join('hrmposition b', 'a.pos_code = b.pos_code')
            ->join('hrmlevel c', 'a.level_code = c.level_code')
            ->groupStart()
                ->where('c.level_order <=', $session['userLevelOrder'])
                ->orWhere('a.pos_code', $session['userPosCode'])
                ->orWhere('b.parent_code', $session['userPosCode'])
            ->groupEnd();

        if($session['userLevelOrder'] == 1){
            $builder = $db->table('hrmemployee a')
                ->select('a.*, b.pos_name, c.level_name')
                ->join('hrmposition b', 'a.pos_code = b.pos_code')
                ->join('hrmlevel c', 'a.level_code = c.level_code')
                ->where('a.emp_id', $session['userEmpId']);
        }


        $query = $builder->get();
        $data['allEmp'] = $query;

        // $builder = $db->table("hrmleave lv");
        // $builder->select('lv.*, reqFor.full_name as req_for_name, reqUser.full_name as req_user_name, aprvSts.status_name, lvbal.balance_value');
        // $builder->join('hrmemployee reqFor', 'lv.req_for = reqFor.emp_id', 'left');
        // $builder->join('hrmemployee reqUser', 'lv.req_user = reqUser.emp_id', 'left');
        // $builder->join('hrmapprovalstatus aprvSts', 'lv.req_status = aprvSts.status_code', 'left');
        // $builder->join('hrmleavebalance lvbal', 'lv.req_for = lvbal.emp_id', 'left');
        // $builder->where('lvbal.year', date('Y'));
        // $builder->where('lvbal.active_status', 1);
        // if($session['userLevelOrder'] != 4){
        //     $builder->where('lv.req_for', $session['userEmpId']);
        //     $builder->orWhere('lv.req_user', $session['userEmpId']);
        // }
        // $builder->where('lv.leave_code', $leaveCode);

         // Build main query
        $builder = $db->table('hrmleave d')
            ->select('d.*, reqfor.full_name as req_for_name, req.full_name as req_user_name, e.status_name, lvbl.balance_value, reqUserLevel.level_order as req_user_level_order')
            ->join('hrmapprovalstatus e', 'd.req_status = e.status_code')
            ->join('hrmemployee req', 'd.req_user = req.emp_id')
            ->join('hrmemployee reqfor', 'd.req_for = reqfor.emp_id')
            ->join('hrmleavebalance lvbl', 'd.req_for = lvbl.emp_id')
            ->join('hrmlevel reqUserLevel', 'req.level_code = reqUserLevel.level_code')
            ->where('lvbl.start_period <=', date('Y-m-d'))
            ->where('lvbl.end_period >=', date('Y-m-d'))
            ->where('lvbl.active_status', 1)
            ->where('d.leave_code', $leaveCode);

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
        // $reqFor = $this->request->getPost('reqFor');
        // $reqUser = $session['userEmpId'];
        $newReasonRevise = $_POST['reasonRevise'];

        $builder->set([
            'req_status' => 4,
            'reason_revise' => $newReasonRevise,
        ]);

        $builder->where('leave_code', $leaveCode);
        $query = $builder->update();

        if($query){
            echo "<script>alert('success update revised')</script>";
        }else{
            echo "<script>alert('failed update revised')</script>";
        }
        return $this->request();

    }

    public function requestResubmit()
    {
        $session = session()->get('data');
        $db = db_connect();

        $leaveCode = $_POST['leaveCode'];
        $newReqFor = $_POST['reqFor'];
        $newLeaveStartDate = $_POST['leaveStartDate'];
        $newLeaveEndDate = $_POST['leaveEndDate'];
        $newReqUser = $session['userEmpId'];
        $newReqDate = date('Y-m-d');
        $newReason = $_POST['reason'];
        $newReqForSick = $_POST['reqForSick'];

        // check if req date has exist
        $checkIsExist = $this->checkIsExist($newReqFor, $newLeaveStartDate, $newLeaveEndDate);

        if($checkIsExist){
            return redirect()->to('/leave/request/edit/' . $leaveCode)
                    ->withInput()
                    ->with('error', 'request date has been existed');
        }


        $useBalance = $this->countUseBalance($newLeaveStartDate, $newLeaveEndDate);

        // get old data
        $builder = $db->table('hrmleave')
                        ->where('leave_code', $leaveCode)
                        ->get();

        $result = $builder->getResultArray()[0];

        // when req for sick, not deduct
        $newAttachment = '';
        if($newReqForSick == 1){
            $useBalance = 0;

            $file = $this->request->getFile('attachment');

            // remove old file
            $uploadPath = WRITEPATH . 'uploads/';
            $fileName   = $result['attachment'];

            // ✅ Delete old file if exists
            if (file_exists($uploadPath . $fileName)) {
                unlink($uploadPath . $fileName);
            }

            // Move file to writable/uploads
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $newAttachment = $newName;
        }

        $newReqStatus = 1; 
        if($newReqFor != $newReqUser){
            $newReqStatus = 2; 
        }


        $newData = [
            'req_for' => $newReqFor,
            'leave_startdate' => $newLeaveStartDate,
            'leave_enddate' => $newLeaveEndDate,
            'req_user' => $newReqUser,
            'req_date' => $newReqDate,
            'req_status' => $newReqStatus,
            'reason' => $newReason,
            'is_sick_leave' => $newReqForSick,
            'attachment' => $newAttachment,
        ];


        $db = db_connect();
        $builder = $db->table('hrmleave');
        $builder->where('leave_code', $leaveCode);
        $builder->set($newData);
        $query = $builder->update();


        if($query){
            echo "<script>alert('success resubmit request')</script>";
        }else{
            echo "<script>alert('failed resubmit request')</script>";
        }

        return $this->request();
    }

    public function requestApprove(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmleave');

        $leaveCode = $_POST['leaveCode'];
        $reqFor = $_POST['reqForHidden'];
        $newLeaveStartDate = $_POST['leaveStartDate'];
        $newLeaveEndDate = $_POST['leaveEndDate'];
        $newReqForSick = $_POST['reqForSick'];

        
        $useBalance = $this->countUseBalance($newLeaveStartDate, $newLeaveEndDate);

        // when req for sick, not deduct
        if($newReqForSick == 1){
            $useBalance = 0;
        }

        $newReqStatus = 2; 
        if($session['userLevelOrder'] == 4){
            $newReqStatus = 3; 
        }

        $newData = [
            'req_status' => $newReqStatus,
            'modified_date' => date('Y-m-d'),
            'modified_user' => $session['userEmpId']
        ];

        if($newReqStatus == 3){
            $newData['approved_date'] = date('Y-m-d');
        }

        $builder->set($newData);

        $builder->where('leave_code', $leaveCode);
        $query = $builder->update();

        if($query){

        // update leave balance
        if($newReqStatus == 3){
            $builder = $db->table('hrmleavebalance');
            $builder->where('start_period <=', date('Y-m-d'));
            $builder->where('end_period >=', date('Y-m-d'));
            $builder->where('active_status', 1);
            $builder->where('emp_id', $reqFor);
            $query2 = $builder->get();
            $dataBalance = $query2->getResultArray()[0];

            $builder = $db->table('hrmleavebalance');
            $builder->set([
                'balance_value' => intval($dataBalance['balance_value']) - intval($useBalance),
            ]);
            $builder->where('start_period <=', date('Y-m-d'));
            $builder->where('end_period >=', date('Y-m-d'));
            $builder->where('active_status', 1);
            $builder->where('emp_id', $reqFor);
            $query3 = $builder->update();

            if($query3){
                echo "<script>alert('success update balance')</script>";
            }else{
                echo "<script>alert('failed update balance')</script>";
            }
        }


            echo "<script>alert('success approve')</script>";
        }else{
            echo "<script>alert('failed approve')</script>";
        }
        return $this->request();

    }


    public function countUseBalance($leaveStartDate, $leaveEndDate){
        $db = db_connect();

        $builder = $db->table('hrmcompparam')
                    ->like('param_code', 'leave');
        $query = $builder->get();
        $result = $query->getResultArray();

        $isDeduct = 0;
        $listDayOff = [];

        foreach($result as $row){
            if($row['param_code'] == 'leave_deduct'){
                $isDeduct = $row['param_value'];
            }else if($row['param_code'] == 'leave_day_off'){
                $temp = $row['param_value'];
                $listDayOff = explode(',', $row['param_value']);
            }
        }

        $date1 = new \DateTime($leaveStartDate);
        $date2 = new \DateTime($leaveEndDate);

        $useBalance = 0;

        if($isDeduct == 1){
            $date2->modify('+1 day');
            while($date1 < $date2){
                 // 0 = Sunday 
                if (!in_array($date1->format('w'), $listDayOff)) {
                    $useBalance++;
                }

                $date1->modify('+1 day');
            }
        }else{
            $diff = $date1->diff($date2);
            $useBalance = $diff->days + 1; 
        }

        return $useBalance;

    }


    /// generate balance
    public function balance(): string
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
        return view('Leave/balance', $data);
    }

    public function balanceDetail($empId){
        $db = db_connect();
        $builder = $db->table('hrmleavebalance')
                        ->select("*, CASE WHEN active_status = 1 THEN 'active' WHEN active_status = 0 THEN 'inactive' END AS active_status")
                        ->where('emp_id', $empId)
                        ->get();
        $data['query'] = $builder; 
        $data['targetEmpId'] = $empId;
        return view('Leave/balanceDetail', $data);
    }

    public function generateBalance(){

        $empId = $_POST['empId'];
        $db = db_connect();

        // get last career
        $builder = $db->table('hrmcareer')
                        ->where('emp_id', $empId)
                        ->orderBy('end_date DESC, effective_date DESC')
                        ->limit(1)
                        ->get();
        $data = $builder->getResultArray()[0];
        // get end_date if set, if not get effective_date last career
        $getDate = $data['end_date'];
        if($getDate == ''){
            $getDate = $data['effective_date']; 
        }

        $getDate = new \DateTime($getDate)->modify('+1 day')->format('Y-m-d');
        $newEndPeriod = new \DateTime($getDate)->modify('+12 month')->format('Y-m-d');

        // set inactive or 0 for old balance

        $builder = $db->table('hrmleavebalance');

        $builder->set([
            'active_status' => 0
        ]);
        $builder->where('emp_id', $empId)
                ->groupStart()
                    ->where('end_period <=', $getDate)
                    ->orWhere('start_period <=', $getDate)
                ->groupEnd()
                ->update();

        // generate balance for 1 next year

        $builder = $db->table('hrmleavebalance');
        $builder->set([
            'leavebalance_id' => 'LVL' . date('Ymdhis'),
            'emp_id' => $empId,
            'balance_value' => '12',
            'start_period' => $getDate,
            'end_period' => $newEndPeriod,
            'active_status' => 1
        ]);
        $query = $builder->insert();
        if($query){
            echo "<script>alert('success generate new balance')</script>";
        }else{
            echo "<script>alert('failed generate new balance')</script>";
        }

        return $this->balance();
    }






    // API
    public function getBalance()
    {
        $session = session()->get('data');
        $empId = $_POST['selectedEmpId'];

        $db = db_connect();

        $builder = $db->table('hrmleavebalance'); 
        $builder->where('emp_id', $empId);
        $builder->where('start_period <=', date('Y-m-d'));
        $builder->where('end_period >=', date('Y-m-d'));
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


    public function getLeaveSetting()
    {
        $db = db_connect();

        $builder = $db->table('hrmcompparam');
        $builder->like('param_code', 'leave');
        $query = $builder->get();

        $result = [];
        if($query->getResultArray()){
            $result = $query->getResultArray(); 
        }

        return json_encode($result);
    }

    public function showAttachment($filename)
    {
        $path = WRITEPATH . 'uploads/' . $filename;

        if (!is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setBody(file_get_contents($path));
    }

    public function checkIsExist($empId, $startDate, $endDate){
        $db = db_connect();

        $builder = $db->table('hrmleave')
                        ->where('req_for', $empId)
                        ->where('leave_startdate <=', $endDate)
                        ->where('leave_enddate >=', $startDate)
                        ->where('req_status <', 4) // check waiting, partially, finally
                        ->get();
        
        $query = $builder->getResultArray();

        if(count($query) > 0){
            return true;
        }

        return false;
    }
}