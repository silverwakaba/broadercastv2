@extends('layout.app')
@section('title', 'User Account')
@section('content')
    <x-adminlte.content previous="apps.master.index">
        <x-adminlte.card add="apps.master.user.add">
            <x-adminlte.table ids="userTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="25%">Status</th>
                        <th width="60%">Name</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-adminlte.table>
        </x-adminlte.card>
    </x-adminlte.content>

    <script type="module">
        $("#userTables").DataTable({
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
                    data: "datas.title_temp",
                },
                {
                    data: "datas.name",
                    render: function(data, type, row){
                        return `
                            <a href="${ row['datas']['page'] }" target="_blank">${ row['datas']['name'] }</a>
                        `;
                    },
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