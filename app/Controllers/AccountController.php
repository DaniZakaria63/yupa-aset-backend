<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AccountModel;
use CodeIgniter\I18n\Time;

class AccountController extends BaseController
{
    private $mTime;

    public function __construct()
    {
        $this->mTime = new Time('now','Asia/Jakarta');
    }

    public function index()
    {
        # provide all account data 
        /**
         * informational things about account and access
         */

        $accountModel = new AccountModel();
        $accessModel = new AccessModel();
        
        $accData = $accountModel->findAll();
        foreach ($accData as $data) {
            $data->access = $accessModel->where('user_id',$data->id)->first();
        }
        
        return view('page/account/index.php',['mAccData'=>$accData]);
    }

    public function save()
    {

        /*
            Requirement about account management
            1. Account mirror will be provided as table account in trx schema
            2. Account act as server microservice, and need to register to the assets meta
            3. Metadata have data as
            - name of the service (trx)
            - sitename (trx)
            - access_key (trx)
            - site_url (all below will be meta)
            - site_name
            - site_desc
            - site_port
            - bandwidth (optional)
            - quota
            - user_id (relative to the trx)
            - date_created
            - date_updated
        */
        
        helper(['form']);
        $accessModel = new AccessModel(); #meta
        $accountModel = new AccountModel(); #trx

        $accData = [
            'name' => $this->request->getVar('name'),
            'sitename' => $this->request->getVar('site_name'),
            'access_key' => sha1($this->mTime),
            'date_created' => $this->mTime,
            'date_updated' => $this->mTime
        ];

        $accountModel->insert($accData);

        $accessData = [
            'site_url' => $this->request->getVar('site_url'),
            'site_name' => $this->request->getVar('site_name'),
            'site_desc' => $this->request->getVar('site_desc'),
            'site_port' => $this->request->getVar('site_port'),
            'bandwidth' => $this->request->getVar('bandwidth'),
            'quota' => $this->request->getVar('quota'),
            'user_id' => $accountModel->getInsertID(),
            'date_created' => $this->mTime,
            'date_updated' => $this->mTime,
        ];

        $accessModel->insert($accessData);

        return redirect()->to('account');
    }

    public function delete(){
        /*
            If they have constraint to the data in asset, they cant be deleted.
            much safe that the record will be nonactive, they cant be insert any asset to API.
            but the api still can give/response any data (incase data still needed in apps) 
         */
    }
}
