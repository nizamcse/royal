<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZKLibrary;

class TestController extends Controller
{
    public function index(){
        try{
            $zk = new ZKLibrary('192.168.1.201', 4370);
            return $zk->connect();
            if($zk->connect()){
                $zk->disableDevice();
                return "Connected";
            }
            dd($zk);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
