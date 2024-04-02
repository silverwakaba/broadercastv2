@extends('layout.app')
@section('title', 'User Account')
@section('content')
    <x-adminlte.content previous="apps.master.index">
        <x-adminlte.card add="apps.master.user.add">
            <x-adminlte.table ids="example1">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="65%">Name</th>
                        <th width="20%">Email</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
            </x-adminlte.table>
        </x-adminlte.card>
    </x-adminlte.content>

    <script type="module">
        var channel = Echo.channel('usersChannel');
        
        channel.listen('.usersCreated', function(data){
            $('#example1').DataTable().ajax.reload();
        });

        channel.listen('.UserModified', function(data){
            $('#example1').DataTable().ajax.reload();
        });

        $("#example1").DataTable({
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
                    data: "name",
                },
                {
                    data: "email",
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