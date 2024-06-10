@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-adminlte.content>
        <div class="row">
            <div class="col-lg-4">
                <x-adminlte.card-profile :profile="$profile" :links="$link" :channels="$tracker" />
            </div>
            <div class="col-lg-8">
                <x-adminlte.card title="About">
                    @if($profile->biodata->biography)
                        {!! $profile->biodata->biography !!}
                    @else
                        <p>Nothing known about this creator yet.</p>
                    @endif
                </x-adminlte.card>
                <x-adminlte.card title="Archive">
                    <x-adminlte.table ids="feedTable">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="95%">Content</th>
                            </tr>
                        </thead>
                    </x-adminlte.table>
                </x-adminlte.card>
            </div>
        </div>
    </x-adminlte.content>

    <script type="module">
        $("#feedTable").DataTable({
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
                    data: "title",
                    bSearchable: true,
                    render: function(data, type, row){
                        return `
                            <a href="${ row['link'] }" class="text-light" target="_blank">
                                <div class="attachment-block clearfix m-0">
                                    <img class="attachment-img" src="${ row['thumbnail'] }" />
                                    <div class="attachment-pushed">
                                        <div class="attachment-text">${ row['service']['name'] } | ${ row['published'] } | ${ row['published_for_human'] }</div>
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