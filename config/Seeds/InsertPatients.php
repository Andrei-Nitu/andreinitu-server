<?php
use Phinx\Seed\AbstractSeed;

/**
 * InserRootAdmin seed.
 */
class InsertPatients extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Patient 1',
                'email' => 'patient1@p.com',
                'username' => 'patient1',
                'password' => (new \Cake\Auth\DefaultPasswordHasher)->hash('patient'),
                'role' => 'patient',
                'birthday' => date('Y-m-d'),
                'address' => '',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Patient 2',
                'email' => 'patient2@p.com',
                'username' => 'patient2',
                'password' => (new \Cake\Auth\DefaultPasswordHasher)->hash('patient'),
                'role' => 'patient',
                'birthday' => date('Y-m-d'),
                'address' => '',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Patient 3',
                'email' => 'patient3@p.com',
                'username' => 'patient3',
                'password' => (new \Cake\Auth\DefaultPasswordHasher)->hash('patient'),
                'role' => 'patient',
                'birthday' => date('Y-m-d'),
                'address' => '',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
