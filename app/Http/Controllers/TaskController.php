<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request $request
     * @param string $id
     * @return Response
     */
    public function index(Request $request, $id = '')
    {
        $user = $request->user();
        if ($id != '' and (Client::find($id)->exists())) {
            $Client = Client::find($id);
        } else {
            $Client = Client::where('task_id', '')
                ->orderByRaw("RAND()")
                ->first();
        }
        $Sipnet = new SipnetController($user->sip_login, $user->sip_password);
        $cid = $Sipnet->getCidButton($Client->phone);

        $task_success = Task::where([
            ['task_status_id', '=', 1],
            ['user_id', '=', $user->id],
        ])->with('clients')->limit(10)->get();

        $task_defer = $Tasks = Task::where([
            ['task_status_id', '=', 2],
            ['user_id', '=', $user->id],
        ])->with('clients')->limit(10)->get();

        $task_fail = $Tasks = Task::where([
            ['task_status_id', '=', 3],
            ['user_id', '=', $user->id],
        ])->with('clients')->limit(10)->get();

        return view('tasks.index', [
            'tasks_success' => $task_success,
            'tasks_defer' => $task_defer,
            'tasks_fail' => $task_fail,
            'user' => $user,
            'cid' => $cid,
            'client' => $Client
        ]);
    }

    /**
     * Create a new task. не используется
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    public function success(Request $request, $id)
    {
        $Task = Task::firstOrCreate(['client_id' => $id]);
        $Task->user_id = $request->user()->id;
        $Task->client_id = $id;
        $Task->task_status_id = 1;
        $Task->save();

        $Client = Client::find($id);
        $Client->user_id = $request->user()->id;
        $Client->task_id = $Task->id;
        $Client->save();

        return redirect('/tasks');
    }

    public function defer(Request $request, $id)
    {
        $Task = Task::firstOrCreate(['client_id' => $id]);
        $Task->user_id = $request->user()->id;
        $Task->client_id = $id;
        $Task->task_status_id = 2;
        $Task->save();

        $Client = Client::find($id);
        $Client->user_id = $request->user()->id;
        $Client->task_id = $Task->id;
        $Client->save();

        return redirect('/tasks');
    }

    public function fail(Request $request, $id, $fail_status_id)
    {
        $Task = Task::firstOrCreate(['client_id' => $id]);
        $Task->user_id = $request->user()->id;
        $Task->client_id = $id;
        $Task->task_status_id = 3;
        $Task->fail_status_id = $fail_status_id;
        $Task->save();

        $Client = Client::find($id);
        $Client->user_id = $request->user()->id;
        $Client->task_id = $Task->id;
        $Client->save();

        return redirect('/tasks');
    }

    /**
     * Destroy the given task. не используется
     *
     * @param  Request $request
     * @param  Task $task
     * @return Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

    public function test()
    {
        $Tasks = Task::where([
            ['task_status_id', '=', 1],
            ['user_id', '=', 1],
        ])->with('clients')->get();

        return view('test', [
            'data' => $Tasks,
        ]);
    }
}
