<?php

namespace App\Http\Controllers;

use App\Modules\Category\Models\Category;
use App\Modules\Client\Models\Client;
use App\Modules\Offer\Models\Offer;
use App\Modules\Task\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $clients = Client::count();
        $tasks = Task::count();
        $categories = Category::count();
        $offers = Offer::count();
        
        $data = [
        "clients"=>$clients,
        "tasks"=>$tasks ,
        "categories"=>$categories,
        "offers"=>$offers
        ];

        return $this->returnJSON($data , 'Dashboard Data');
    }
}
