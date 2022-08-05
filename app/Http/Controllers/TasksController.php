<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // メッセージ一覧を取得
        $tasks = Task::all();
        
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // メッセージ一覧ビューでそれを表示
            // return view('tasks.index', [
            //     'tasks' => $tasks,
            //  ]);
            
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            
             // ビューでそれらを表示
            return view('tasks.index', $data);
        }
            
            // // ビューでそれらを表示
            // return view('tasks.index', $data);
            return view('auth.register');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 認証済みユーザを取得
        $user = \Auth::user();
        
        $task = new Task;
        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',   // 追加
            'status' => 'required|max:10',
        ]);
        
        // メッセージを作成
        // $task = new Task;
        // $task->content = $request->content;
        // $task->status = $request->status;
        // $task->save();
        
        $request->user()->tasks()->create([
             'status' => $request->status,
            'content' => $request->content
        ]);


        // トップページへリダイレクトさせる
        return redirect('/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

         if (\Auth::id() === $task->user_id) {
        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
         }
         
        //  return back();
         return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
         if (\Auth::id() === $task->user_id) {
        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
         }
        //   return back();
         return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',  
            'status' => 'required|max:10',
        ]);
        
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
        // メッセージを更新
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/index');
        }
        // return back();
         return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
         if (\Auth::id() === $task->user_id) {
        // メッセージを削除
        $task->delete();
        
        // トップページへリダイレクトさせる
        return redirect('/index');
        }
        // return back();
         return redirect('/');
    }
    

}
