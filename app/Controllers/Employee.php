<?php

namespace App\Controllers;

class Employee extends BaseController
{
    public function information(): string
    {
        $session = session()->get('data');
        $db = db_connect();

        // $builder = $db->table('hrmemployee');
        // $builder->select('emp.*, MAX(ca.effective_date) as effective_date, max(pos.pos_code), pos.pos_name, lev.level_code, lev.level_name');
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
        if($session['userLevelOrder'] == '1'){
            $builder->where('data.emp_id', $session['userEmpId']);
        }
        else if($session['userLevelOrder'] != '4'){
            $builder->where('data.pos_code', $session['userPosCode']);
            $builder->orWhere('pos.parent_code', $session['userPosCode']);
        }
        $query = $builder->get();
        $data['query'] = $query;
        return view('Employee/information', $data);
    }
}