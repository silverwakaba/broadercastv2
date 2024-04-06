@extends('layout.app')
@section('title', 'Base Language')
@section('content')
    <x-adminlte.content previous="apps.base.index">
        <x-adminlte.card add="apps.base.language.add">
            <x-adminlte.table ids="languageTables">
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
        var channel = Echo.channel('baseChannel');

        channel.listen('.baseLanguageCreated', function(data){
            $('#languageTables').DataTable().ajax.reload();
        });

        channel.listen('.baseLanguageModified', function(data){
            $('#languageTables').DataTable().ajax.reload();
        });

        $("#languageTables").DataTable({
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
                    visible: {{ auth()->user()->hasRole('Admin') ? "true" : "false" }},
                },
            ],
        });
    </script>
@endsection