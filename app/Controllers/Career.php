<?php

namespace App\Controllers;

class Career extends BaseController
{
    public function transition(): string
    {
        $session = session()->get('data');
        $db = db_connect();

        // $builder = $db->table('hrmemployee emp');
        // $builder->select('emp.*, MAX(ca.effective_date) as effective_date, pos.pos_code, pos.pos_name, lev.level_code, lev.level_name');
        // $builder->join('hrmcareer ca', 'emp.emp_id = ca.emp_id');
        // $builder->join('hrmposition pos', 'ca.pos_code = pos.pos_code', 'left');
        // $builder->join('hrmlevel lev', 'ca.level_code = lev.level_code', 'left');
        // $builder->groupBy('emp.emp_id');

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
        return view('Career/transition', $data);
    }
    public function transitionDetail($empId): string
    {
        $db = db_connect();
        $builder = $db->table('hrmcareer');
        $builder->join('hrmcareertype', 'hrmcareer.career_type = hrmcareertype.careertype_code', 'left');
        $builder->join('hrmposition', 'hrmcareer.pos_code = hrmposition.pos_code', 'left');
        $builder->join('hrmlevel', 'hrmcareer.level_code = hrmlevel.level_code', 'left');
        $builder->where('emp_id', $empId);
        $query = $builder->get();
        $data['query'] = $query;
        $data['empId'] = $empId;
        return view('Career/transitionDetail', $data);
    }

    public function transitionDetailAdd($empId): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmcareertype');
        $query = $builder->get();
        $data['careerType'] = $query;
        $builder = $db->table('hrmposition');
        if($session['userLevelOrder'] < 4){
            $builder->where('pos_code', $session['userPosCode']);
            $builder->orWhere('parent_code', $session['userPosCode']);
        }
        $query = $builder->get();
        $data['position'] = $query;
        $builder = $db->table('hrmlevel');
        $builder->where('level_order <', $session['userLevelOrder']);
        $query = $builder->get();
        $data['level'] = $query;
        $data['empId'] = $empId;
        return view('Career/transitionDetailAdd', $data);
    }

    public function transitionDetailSubmit(): string
    {
        $careerCode = 'CAR' . date('Ymdhis');
        $empId = $_POST['empId'];
        $newCareerType = $_POST['careerType'];
        $newPosCode = $_POST['posCode'];
        $newLevelCode = $_POST['levelCode'];
        $newEffectiveDate = $_POST['effectiveDate'];
        $newEndDate = $_POST['endDate'];

        $newData = [
            'career_code' => $careerCode,
            'emp_id' => $empId,
            'career_type' => $newCareerType,
            'pos_code' => $newPosCode,
            'level_code' => $newLevelCode,
            'effective_date' => $newEffectiveDate,
            'end_date' => $newEndDate,
        ];

        // insert to hrmcareer
        $db = db_connect();
        $builder = $db->table('hrmcareer');
        $builder->set($newData);
        $query = $builder->insert();

        if($query){
            echo "<script>alert('success add new career')</script>";
        }else{
            echo "<script>alert('failed add new career')</script>";
        }
        return $this->transitionDetail($empId);
    }
}
