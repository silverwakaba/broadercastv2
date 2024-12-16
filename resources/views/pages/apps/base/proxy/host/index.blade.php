@extends('layout.app')
@section('title', 'Proxy Host')
@section('content')
    <x-Adminlte.Content :previous="route('apps.master.index')">
        <x-Adminlte.Callout class="info">
            <ol class="m-0">
                <li>TOR is local connection and YTS is HA.</li>
                <li>So currently this page is only used to view the status of proxy host.</li>
                <li>That means CRUD actions are temporarily disabled until the new implementation.</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.Card :add="route('apps.base.proxy.host.add')">
            <x-Adminlte.Table ids="proxyHostTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="15%">Type</th>
                        <th width="65%">Host</th>
                        <th width="5%">Online</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-Adminlte.Table>
        </x-Adminlte.Card>
    </x-Adminlte.Content>

    <script type="module">
        $("#proxyHostTables").DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url()->current() }}",
            columns: [
                {
                    bSearchable: false,
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "datas.type.name",
                },
                {
                    data: "datas.host",
                },
                {
                    data: "datas.online",
                },
                {
                    data: "action",
                    bSortable: false,
                    bSearchable: false,
                },
            ],
        });
    </script>
@endsection