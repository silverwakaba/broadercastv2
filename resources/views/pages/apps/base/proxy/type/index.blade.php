@extends('layout.app')
@section('title', 'Proxy Type')
@section('content')
    <x-Adminlte.Content :previous="route('apps.master.index')">
        <x-Adminlte.Card :add="route('apps.base.proxy.type.add')">
            <x-Adminlte.Table ids="proxyTypeTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="85%">Name</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-Adminlte.Table>
        </x-Adminlte.Card>
    </x-Adminlte.Content>

    <script type="module">
        $("#proxyTypeTables").DataTable({
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
                    data: "datas.name",
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