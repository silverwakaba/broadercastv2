@extends('layout.app')
@section('title', 'Gender Type')
@section('content')
    <x-Adminlte.Content previous="apps.master.index">
        <x-Adminlte.Card add="apps.base.gender.add">
            <x-Adminlte.Table ids="genderTables">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="15%">State</th>
                        <th width="20%">Creator</th>
                        <th width="50%">Name</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                </thead>
            </x-Adminlte.Table>
        </x-Adminlte.Card>
    </x-Adminlte.Content>

    <script type="module">
        // var channel = Echo.channel('baseChannel');

        // channel.listen('.baseGenderCreated', function(data){
        //     $('#genderTables').DataTable().ajax.reload();
        // });

        // channel.listen('.baseGenderModified', function(data){
        //     $('#genderTables').DataTable().ajax.reload();
        // });

        $("#genderTables").DataTable({
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
                },
            ],
        });
    </script>
@endsection