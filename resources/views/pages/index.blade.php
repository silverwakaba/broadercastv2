@extends('layout.app')
@section('title', 'Aggregator of Content Creator')
@section('content')
    <x-Adminlte.Content title="Home">
        <div class="row">
            <div class="col-lg-9">
                <x-Adminlte.Card title="Latest Activity">
                    <x-Adminlte.CardChannelLive col="3" :channels="$tracker" />
                </x-Adminlte.Card>
                <x-Adminlte.Card title="Latest Archive">
                    <x-Adminlte.Table ids="archiveTable">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="25%">Creator</th>
                                <th width="70%">Content</th>
                            </tr>
                        </thead>
                    </x-Adminlte.Table>
                </x-Adminlte.Card>
            </div>
            <div class="col-lg-3">
                <x-Adminlte.Card title="Information Board">
                    <!--  -->
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>

    <script type="module">
        $("#archiveTable").DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url()->current() }}",
            columns: [
                {
                    bSearchable: false,
                    class: "text-center",
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "user.name",
                    bSearchable: true,
                    render: function(data, type, row){
                        return `
                            <a href="${ row['user']['page'] }" class="text-light" target="_blank">
                                <div class="user-block">
                                    <img class="img-circle" src="${ row['avatar']['path'] }" />
                                    <span class="username">${ row['user']['name'] }</span>
                                    <span class="description">${ row['published'] } | ${ row['published_for_human'] }</span>
                                </div>
                            </a>
                        `;
                    },
                },
                {
                    data: "title",
                    bSearchable: true,
                    render: function(data, type, row){
                        return `
                            <a href="${ row['link'] }" class="text-light" target="_blank">
                                <div class="attachment-block clearfix m-0">
                                    <img class="attachment-img" src="${ row['thumbnail'] }" />
                                    <div class="attachment-pushed">
                                        <div class="attachment-text">
                                            <span><img height="15" width="15" src="${ row['service']['logo'] }" /> ${ row['service']['name'] }</span>
                                        </div>
                                        <h4 class="attachment-heading">${ row['title'] }</h4>
                                    </div>
                                </div>
                            </a>
                        `;
                    },
                },
            ],
        });
    </script>
@endsection