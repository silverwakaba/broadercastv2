@extends('layout.app')
@section('title', 'Account Manager')
@section('content')
    <x-Adminlte.Content>
        <div class="row row-cols-1 row-cols-lg-2">
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user" title="Avatar" content="Use your most awesome avatar to to charm new audience!" :link="route('apps.manager.avatar')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-align-left" title="Biodata" content="Tell the world about your biodata!" :link="route('apps.manager.biodata')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-warehouse" title="Content" content="What kind of content do you create?" :link="route('apps.manager.content')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-at" title="Email" content="Change your email." :link="route('apps.usermenu.email')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-envelope" title="Fanbox" content="Create, share and discuss something with your audience using fanbox." :link="route('apps.manager.fanbox.index')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-venus-mars" title="Gender" content="Tell us about the gender that represent you!" :link="route('apps.manager.gender')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user-tag" title="Handler" content="Manage your @handler and identifier." :link="route('apps.manager.handler')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-language" title="Language" content="Tell us about the languages you use most often in your content!" :link="route('apps.manager.language')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-link" title="Link" content="Manage your external link and channel." :link="route('apps.manager.link')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-unlock-alt" title="Password" content="You can change your password here." :link="route('apps.usermenu.password')" />
            </div>
            <div class="col">
                <x-Adminlte.Box colors="bg-dark" icon="fas fa-user-secret" title="Persona" content="Tell us your persona!" :link="route('apps.manager.persona')" />
            </div>
        </div>
    </x-Adminlte.Content>
@endsection