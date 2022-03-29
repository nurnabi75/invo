<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Events\ActivityEvent;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::where('user_id',Auth::user()->id)->orderBy('status','ASC')->orderBy('end_date', 'ASC' )->orderBy('priority' , 'DESC');
        // dd($tasks->get());

        if( !empty($request->client_id) ){
            $tasks = $tasks->where('client_id',$request->client_id);
        }
        if( !empty($request->status) ){
            $tasks = $tasks->where('status',$request->status);
        }
        if( !empty($request->formDate) ){
            $tasks = $tasks->whereDate('created_at','>=',$request->formDate);
        }
        if( !empty($request->endDate) ){
            $tasks = $tasks->whereDate('created_at','<=',$request->endDate);
        }
        if( !empty($request->price) ){
            $tasks = $tasks->where('price', '<=',$request->price);
        }


        $tasks =$tasks->paginate(10)->withQueryString();

        return view('task.index')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('task.create')->with([
            'clients' =>Client::where('user_id',Auth::id())->get(),
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
        $this->taskValidation($request);
        try {
               //tasks store in database
        $task = Task::create([
            'name' =>$request->name,
            'slug' =>Str::slug($request->name),
            'price' =>$request->price,
            'description' =>$request->description,
            'client_id' =>$request->client_id,
            'user_id' =>Auth::id(),
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
            'priority' =>$request->priority,
        ]);
        // dispatch(new ActivityEvent());
        //ActivityEvent::dispatch();
        event(new ActivityEvent('Task '.$task->id.' Created','Task',Auth::id()));



         // return response
         return redirect()->route('task.index')->with('success' , 'Task Created');
        } catch (\Throwable $th) {
            return redirect()->route('task.index')->with('error' , $th->getMessage());
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $task = Task::where('slug' ,$slug)->get()->first();

        return view ('task.show')->with('task',$task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit')->with([
            'task' =>$task,
            'clients' =>Client::where('user_id',Auth::user()->id)-> get(),
        ]);
    }

    public function taskValidation(Request $request)
    {
        return  $request->validate([
            'name'       => ['required' , 'max:255' , 'string'],
            'client_id'  => ['required' , 'max:255' ,'not_in:none'],
            'price'      => ['required' , 'integer'],
            'start_date' => ['required' , 'max:255'],
            'end_date'   => ['required' , 'max:255'],
            'priority'   => ['required' , 'max:255','not_in:none'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //validation
        $this->taskValidation($request);

      try {
          //update data
        $task->update([
            'name' =>$request->name,
            'slug' =>Str::slug($request->name),
            'price' =>$request->price,
            'description' =>$request->description,
            'client_id' =>$request->client_id,
            'user_id' =>Auth::id(),
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
            'priority' =>$request->priority,

        ]);
        event(new ActivityEvent('Task '.$task->id.' Updated','Task',Auth::id()));

        // Return
        return redirect()->route('task.index')->with('success' , 'Task Updated');
      } catch (\Throwable $th) {

        //Throw $th
        return redirect()->route('task.index')->with('error' , $th->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        event(new ActivityEvent('Task '.$task->id.' Deleted','Task',Auth::id()));
        return redirect()->route('task.index')->with('success' , 'Task Deleted');
    }

    public function markAsComplete(Task $task)
    {

        $task->update([
            'status'=>'complete'
        ]);

        return redirect()->back()->with('success' , 'Mark as completed');;
    }
}
