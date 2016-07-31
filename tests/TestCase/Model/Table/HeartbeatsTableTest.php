<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HeartbeatsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HeartbeatsTable Test Case
 */
class HeartbeatsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HeartbeatsTable
     */
    public $Heartbeats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.heartbeats',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Heartbeats') ? [] : ['className' => 'App\Model\Table\HeartbeatsTable'];
        $this->Heartbeats = TableRegistry::get('Heartbeats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Heartbeats);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
