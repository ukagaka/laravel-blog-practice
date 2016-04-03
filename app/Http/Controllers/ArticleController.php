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
        $article = Article::create($request->all());
        if($article){
            return redirect('/article')->with(['create_success'=>"创建成功"]);
        }
    }

    public function create()
    {
        return view('article.create');
    }

    public function destroy(Request $request)
    {
        $res = Article::whereIn('id',$request->ids)->delete();
        if($res){
            return $res;
        }
    }

}
