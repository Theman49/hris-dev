<?php

namespace App\Controllers;

class Recruitment extends BaseController
{
    public function request(): string
    {
        $session = session()->get('data');
        $empId = $session['userEmpId'];
        $userLevel = $session['userLevelOrder'];

        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        if($userLevel != 4){
            $builder->where('hrmrecruitmentreq.req_empid', $empId);
        }
        $builder->join('hrmemployee', 'hrmrecruitmentreq.req_empid = hrmemployee.emp_id', 'left');
        $builder->join('hrmposition', 'hrmrecruitmentreq.pos_code = hrmposition.pos_code', 'left');
        $builder->join('hrmlevel', 'hrmrecruitmentreq.level_code = hrmlevel.level_code', 'left');
        $builder->join('hrmapprovalstatus', 'hrmrecruitmentreq.req_status = hrmapprovalstatus.status_code', 'left');

        $query = $builder->get();
        $result = $query->getResultArray();

        $idx = 0;
        foreach($result as $row){
            $hiredCount = 0;
            $queryStr = "select count(applicant_status) as hired_count from hrmapplicant where rec_code = '" . $row['req_code'] . "' and applicant_status = 5"; 
            $tempQuery = $db->query($queryStr);
            $tempResult = $tempQuery->getResultArray()[0];
            $result[$idx]['filled_count'] = $tempResult['hired_count'] . '/' . $row['rec_count'];
            $idx+=1;
        }
        $data['result'] = $result;

        return view('Recruitment/request', $data);
    }
    public function requestAdd(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmposition');
        if($session['userLevelOrder'] < 4){
            $builder->where('pos_code', $session['userPosCode']);
            $builder->orWhere('parent_code', $session['userPosCode']);
        }
        $query = $builder->get();
        $data['posAll'] = $query;
        $builder = $db->table('hrmlevel');
        $builder->where('level_order <', $session['userLevelOrder']);
        $query = $builder->get();
        $data['levelAll'] = $query;
        return view('Recruitment/requestAdd', $data);
    }
    public function requestSubmit(): string
    {
        $session = session()->get('data');

        $newRecCount = $_POST['recCount'];
        $newPosCode = $_POST['posCode'];
        $newLevelCode = $_POST['levelCode'];
        $newJoinDate = $_POST['expectedJoinDate'];
        $newReqCode = 'REC' . date('Ymdhis');
        $newReqStatus = 1;
        $newReqEmpId = $session['userEmpId'];
        $newReqDate = date('Y-m-d');
        $newReason = $_POST['reason'];


        $newData = [
            'req_code' => $newReqCode,
            'pos_code' => $newPosCode,
            'level_code' => $newLevelCode,
            'req_status' => $newReqStatus,
            'expected_join_date' => $newJoinDate,
            'req_empid' => $newReqEmpId,
            'modified_user' => $newReqEmpId,
            'req_date' => $newReqDate,
            'modified_date' => $newReqDate,
            'rec_count' => $newRecCount,
            'reason' => $newReason,
        ];


        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        $builder->set($newData);
        $query = $builder->insert();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->request();

    }

    public function requestEdit($recCode): string
    {
        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        $builder->where('req_code', $recCode);
        $query = $builder->get();
        $data['query'] = $query;

        $builder = $db->table('hrmposition');
        $query = $builder->get();
        $data['posAll'] = $query;
        $builder = $db->table('hrmlevel');
        $query = $builder->get();
        $data['levelAll'] = $query;
        return view('Recruitment/requestEdit', $data);
    }

    public function requestRevise(): string
    {
        $reqCode = $_POST['reqCode'];
        $reasonRevise = $_POST['note'];

        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        $builder->set([
            'reason_revise' => $reasonRevise,
            'modified_user' => $session['userEmpId'],
            'modified_date' => date('Y-m-d'),
            'req_status' => 4,
        ]);
        $builder->where('req_code', $reqCode);
        $query = $builder->update();

        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('success')</script>";
        }

