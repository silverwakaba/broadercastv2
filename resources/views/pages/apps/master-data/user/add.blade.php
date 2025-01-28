@extends('layout.app')
@section('title', 'Add New User')
@section('content')
    <x-Adminlte.Content :previous="route('apps.master.user.index')">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Input name="name" type="text" text="Name" />
            <x-Form.Select2m name="affiliation[]" text="Affiliation" :data="$affiliation" :value="$value" />
            <x-Form.Select2m name="content[]" text="Content" :data="$content" :value="$value" />
            <x-Form.Select2m name="gender[]" text="Gender" :data="$gender" :value="$value" />
            <x-Form.Select2m name="language[]" text="Language" :data="$language" :value="$value" />
            <x-Form.Select2m name="persona[]" text="Persona" :data="$persona" :value="$value" />
            <x-Form.Textarea name="nickname" text="Nickname" />
            <x-Form.Input col="6" name="dob" type="date" text="Date of Birth" />
            <x-Form.Input col="6" name="dod" type="date" text="Date of Debut" />
            <x-Form.Textarea name="biography" text="Biography" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection