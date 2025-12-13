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
    public function positionInsert(): string
    {
        $newPosCode = $_POST['posCode'];
        $newPosName = $_POST['posName'];
        $newParentCode = $_POST['parentCode'];
        $newPosDesc = $_POST['posDesc'];
        $db = db_connect();
        $builder = $db->table('hrmposition');
        $builder->set([
            'pos_code' => $newPosCode,
            'pos_name' => $newPosName,
            'parent_code' => $newParentCode,
            'pos_desc' => $newPosDesc,
        ]);
        $query = $builder->insert();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->position();
    }
    public function positionUpdate(): string
    {
        $posCode = $_POST['posCode'];
        $newPosName = $_POST['posName'];
        $newParentCode = $_POST['parentCode'];
        $newPosDesc = $_POST['posDesc'];
        $db = db_connect();
        $builder = $db->table('hrmposition');
        $builder->set([
            'pos_name' => $newPosName,
            'parent_code' => $newParentCode,
            'pos_desc' => $newPosDesc,
        ]);
        $builder->where('pos_code', $posCode);
        $query = $builder->update();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->position();
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
    public function positionRemove(): string
    {
        $db = db_connect();
        $builder = $db->table('hrmposition');
        $builder->where('pos_code', $_POST['posCode']);
        $query = $builder->delete();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->position();
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
    public function levelInsert(): string
    {
        $newLevelName = $_POST['levelName'];
        $newLevelCode = $_POST['levelCode'];
        $newLevelOrder = $_POST['levelOrder'];
        $db = db_connect();
        $builder = $db->table('hrmlevel');
        $builder->set([
            'level_code' => $newLevelCode,
            'level_name' => $newLevelName,
            'level_order' => $newLevelOrder,
        ]);
        $query = $builder->insert();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->level();
    }
    public function levelEdit($code): string
    {
        $db = db_connect();
        $query = $db->query("select * from hrmlevel where level_code='" . $code . "'");
        $data['query'] = $query;
        return view('Setting/levelEdit', $data);
    }
    public function levelUpdate(): string
    {
        $newLevelName = $_POST['levelName'];
        $newLevelOrder = $_POST['levelOrder'];
        $db = db_connect();
        $builder = $db->table('hrmlevel');
        $builder->set([
            'level_name' => $newLevelName,
            'level_order' => $newLevelOrder,
        ]);
        $builder->where('level_code', $_POST['levelCode']);
        $query = $builder->update();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->level();
    }
    public function levelRemove(): string
    {
        $db = db_connect();
        $builder = $db->table('hrmlevel');
        $builder->where('level_code', $_POST['levelCode']);
        $query = $builder->delete();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->level();
    }

    public function company(): string
    {
        $db = db_connect();
        $builder = $db->table('hrmcompparam')->get();
        $data['query'] = $builder;
        return view('Setting/company', $data);
    }
    public function companyEdit($code): string
    {
        $db = db_connect();
        $query = $db->query("select * from hrmcompparam where param_code='" . $code . "'");
        $data['query'] = $query;
        return view('Setting/companyEdit', $data);
    }
    public function companyUpdate(): string
    {
        $paramCode = $_POST['paramCode'];
        $newParamValue = $_POST['paramValue'];
        $db = db_connect();
        $builder = $db->table('hrmcompparam');
        $builder->set([
            'param_value' => $newParamValue,
        ]);
        $builder->where('param_code', $paramCode);
        $query = $builder->update();
        if($query){
            echo "<script>alert('success')</script>";
        }else{
            echo "<script>alert('failed')</script>";
        }
        return $this->company();
    }
}
