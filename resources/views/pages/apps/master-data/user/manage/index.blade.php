@extends('layout.app')
@section('title', 'Manage ' . $datas->name)
@section('content')
    <x-Adminlte.Content :previous="route('apps.master.user.index')">
        <div class="row row-cols-1 row-cols-lg-2">
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-external-link-square-alt" title="Visit Profile" content="Visit user profile" :link="$datas->page" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Affiliation" content="Manage user affiliation" :link="route('apps.master.user.manage.affiliation', ['uid' => request()->uid])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Biodata" content="Manage user biodata" :link="route('apps.master.user.manage.biodata', ['uid' => request()->uid])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Content" content="Manage user content" :link="route('apps.master.user.manage.content', ['uid' => request()->uid])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Gender" content="Manage user gender" :link="route('apps.master.user.manage.gender', ['uid' => request()->uid])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Language" content="Manage user language" :link="route('apps.master.user.manage.language', ['uid' => request()->uid])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Link" content="Manage user link" :link="route('apps.master.user.manage.link', ['uid' => request()->uid])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Persona" content="Manage user persona" :link="route('apps.master.user.manage.persona', ['uid' => request()->uid])" />
            </div>
        </div>
    </x-Adminlte.Content>
@endsection