<?php

namespace App\Http\Controllers\Apps\Master;
use App\Http\Controllers\Controller;
use App\Helpers\BaseHelper;

use App\Events\UserCreated;
use App\Events\UserModified;
use App\Http\Requests\Apps\Master\UserRequest;
use App\Http\Requests\Apps\Master\UserRequestValidated;

use App\Http\Resources\UserResource;

use App\Models\User;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller{
    // Apps User Account Index
    public function index(){
        if(request()->ajax()){
            $datas = User::orderBy('id', 'DESC')->get();

            return DataTables::of($datas)->setTransformer(function($data){
                return [
                    'datas'  => UserResource::make($data)->resolve(),
                    'action' => view('datatable.action')->with('id', BaseHelper::encrypt($data->id))->render(),
                ];
            })->toJson();
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
        $did = BaseHelper::decrypt($id);

        $datas = User::where([
            ['id', '=', $did],
        ])->firstOrFail();

        return view('pages/apps/master-data/user/edit', [
            'datas' => $datas,
        ]);
    }

    public function editPost(UserRequestValidated $request, $id){
        $did = BaseHelper::decrypt($id);

        $datas = User::where('id', '=', $did)->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->new_password),
        ]);

        UserModified::dispatch($datas);

        return redirect()->route('apps.master.user.index')->with('class', 'success')->with('message', 'Your edited account is ready.');
    }

    // Delete
    public function delete($id){
        $did = BaseHelper::decrypt($id);

        $datas = User::where([
            ['id', '=', $did],
        ])->delete();

        UserModified::dispatch($datas);

        return redirect()->route('apps.master.user.index')->with('class', 'success')->with('message', 'Your selected account is deleted.');
    }
}
