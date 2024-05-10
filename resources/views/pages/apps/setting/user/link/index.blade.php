@extends('layout.app')
@section('title', 'My External Link')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.card add="apps.manager.link.add">
            <x-adminlte.table ids="extLinkTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="20%">Service</th>
                        <th width="20%">Status</th>
                        <th width="45%">Link</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-adminlte.table>
        </x-adminlte.card>
    </x-adminlte.content>

    <script type="module">
        $("#extLinkTables").DataTable({
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
                    data: "datas.service.name",
                },
                {
                    data: "datas.decision.name",
                },
                {
                    data: "datas.link",
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