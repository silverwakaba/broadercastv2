@extends('layout.app')
@section('title', 'User Account')
@section('content')
    <x-Adminlte.Content :previous="route('apps.master.index')">
        <x-Adminlte.Card :add="route('apps.master.user.add')">
            <x-Adminlte.Table ids="userTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="25%">Status</th>
                        <th width="60%">Name</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-Adminlte.Table>
        </x-Adminlte.Card>
    </x-Adminlte.Content>

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