<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Heartbeats Controller
 *
 * @property \App\Model\Table\HeartbeatsTable $Heartbeats
 */
class HeartbeatsController extends AppController
{
    private $authUser = null;

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->deny();
        $this->loadModel('Users');

        $token = $this->request->header("X-Authorization");

        $user = $this->Users->findByAuthkey($token)->toArray();
        if (count($user) == 1) {
            $this->Auth->allow(['add']);
            $user = $user[0];
            $this->authUser = clone $user;
        }

    }

    /**
     * Index method
     *
     * @param null $user_id
     * @return \Cake\Network\Response|null
     */
    public function index($user_id = null)
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $user = $this->Auth->user();
        if ($user['role'] == 'patient') {
            $heartbeats = $this->Heartbeats->find()->where(['user_id' => $user['id']]);
        } else {
            $heartbeats = $this->Heartbeats->find()->where(['user_id' => $user_id]);;
        }
//        $heartbeats = $this->paginate($heartbeats);
        if ($this->request->query['callback']) {
            $date = date('Y-m-d');
            if (!empty($this->request->query['period'])) {
                switch ($this->request->query['period']) {
                    case 'day':
                        $date = date('Y-m-d');
                        break;
                    case 'month':
                        $date = date('Y-m-01');
                        break;
                    case 'year':
                        $date = date('Y-01-01');
                        break;
                }
            }
            $heartbeats = $heartbeats->where(['DATE(created) >=' => $date]);
            $json = [];
            foreach ($heartbeats as $heartbeat) {
                $month = ((int) $heartbeat->created->format('n'))-1;
                $month = $month < 10 ? '0'.$month : $month;
                $date = '[Date.UTC(' . $heartbeat->created->format('Y, '.$month.', d, H, i, s') . "), $heartbeat->value]";
                $json[] = $date;
            }
            $heartbeats = $this->request->query['callback'] . '([' . implode(',', $json) . ']);';
            $this->response->type('text/javascript');
            $this->autoRender = false;
            echo $heartbeats;
        } else {
            $this->set(compact('heartbeats'));
            $this->set('_serialize', ['heartbeats']);
        }   
    }

    /**
     * View method
     *
     * @param string|null $id Heartbeat id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $heartbeat = $this->Heartbeats->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('heartbeat', $heartbeat);
        $this->set('_serialize', ['heartbeat']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $heartbeat = $this->Heartbeats->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['user_id'] = $this->authUser['id'];
            $heartbeat = $this->Heartbeats->patchEntity($heartbeat, $data);
            if ($this->Heartbeats->save($heartbeat)) {
                if (!$this->request->is('json')) {
                    $this->Flash->success(__('The heartbeat has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }

            } else {
                $this->Flash->error(__('The heartbeat could not be saved. Please, try again.'));
            }
        }
        $users = $this->Heartbeats->Users->find('list', ['limit' => 200]);
        $this->set(compact('heartbeat', 'users'));
        $this->set('_serialize', ['heartbeat']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Heartbeat id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $heartbeat = $this->Heartbeats->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $heartbeat = $this->Heartbeats->patchEntity($heartbeat, $this->request->data);
            if ($this->Heartbeats->save($heartbeat)) {
                $this->Flash->success(__('The heartbeat has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The heartbeat could not be saved. Please, try again.'));
            }
        }
        $users = $this->Heartbeats->Users->find('list', ['limit' => 200]);
        $this->set(compact('heartbeat', 'users'));
        $this->set('_serialize', ['heartbeat']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Heartbeat id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $heartbeat = $this->Heartbeats->get($id);
        if ($this->Heartbeats->delete($heartbeat)) {
            $this->Flash->success(__('The heartbeat has been deleted.'));
        } else {
            $this->Flash->error(__('The heartbeat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        return parent::isAuthorized($user);
    }
}