        return $this->request();
    }

    public function requestApprove(): string
    {
        $reqCode = $_POST['reqCode'];

        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        $builder->set([
            'modified_user' => $session['userEmpId'],
            'modified_date' => date('Y-m-d'),
            'approved_date' => date('Y-m-d'),
            'req_status' => 3,
        ]);
        $builder->where('req_code', $reqCode);
        $query = $builder->update();

        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('success')</script>";
        }

        return $this->request();
    }

    public function applicant(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmapplicant');
        $builder->join('hrmrecruitmentreq', 'hrmapplicant.rec_code = hrmrecruitmentreq.req_code', 'left');
        $builder->join('hrmapplicantstatus', 'hrmapplicant.applicant_status = hrmapplicantstatus.status_code', 'left');
        $builder->where('hrmrecruitmentreq.req_status', 3);
        $builder->where('hrmapplicant.req_empid', $session['userEmpId']);
        $query = $builder->get();
        $data['query'] = $query;
        return view('Recruitment/applicant', $data);
    }

    public function applicantAdd(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        $builder->where('hrmrecruitmentreq.req_status', 3);
        $builder->where('hrmrecruitmentreq.req_empid', $session['userEmpId']);
        $query = $builder->get();
        $result = $query->getResultArray();

        $idx = 0;
        $resultFinal = [];
        foreach($result as $row){
            $hiredCount = 0;
            $queryStr = "select count(applicant_status) as hired_count from hrmapplicant where rec_code = '" . $row['req_code'] . "' and applicant_status = 5"; 
            $tempQuery = $db->query($queryStr);
            $tempResult = $tempQuery->getResultArray()[0];
            $result[$idx]['filled_count'] = $tempResult['hired_count'] . '/' . $row['rec_count'];
            if($tempResult['hired_count'] < $row['rec_count']){
                array_push($resultFinal, $result[$idx]);
            }
            $idx+=1;
        }
        $data['result'] = $resultFinal;

        return view('Recruitment/applicantAdd', $data);
    }

    public function applicantSubmit(): string
    {
        $session = session()->get('data');

        $newRecCode = $_POST['recruitmentCode'];
        $newFullName = $_POST['fullName'];
        $newLastEducation = $_POST['lastEducation'];
        $newBirthDate = $_POST['birthDate'];
        $newSalary = $_POST['salary'];
        $newAddress = $_POST['address'];
        $newApplicantCode = 'APP' . date('Ymdhis');
        $newReqEmpId = $session['userEmpId'];

        $newData = [
            'rec_code' => $newRecCode,
            'full_name' => $newFullName,
            'last_education' => $newLastEducation,
            'birth_date' => $newBirthDate,
            'salary' => $newSalary,
            'address' => $newAddress,
            'applicant_code' => $newApplicantCode,
            'req_empid' => $newReqEmpId,
            'applicant_status' => 0
        ];

        $db = db_connect();
        $builder = $db->table('hrmapplicant');
        $builder->set($newData);
        $query = $builder->insert();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->applicant();
    }

    public function applicantEdit($appCode): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmapplicant');
        $builder->join('hrmrecruitmentreq', 'hrmapplicant.rec_code = hrmrecruitmentreq.req_code', 'left');
        $builder->join('hrmapplicantstatus', 'hrmapplicant.applicant_status = hrmapplicantstatus.status_code', 'left');
        $builder->where('hrmrecruitmentreq.req_status', 3);
        $builder->where('hrmapplicant.req_empid', $session['userEmpId']);
        $builder->where('hrmapplicant.applicant_code', $appCode);
        $query = $builder->get();
        
        $builder = $db->table('hrmapplicantstatus');
        $query2 = $builder->get();
        $data['query'] = $query;
        $data['appStatusAll'] = $query2;
        return view('Recruitment/applicantEdit', $data);
    }

    public function applicantUpdate(): string
    {
        $session = session()->get('data');

        $recruitmentCode = $_POST['recruitmentCode'];
        $applicantCode = $_POST['applicantCode'];
        $newFullName = $_POST['fullName'];
        $newLastEducation = $_POST['lastEducation'];
        $newBirthDate = $_POST['birthDate'];
        $newSalary = $_POST['salary'];
        $newAddress = $_POST['address'];
        $newReqEmpId = $session['userEmpId'];
        $newApplicantStatus = $_POST['applicantStatus'];

        $newData = [
            'applicant_code' => $applicantCode,
            'full_name' => $newFullName,
            'last_education' => $newLastEducation,
            'birth_date' => $newBirthDate,
            'salary' => $newSalary,
            'address' => $newAddress,
            'req_empid' => $newReqEmpId,
            'applicant_status' => $newApplicantStatus,
        ];

        $db = db_connect();
        $builder = $db->table('hrmapplicant');
        $builder->where('applicant_code', $applicantCode);
        $builder->set($newData);
        $query = $builder->update();

        // hired state
        if($newApplicantStatus == 5){
            // insert to hrmuser for login
            $newData = [
                'username' => $applicantCode,
                'password' => 'password1234'
            ];
            $builder = $db->table('hrmuser');
            $builder->set($newData);
            $query1 = $builder->insert();


            // max user_id
            $builder = $db->table('hrmuser');
            $builder->selectMax('user_id');
            $query = $builder->get();
            $newUserId = $query->getResultArray()[0]['user_id'];


            // data recruitment req
            $builder = $db->table('hrmrecruitmentreq');
            $builder->where('req_code', $recruitmentCode);
            $query = $builder->get();
            $recruitmentData = $query->getResultArray()[0];

            $empId = 'EMP' . date('Ymdhis');
            $careerCode = 'CAR' . date('Ymdhis');
            $leaveBalanceCode = 'LVL' . date('Ymdhis');
            // $date = new \DateTime();
            $newEffectiveDate = $_POST['effectiveJoinDate'];
            $newEndDate = new \DateTime($newEffectiveDate)->modify('+6 month')->format('Y-m-d');
            $balanceValue = 13 - intval(new \DateTime($newEffectiveDate)->format('m'));

            // insert to career
            $builder = $db->table('hrmcareer');
            $newData = [
                'career_code' => $careerCode,
                'emp_id' => $empId,
                'career_type' => 'JOIN',
                'pos_code' => $recruitmentData['pos_code'],
                'level_code' => $recruitmentData['level_code'],
                'effective_date' => $newEffectiveDate,
                'end_date' => $newEndDate,
            ];
            $builder->set($newData);
            $query2 = $builder->insert();


            // insert to employee
            $builder = $db->table('hrmemployee');
            $newData = [
                'emp_id' => $empId,
                'full_name' => $newFullName,
                'pos_code' => $recruitmentData['pos_code'],
                'level_code' => $recruitmentData['level_code'],
                'last_education' => $newLastEducation,
                'birth_date' => $newBirthDate,
                'address' => $newAddress,
                'user_id' => $newUserId,
            ];
            $builder->set($newData);
            $query3 = $builder->insert();


            // insert to balance
            $builder = $db->table('hrmleavebalance');
            $newData = [
                'leavebalance_id' => $leaveBalanceCode,
                'emp_id' => $empId,
                'balance_value' => $balanceValue,
                'year' => date('Y'),
                'active_status' => 1,
            ];
            $builder->set($newData);
            $query4 = $builder->insert();

            if($query1 && $query2 && $query3 && $query4){
                echo "<script>alert('success insert new employee')</script>";
            }else{
                echo "<script>alert('failed insert new employee')</script>";
            }
        }else{
            if($query){
                echo "<script>alert('success update')</script>";
            }else{
                echo "<script>alert('failed update')</script>";
            }
        }
        return $this->applicant();

    }
}
