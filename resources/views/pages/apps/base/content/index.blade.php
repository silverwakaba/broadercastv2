@extends('layout.app')
@section('title', 'Content Type')
@section('content')
    <x-adminlte.content previous="apps.master.index">
        <x-adminlte.card add="apps.base.content.add">
            <x-adminlte.table ids="contentTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="15%">State</th>
                        <th width="20%">Creator</th>
                        <th width="50%">Name</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-adminlte.table>
        </x-adminlte.card>
    </x-adminlte.content>

    <script type="module">
        Pusher.logToConsole = true;
        
        var channel = Echo.channel('baseChannel');

        channel.listen('.baseContentCreated', function(data){
            $('#contentTables').DataTable().ajax.reload();
        });

        channel.listen('.baseContentModified', function(data){
            $('#contentTables').DataTable().ajax.reload();
        });

        $("#contentTables").DataTable({
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
                    data: "datas.decision.name",
                },
                {
                    data: "datas.user.identifier",
                },
                {
                    data: "datas.name",
                },
                {
                    data: "action",
                    bSortable: false,
                    bSearchable: false,
                    // visible: {{ auth()->user()->hasRole('Admin|Moderator') ? "true" : "false" }},
                },
            ],
        });
    </script>
@endsection