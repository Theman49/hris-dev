<?php

namespace App\Controllers;

class Recruitment extends BaseController
{
    public function request(): string
    {
        $session = session()->get('data');
        $empId = $session['userEmpId'];
        $db = db_connect();
        $builder = $db->table('hrmrecruitmentreq');
        $builder->where('hrmrecruitmentreq.req_empid', $empId);
        $builder->join('hrmemployee', 'hrmrecruitmentreq.req_empid = hrmemployee.emp_id', 'left');
        $builder->join('hrmposition', 'hrmrecruitmentreq.pos_code = hrmposition.pos_code', 'left');
        $builder->join('hrmlevel', 'hrmrecruitmentreq.level_code = hrmlevel.level_code', 'left');
        $builder->join('hrmapprovalstatus', 'hrmrecruitmentreq.req_status = hrmapprovalstatus.status_code', 'left');

        $query = $builder->get();
        $data['query'] = $query;
        return view('Recruitment/request', $data);
    }
    public function requestAdd(): string
    {
        $db = db_connect();
        $builder = $db->table('hrmposition');
        $query = $builder->get();
        $data['posAll'] = $query;
        $builder = $db->table('hrmlevel');
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

    public function applicant(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmapplicant');
        $builder->join('hrmrecruitmentreq', 'hrmapplicant.rec_code = hrmrecruitmentreq.req_code', 'left');
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
        $data['recCodeAll'] = $query;
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
}
