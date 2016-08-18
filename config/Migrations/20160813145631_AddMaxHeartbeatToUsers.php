<?php
use Migrations\AbstractMigration;

class AddMaxHeartbeatToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('alert_value', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => null,
        ]);
        $table->update();
    }
}
