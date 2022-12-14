<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Task;
use App\Models\User;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::getAllOrderByUpdated_at();
        return view('task.index',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ð½ ç·¨é ãã©ã¼ã ããéä¿¡ããã¦ãããã¼ã¿ã¨ã¦ã¼ã¶IDããã¼ã¸ãï¼DBã«insertãã
        $data = $request->merge(['user_id' => Auth::user()->id])->all();
        // create()ã¯æåããç¨æããã¦ããé¢æ°
        // æ»ãå¤ã¯æ¿å¥ãããã¬ã³ã¼ãã®æå ±
        $result = Task::create($request->all());
        // ã«ã¼ãã£ã³ã°ãtodo.indexãã«ãªã¯ã¨ã¹ãéä¿¡ï¼ä¸è¦§ãã¼ã¸ã«ç§»åï¼
        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('task.edit', compact('task'));
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
        //ãã¼ã¿æ´æ°å¦ç
        $result = Task::find($id)->update($request->all());
        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Task::find($id)->delete();
        return redirect()->route('task.index');
    }
    public function mydata()
    {
        // Userã¢ãã«ã«å®ç¾©ãããªã¬ã¼ã·ã§ã³ãä½¿ç¨ãã¦ãã¼ã¿ãåå¾ããï¼
        $tasks = User::query()
        ->find(Auth::user()->id)
        ->userTasks()
        ->orderBy('created_at','desc')
        ->get();
        return view('task.index', compact('tasks'));
    }
}
