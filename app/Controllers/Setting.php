<?php

namespace App\Controllers;

class Setting extends BaseController
{
    public function position(): string
    {

        $db = db_connect();
        $query = $db->query('select * from hrmposition');
        $data['query'] = $query;
        return view('Setting/position', $data);
    }
    public function positionAdd(): string
    {
        $db = db_connect();
        $query = $db->query('select pos_code, pos_name from hrmposition');
        $data['query'] = $query;
        return view('Setting/positionAdd', $data);
    }
    public function positionEdit($code): string
    {
        $db = db_connect();
        $query = $db->query("select * from hrmposition where pos_code='" . $code . "'");
        $query2 = $db->query('select pos_code, pos_name from hrmposition');
        $data['query'] = $query;
        $data['query2'] = $query2;
        return view('Setting/positionEdit', $data);
    }

    public function level(): string
    {
        $db = db_connect();
        $query = $db->query('select * from hrmlevel');
        $data['query'] = $query;
        return view('Setting/level', $data);
    }
    public function levelAdd(): string
    {
        return view('Setting/levelAdd');
    }
    public function levelEdit($code): string
    {
        $db = db_connect();
        $query = $db->query("select * from hrmlevel where level_code='" . $code . "'");
        $data['query'] = $query;
        return view('Setting/levelEdit', $data);
    }
}
