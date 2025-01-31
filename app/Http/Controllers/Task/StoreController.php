<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Task;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request) //request
    {
        $data = $request->validated(); //get data
        Task::create($data); //create data
        return response(); 
    }
    // add try-catch


}
