<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Histories Controller
 *
 * @property \App\Model\Table\HistoriesTable $Histories
 */
class HistoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $histories = $this->paginate($this->Histories);

        $this->set(compact('histories'));
        $this->set('_serialize', ['histories']);
    }

    /**
     * View method
     *
     * @param string|null $id History id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $history = $this->Histories->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('history', $history);
        $this->set('_serialize', ['history']);
    }

    /**
     * Add method
     *
     * @param null $user_id
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($user_id=null)
    {
        if ($user_id == null)  {
            $user = $this->Auth->user();
            $user_id = $user['id'];
        }
        $history = $this->Histories->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['user_id'] = $user_id;
            $history = $this->Histories->patchEntity($history, $data);
            if ($this->Histories->save($history)) {
                $this->Flash->success(__('The history has been saved.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'view', $user_id]);
            } else {
                $this->Flash->error(__('The history could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('history'));
        $this->set('_serialize', ['history']);
    }

    /**
     * Edit method
     *
     * @param string|null $id History id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $history = $this->Histories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $history = $this->Histories->patchEntity($history, $this->request->data);
            if ($this->Histories->save($history)) {
                $this->Flash->success(__('The history has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The history could not be saved. Please, try again.'));
            }
        }
        $users = $this->Histories->Users->find('list', ['limit' => 200]);
        $this->set(compact('history', 'users'));
        $this->set('_serialize', ['history']);
    }

    /**
     * Delete method
     *
     * @param string|null $id History id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $history = $this->Histories->get($id);
        if ($this->Histories->delete($history)) {
            $this->Flash->success(__('The history has been deleted.'));
        } else {
            $this->Flash->error(__('The history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
