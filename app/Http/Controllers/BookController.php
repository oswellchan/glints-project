<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;

use App\Skill;

use App\Http\Requests;

class BookController extends Controller
{
    //
    public function index(Request $request) {
        if ($request->input('skill')) {
            $skill = Skill::where('name', $request->input('skill'))->first();
            if (!$skill) {
                return view('books.index', ['resultlessSkill'=>$request->input('skill')]);
            }
            $books = $skill->books;
            return view('books.index', ['skill'=> $skill, 'books'=>$books]);
        } else {
            $books = Book::all();
            return view('books.index', ['books'=>$books]);
        }
    }
}
