<?php
/**
 * Created by PhpStorm.
 * User: novichkov
 * Date: 16.05.17
 * Time: 16:49
 */
class reg_controller extends controller
{
    public function index()
    {
        echo 1;
        $this->view('reg' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_token":
                $user_id = $_POST['authResponse']['userID'];
                $url = 'https://graph.facebook.com/v2.9/' . $user_id . '?access_token=' . $_POST['authResponse']['accessToken'] . '&fields=email,gender,name,first_name,middle_name,birthday,location,link,locale,picture';
                $res =  json_decode(file_get_contents($url), true);
                $server_data = json_decode($_POST['server_data'], true);
                $headers = json_decode($_POST['headers'], true);
                $data = [
                    'id' => $_GET['profile_id'],
                    'email' => $res['email'],
                    'full_name' => $res['name'],
                    'gender' => $res['gender'],
                    'birthday' => $res['birthday'],
                    'location' => $res['location'],
                    'locale' => $res['locale'],
                    'link' => $res['link'],
                    'picture' => $res['picture']['data']['url'],
                    'ip_address' => $server_data['REMOTE_ADDR'],
                    'user_id' => $user_id,
                    'server_data' => $_POST['server_data'],
                    'headers' => $_POST['headers'],
                    'user_agent' => $headers['User-Agent']
                ];
                define('OH_HOST', '188.166.86.63');
                define('OH_DB', 'offers_hub');
                define('OH_USER', 'bot_user');
                define('OH_PASSWORD', '247w667^(&GHj');
                $this->model('default', 'fb_profiles', OH_DB, OH_USER, OH_PASSWORD, OH_HOST)->insert($data);

                $curl = curl_init('http://cab.hub/api/watch/');
                $headers = [];
                $headers[] = "Content-Type: application/json";
                curl_setopt($curl, CURLOPT_POST, true);
                $params = json_encode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($curl);
                exit;
                break;
        }
    }

    public function index_na_ajax()
    {
        $this->index_ajax();
    }

    public function index_na()
    {
        $this->index();
    }
}