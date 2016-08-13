<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 09/08/16
 * Time: 21:41
 */

namespace App\Auth;

use Cake\Auth\FormAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;

class TokenAuthenticate extends FormAuthenticate
{
    public function authenticate(Request $request, Response $response)
    {
        return parent::authenticate($request, $response);
    }

    public function getUser(Request $request)
    {
        $this->Users = TableRegistry::get('Users');

        $token = $request->header('X-Authorization');
        if (!$token) {
            return true;
        }

        $users = $this->Users->findByAuthkey($token)->toArray();
        if (count($users) != 1) {
            return false;
        }
        $user = $users[0];

        return $user->toArray();
    }
}