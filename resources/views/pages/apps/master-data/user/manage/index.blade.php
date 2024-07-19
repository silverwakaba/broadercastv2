@extends('layout.app')
@section('title', 'Manage ' . $datas->name)
@section('content')
    <x-adminlte.Content previous="apps.master.index">
        <div class="row row-cols-1 row-cols-lg-2">
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Biodata" content="Manage user biodata" :link="route('apps.master.user.manage.biodata', ['id' => request()->id])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Content" content="Manage user content" :link="route('apps.master.user.manage.content', ['id' => request()->id])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Gender" content="Manage user gender" :link="route('apps.master.user.manage.gender', ['id' => request()->id])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Language" content="Manage user language" :link="route('apps.master.user.manage.language', ['id' => request()->id])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Link" content="Manage user link" :link="route('apps.master.user.manage.link', ['id' => request()->id])" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Persona" content="Manage user persona" :link="route('apps.master.user.manage.persona', ['id' => request()->id])" />
            </div>
        </div>
    </x-adminlte.Content>
@endsection