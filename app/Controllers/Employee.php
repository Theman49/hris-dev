<?php

namespace App\Controllers;

class Employee extends BaseController
{
    public function information(): string
    {
        $session = session()->get('data');
        $db = db_connect();
        $builder = $db->table('hrmemployee');
        $builder->join('hrmposition', 'hrmemployee.pos_code = hrmposition.pos_code', 'left');
        $builder->join('hrmlevel', 'hrmemployee.level_code = hrmlevel.level_code', 'left');
        $builder->where('hrmlevel.level_order <=', $session['userLevelOrder']);
        $query = $builder->get();
        $data['query'] = $query;
        return view('Employee/information', $data);
    }
}
