@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-adminlte.content>
        <div class="row">
            <div class="col-md-3">

                <!-- Profile -->
                <div class="card card-widget widget-user">
                    @if($profile->confirmed == true)
                        <div class="ribbon-wrapper">
                            <div class="ribbon bg-primary">
                                <span data-toggle="tooltip" data-placement="right" title="Verified Creator"><i class="fas fa-check-circle"></i></span>
                            </div>
                        </div>
                    @endif
                    <div class="widget-user-header bg-secondary">
                        <h3 class="widget-user-username">{{ \Illuminate\Support\Str::limit($profile->name, 15, ' (...)') }}</h3>
                        <h5 class="widget-user-desc">{{ $profile->biodata->nickname ? \Illuminate\Support\Str::limit($profile->biodata->nickname, 15, ' (...)') : 'No nickname yet' }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ $profile->avatar->path }}" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <strong>Content</strong>
                        @if($profile->content)
                            <ul class="list-inline">
                                @foreach($profile->content AS $content)
                                    <li class="list-inline-item">{{ $content->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No focus content yet.</p>
                        @endif
                        <strong>Gender</strong>
                        @if($profile->gender)
                            <ul class="list-inline">
                                @foreach($profile->gender AS $gender)
                                    <li class="list-inline-item">{{ $gender->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No gender representation yet.</p>
                        @endif
                        <strong>Language</strong>
                        @if($profile->language)
                            <ul class="list-inline">
                                @foreach($profile->language AS $language)
                                    <li class="list-inline-item">{{ $language->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No main language yet.</p>
                        @endif
                        <strong>Race</strong>
                        @if($profile->race)
                            <ul class="list-inline">
                                @foreach($profile->race AS $race)
                                    <li class="list-inline-item">{{ $race->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No character race yet.</p>
                        @endif
                        <strong>About</strong>
                        @if($profile->biodata->biography)
                            {!! $profile->biodata->biography !!}
                        @else
                            <p>Nothing known about this creator yet.</p>
                        @endif
                        @if($profile->link)
                            <div class="border p-3 text-center">
                                <ul class="list-inline m-0">
                                    @foreach($profile->link AS $link)
                                        <li class="list-inline-item">
                                            <a href="{{ $link->link_pivot }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="{{ $link->name }}" target="_blank">
                                                <img height="25" width="25" src="{{ $link->logo }}" />
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Profile -->

            </div>
            <div class="col-md-9">
                <x-adminlte.card>
                    ABC
                </x-adminlte.card>
            </div>
        </div>
    </x-adminlte.content>
@endsection