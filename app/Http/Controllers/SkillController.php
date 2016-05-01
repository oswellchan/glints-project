<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Skill;

use App\Http\Requests;

class SkillController extends Controller
{
    //
    public function index()
    {
    	$skills = Skill::all();
    	return view('skills.index', ['skills'=>$skills]);
    }
}
