<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;//*1TaskController: 

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)//*21TaskController
    {
        //Sin Paginación
        //$tasks = Task::orderBy('id','DESC')->get();//*2TaskController
        //return $tasks;//*3TaskController

        //Con Paginación
        $tasks = Task::orderBy('id','ASC')->paginate(10);//*17TaskController
        return[
            'pagination' =>[//*18TaskController
                'total'         => $tasks->total(),//*20TaskController
                'current_page'  => $tasks->currentPage(),
                'per_page'      => $tasks->perPage(),
                'last_page'     => $tasks->lastPage(),
                'from'          => $tasks->firstItem(),
                'to'            => $tasks->lastItem(),

            ],
            'tasks'=> $tasks//*19TaskController

        ];
    }

    //*7TaskController

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //*9TaskController
    {
        $this ->validate($request,[         //*10TaskController
            'keep' => 'required'            //*11TaskController
        ]);

        Task::create($request->all());             //*12TaskController
        return;
    }

 
    //*8TaskController
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//*13TaskController
    {
       $this->validate($request,[ //*14TaskController
            'keep' => 'required', //*15TaskController

       ]); 
       Task::find($id)->update($request->all());//*16TaskController
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);//*5TaskController:
        $task->delete();//*6TaskController:
    }
}
