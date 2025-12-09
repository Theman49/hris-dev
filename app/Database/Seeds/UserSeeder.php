<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $dataLogin = [
            [
                'user_id'    => 1,
                'username'    => 'stf',
                'password'    => 'password',
            ],
            [
                'user_id'    => 2,
                'username'    => 'spv',
                'password'    => 'password',
            ],
            [
                'user_id'    => 3,
                'username'    => 'mgr',
                'password'    => 'password',
            ],
            [
                'user_id'    => 4,
                'username'    => 'hrd',
                'password'    => 'password',
            ],
        ];

        $dataCareer = [
            [
                'career_code' => 'CAR00001',
                'emp_id' => 'EMPSTF',
                'pos_code' => 'SLS',
                'level_code' => 'STF',
                'career_type' => 'JOIN',
                'effective_date' => '2025-12-01',
            ],
            [
                'career_code' => 'CAR00002',
                'emp_id' => 'EMPSPV',
                'pos_code' => 'SLS',
                'level_code' => 'SPV',
                'career_type' => 'JOIN',
                'effective_date' => '2025-12-01',
            ],
            [
                'career_code' => 'CAR00003',
                'emp_id' => 'EMPMGR',
                'pos_code' => 'FIN',
                'level_code' => 'MGR',
                'career_type' => 'JOIN',
                'effective_date' => '2025-12-01',
            ],
            [
                'career_code' => 'CAR00004',
                'emp_id' => 'HRD',
                'pos_code' => 'HRD',
                'level_code' => 'HR',
                'career_type' => 'JOIN',
                'effective_date' => '2025-12-01',
            ],
        ];

        $dataEmp = [
            [
                'emp_id' => 'EMPSTF',
                'user_id' => 1,
                'full_name' => 'STAFF',
                'last_education' => 'S1',
                'birth_date' => '2001-01-01',
                'pos_code' => 'SLS',
                'level_code' => 'STF',
            ],
            [
                'emp_id' => 'EMPSPV',
                'user_id' => 2,
                'full_name' => 'SPV',
                'last_education' => 'S1',
                'birth_date' => '2000-01-01',
                'pos_code' => 'SLS',
                'level_code' => 'SPV',
            ],
            [
                'emp_id' => 'EMPMGR',
                'user_id' => 3,
                'full_name' => 'MGR',
                'last_education' => 'S1',
                'birth_date' => '1999-01-01',
                'pos_code' => 'FIN',
                'level_code' => 'MGR',
            ],
            [
                'emp_id' => 'HRD',
                'user_id' => 4,
                'full_name' => 'HRD',
                'last_education' => 'S1',
                'birth_date' => '1998-01-01',
                'pos_code' => 'HRD',
                'level_code' => 'HR',
            ],
        ];

        // Using Query Builder
        $this->db->table('hrmuser')->insertBatch($dataLogin);
        $this->db->table('hrmcareer')->insertBatch($dataCareer);
        $this->db->table('hrmemployee')->insertBatch($dataEmp);
    }
}