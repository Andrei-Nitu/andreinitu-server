<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Text;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class ApiController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Api',
                'action' => 'login',
                'plugin' => null
            ],
            'loginRedirect' => [
                'controller' => 'Api',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Api',
                'action' => 'login'
            ],
            'authenticate' => [
                'Token' => [
                    'userModel' => 'Users',
                    'fields' => ['username' => 'username', 'password' => 'password']
                ]
            ],
            'storage' => 'Memory'
        ]);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function login() {
        $this->loadModel('Users');
        $user = null;

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
        }

        $this->response->header('Access-Control-Allow-Origin', '*');
        $this->response->type('application/json');
        $this->autoRender = false;

        if ($user) {
            $user_obj = $this->Users->get($user['id']);
            $user_obj->authkey = Text::uuid();
            $this->Users->save($user_obj);
            $user['authkey'] = $user_obj->authkey;
            echo json_encode($user);
        } else {
            echo json_encode(['error' => 'Provide auth info.']);
        }
    }

    public function getUser() {
        $this->response->header('Access-Control-Allow-Origin', '*');
        $this->response->type('application/json');
        $this->autoRender = false;

        $user = $this->Auth->user();

        echo json_encode($user);
    }

    public function addHeartbeat() {
        $this->loadModel('Heartbeats');
        $this->loadModel('Users');
        $this->response->header('Access-Control-Allow-Origin', '*');
        $this->response->type('application/json');
        $this->autoRender = false;

        $heartbeat = $this->Heartbeats->newEntity();
        $result = ['status' => 'error', 'error' => 'No data provided'];
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $user = $this->Auth->user();
            $data['user_id'] = $user['id'];

            $heartbeat = $this->Heartbeats->patchEntity($heartbeat, $data);

            if ($user['alert_value'] != null && $heartbeat->value > $user['alert_value'] && $user['doctor_id']) {
                $doctor = $this->Users->get($user['doctor_id']);

                $email = new Email('default');
                $email
                    ->to($doctor->email)
                    ->subject('Pacient in stare critica')
                    ->send('Pacientul '.$user['name'].' se afla in stara critica');
            }

            if ($this->Heartbeats->save($heartbeat)) {
                $result = ['status' => 'ok'];
            } else {
                $result = ['status' => 'error', 'error' => 'Cannot save heartbeat'];
            }
        }
        echo json_encode($result);
    }
}
