<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use App\Skill;

use DB;

use Response;

use Carbon\Carbon;

class APIController extends Controller
{
    //
    public function index(Request $request) 
    {
    	$books = DB::table('books')->join('skills', 'books.skill', '=', 'skills.id')
    							->select('books.id', 'books.title', 'skills.name', 'books.author', 'books.author_bio', 'books.description', 'books.price', 'books.rating', 'books.img_url', 'books.book_url', 'skills.crawled_at');

    	if ($skill = $request->input('skill')) 
    	{
    		$books = $books->where('skills.name', '=', $skill);
    	}
    	return Response::json($books->get());
    }

    public function store(Request $request) 
    {
    	if ($skill = $request->input('skill')) 
    	{
    		$skill = trim($skill);
    		$skill = strtolower($skill);
    		Skill::updateOrCreate(array('name' => $skill), array('name' => $skill, 'crawled_at' => Carbon::now()));
			 $input['skill'] = Skill::where('name', $skill)->first()->id;
    	} 
    	else
    	{
    		return  Response::json(false);
    	}
    	$input['title'] = $request->input('title') ? : '';
        $input['author'] = $request->input('author') ? : '';
        $input['author_bio'] = $request->input('author_bio') ? : '';
        $input['description'] = $request->input('description') ? : '';
        $input['price'] = $request->input('price') ? : '';
        $input['rating'] = $request->input('rating') ? : '';
        $input['img_url'] = $request->input('img_url') ? : '';
        $input['book_url'] = $request->input('book_url') ? : '';

        return Response::json(Book::create($input));
    }

    public function show($id) 
    {
    	$books = DB::table('books')->join('skills', 'books.skill', '=', 'skills.id')
    							->select('books.id', 'books.title', 'skills.name', 'books.author', 'books.author_bio', 'books.description', 'books.price', 'books.rating', 'books.img_url', 'books.book_url', 'skills.crawled_at')
    							->where('books.id', '=', $id)->get();
    	return Response::json($books);
    }

    public function update($id, Request $request) 
    {
    	if ($skill = $request->input('skill')) 
    	{
    		$skill = trim($skill);
    		$skill = strtolower($skill);
    		Skill::updateOrCreate(array('name' => $skill), array('name' => $skill, 'crawled_at' => Carbon::now()));
			$skillId = Skill::where('name', $skill)->first()->id;
    	}

    	$input = $request->all();

    	if (isset($skillId))
    	{
    		$input['skill'] = $skillId;
    	}

    	return Response::json(Book::find($id)->update($input));
    }

    public function destroy($id) 
    {
    	return Response::json(Book::destroy($id));
    }
}
