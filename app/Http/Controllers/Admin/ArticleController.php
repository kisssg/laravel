<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Comment;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{

    // return view with articles
    public function index(Request $request)
    {
        $articles = Article::where('user_id', $request->user()->id)->paginate(5);
        return view('admin/article/index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('admin/article/create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:articles|max:15',
            'body' => 'required',
        ];
        $this->validate($request, $rules, [
            'title.required' => ':attribute必填',
            'title.unique' => ':attribute已存在',
            'max' => ':attribute超出长度限制:最长:max个字符'
        ]);
        $article = new Article;
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->user_id = $request->user()->id;

        if ($article->save())
        {
            return redirect('admin/articles');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    public function edit($id, Request $request)
    {
        if ($request->user()->id != Article::find($id)->user_id)
        {
            return redirect()->back()->withErrors('只能修自己的文章。');
        }
        if ($request->old('title') != null)
        {
            return view('admin/article/edit')->withArticle((object) [
                                'title' => $request->old('title'),
                                'body' => $request->old('body'),
                                'id' => $request->old('id')
            ]);
        }
        else
        {
            return view('admin/article/edit')->withArticle(Article::findOrFail($id));
        }
    }

    public function update($id, Request $request)
    {
        $request->flash();
        $rules = [
            'title' => ['required', 'max:15', Rule::unique('articles')->ignore($id)],
            'body' => 'required',
        ];
        $this->validate($request, $rules, [
            'title.required' => ':attribute必填',
            'title.unique' => ':attribute已存在',
            'max' => ':attribute超出长度限制:最长:max个字符'
        ]);
        $article = Article::find($id);
        $article->body = $request->get('body');
        $article->title = $request->get('title');
        if ($article->update())
        {
            return redirect('admin/articles');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors();
        }
    }

    public function destroy($id)
    {
        Article::find($id)->delete();
        Comment::where('article_id', $id)->delete();
        return redirect()->back()->withInput()->withErrors("删除成功！");
    }

    public function show(Request $request)
    {
        return $request;
    }

}
