<?php

namespace App\Http\Controllers;

use App\Article;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('article.index',['articles'=>$articles]);
    }

    public function store(Request $request)
    {
        Article::create($request->all());
    }

    public function create()
    {

    }

}
