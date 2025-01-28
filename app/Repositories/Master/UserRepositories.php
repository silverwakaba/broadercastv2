<?php

namespace App\Repositories\Master;

use App\Models\User;
use App\Helpers\BaseHelper;
use App\Helpers\RedirectHelper;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserRepositories{
    public static function datatable(array $data){
        $datas = User::with(isset($data['with']) ? $data['with'] : [])->orderBy('name', 'ASC')->get();

        return DataTables::of($datas)->setTransformer(function($datas) use($data){
            return [
                'datas'  => UserResource::make($datas)->resolve(),
                'action' => view('datatable.action-mod', [
                    'id'    => BaseHelper::encrypt($datas->id),
                    'route' => $data['route'],
                ])->render(),
            ];
        })->toJson();
    }

    public static function create(array $data, $title = ''){
        $default = [
            'base_status_id'    => 11,
            'confirmed'         => true,
            'identifier'        => BaseHelper::setIdentifier($data['name'], BaseHelper::adler32(now())),
            'email'             => BaseHelper::randomEmail(),
            'password'          => BaseHelper::randomPassword(),
        ];

        $create = array_merge(
            $default, $data
        );

        $user = User::create($create);

        // Biodata
        $user->hasOneUserBiodata()->update([
            'nickname'  => $create['nickname'],
            'dob'       => $create['dob'],
            'dod'       => $create['dod'],
            'biography' => $create['biography'],
        ]);

        // Affiliation
        $user->belongsToManyUserAffiliation()->sync($create['affiliation']);

        // Content
        $user->belongsToManyUserContent()->sync($create['content']);

        // Gender
        $user->belongsToManyUserGender()->sync($create['gender']);

        // Language
        $user->belongsToManyUserLanguage()->sync($create['language']);

        // Persona
        $user->belongsToManyUserRace()->sync($create['persona']);

        return redirect()->route('apps.master.user.manage.index', ['uid' => BaseHelper::encrypt($user->id)]);
    }

    public static function find(array $data){
        $id = BaseHelper::decrypt($data['id']);

        $datas = User::findOrFail($id);

        return BaseHelper::resourceToJson(new UserResource($datas));
    }
}
