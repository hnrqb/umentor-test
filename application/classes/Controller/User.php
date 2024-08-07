<?php

class Controller_User extends Controller {

    public function action_index() {

        $users = ORM::factory('user')->find_all();
        $this->response->body(View::factory('user/index')->set('users', $users));
    }

    public function action_get() {

        $user_id = $this->request->query('id');
        $user = ORM::factory('user', $user_id);

        $this->response->body(json_encode($user->as_array()));        
    }

    public function action_create() {

        if ($this->request->method() === Request::POST) {

            try {

                $user = ORM::factory('user');
                $user->values($this->request->post());
                $user->save();
                $this->response->body(json_encode(['success' => true]));

            } catch (Exception $e) {
                $this->response->body(json_encode(['error' => $e->getMessage()]));
            }
        } else {
            $this->response->body(View::factory('user/create'));
        }
    }

    public function action_list() {

        $name = $this->request->query('search_name');
        $email = $this->request->query('search_email');
        $status = $this->request->query('search_status');
        $admission_date = $this->request->query('search_admission_date');
        $created_at = $this->request->query('search_created_at');
        $updated_at = $this->request->query('search_updated_at');
    
        $query = ORM::factory('user');
    
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
    
        if ($email) {
            $query->where('email', 'LIKE', '%' . $email . '%');
        }
    
        if ($status) {
            $query->where('status', 'LIKE', '%' . $status . '%');
        }
    
        if ($admission_date) {
            $query->where('admission_date', '=', $admission_date);
        }
    
        $users = $query->find_all();
        $this->response->body(View::factory('user/list')->set('users', $users));
    }

    public function action_update() {

        if ($this->request->method() === Request::POST) {

            try {

                $user = ORM::factory('user', $this->request->post('id'));

                if ($user->loaded()) {
                    $user->name = $this->request->post('name');
                    $user->email = $this->request->post('email');
                    $user->status = $this->request->post('status');
                    $user->admission_date = $this->request->post('admission_date');
                    $user->updated_at = date('Y-m-d H:i:s');
                    $user->save();
                    $this->response->body(json_encode(['success' => true]));

                } else {
                    $this->response->body(json_encode(['error' => 'Usuário não encontrado.']));
                }
            } catch (Exception $e) {
                $this->response->body(json_encode(['error' => $e->getMessage()]));
            }
        }
    }
    
    public function action_delete() {

        if ($this->request->method() === Request::POST) {

            try {

                $user = ORM::factory('user', $this->request->post('id'));

                if ($user->loaded()) {

                    $user->delete();
                    $this->response->body(json_encode(['success' => true]));

                } else {
                    $this->response->body(json_encode(['error' => 'Usuário não encontrado.']));
                }
            } catch (Exception $e) {
                $this->response->body(json_encode(['error' => $e->getMessage()]));
            }
        }
    }
}
