@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-lg-4">
                <x-Adminlte.CardProfile :profile="$profile" :links="$link" :channels="$tracker->data" />
            </div>
            <div class="col-lg-8">
                <x-Adminlte.Card title="About">
                    @if($profile->biodata->biography)
                        {!! $profile->biodata->biography !!}
                    @else
                        <p>Nothing known about this creator yet.</p>
                    @endif
                </x-Adminlte.Card>
                <x-Adminlte.Card title="Archive">
                    <x-Adminlte.Table ids="feedTable">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="95%">Content</th>
                            </tr>
                        </thead>
                    </x-Adminlte.Table>
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>

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