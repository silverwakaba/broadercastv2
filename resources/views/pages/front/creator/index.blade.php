@extends('layout.app')
@section('title', 'Creator Discovery')
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-md-4">
                <x-Adminlte.Card title="Search Parameter">
                    <!--  -->
                </x-Adminlte.Card>
            </div>
            <div class="col-md-8">
                <x-Adminlte.Card title="Creator">
                    <x-Adminlte.CardChannel col="2" :channels="$datas" />
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection