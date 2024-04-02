<?php

namespace App\Http\Controllers\Apps\Master;
use App\Http\Controllers\Controller;

use App\Events\UserCreated;
use App\Events\UserModified;
use App\Http\Requests\Apps\Master\UserRequest;
use App\Http\Requests\Apps\Master\UserRequestValidated;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller{
    // Apps User Account Index
    public function index(){
        if(request()->ajax()){
            $datas = User::orderBy('id', 'DESC')->get();

            return DataTables::of($datas)->addColumn('action', function($data){
                $btn = '<div class="btn-group btn-block" role="group">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action</button>
                            <div class="dropdown-menu">
                                <a href="'. route('apps.master.user.edit', ['id' => $data->id]) .'" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                                <a href="'. route('apps.master.user.delete', ['id' => $data->id]) .'" class="dropdown-item"><i class="fas fa-trash"></i> Delete</a>
                            </div>
                        </div>';
            
                return $btn;
            })->rawColumns(['action'])->make(true);
        }

        return view('pages/apps/master-data/user/index');
    }

    // Add
    public function add(){
        return view('pages/apps/master-data/user/add');
    }

    public function addPost(UserRequest $request){
        $datas = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ])->assignRole('User');

        UserCreated::dispatch($datas);

        return redirect()->route('apps.master.user.index')->with('class', 'success')->with('message', 'Your created account is ready.');
    }

    // Edit
    public function edit($id){
        $datas = User::where([
            ['id', '=', $id],
        ])->firstOrFail();

        return view('pages/apps/master-data/user/edit', [
            'datas' => $datas,
        ]);
    }

    public function editPost(UserRequestValidated $request, $id){
        $datas = User::where('id', '=', $id)->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->new_password),
        ]);

        UserModified::dispatch($datas);

        return redirect()->route('apps.master.user.index')->with('class', 'success')->with('message', 'Your edited account is ready.');
    }

    // Delete
    public function delete($id){
        $datas = User::where([
            ['id', '=', $id],
        ])->delete();

        UserModified::dispatch($datas);

        return redirect()->route('apps.master.user.index')->with('class', 'success')->with('message', 'Your selected account is deleted.');
    }
}
