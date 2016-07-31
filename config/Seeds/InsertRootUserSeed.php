<?php
use Phinx\Seed\AbstractSeed;

/**
 * InserRootAdmin seed.
 */
class InsertRootUserSeed extends AbstractSeed
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
                'name' => 'Bogdan Boamfa',
                'email' => 'bogdan.boamfa@gmail.com',
                'username' => 'bogdanboamfa',
                'password' => (new \Cake\Auth\DefaultPasswordHasher)->hash('bogdan'),
                'role' => 'doctor',
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
