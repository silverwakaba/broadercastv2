@extends('layout.app')
@section('title', 'My Fanbox')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.Card :add="$addURI">
            <x-Adminlte.Table ids="myFanboxTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="75%">Title</th>
                        <th width="5%">Active</th>
                        <th width="5%">Public</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-Adminlte.Table>
        </x-Adminlte.Card>
    </x-Adminlte.Content>

    <script type="module">
        $("#myFanboxTables").DataTable({
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
                    data: "datas.title",
                    render: function(data, type, row){
                        return `
                            <a href="${ row['datas']['page'] }" target="_blank">${ row['datas']['title'] }</a>
                        `;
                    },
                },
                {
                    data: "datas.active",
                },
                {
                    data: "datas.public",
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