<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Categories;
use App\Models\AppSection;
use App\Models\Events;
use App\Models\Countries;
use App\Models\Organizations;

class HomeController extends Controller
{
    public function index(){
    	return view('welcome');
	}
}
