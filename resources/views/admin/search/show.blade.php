@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div id="search-page" class="card-body">
                    <h3 class="box-title">@lang('front.searchHere')</h3>
                    <form class="form-group" action="{{ route('admin.search.store') }}" novalidate method="POST" role="search">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group">
                            <input type="text"  name="search_key" class="form-control" placeholder="@lang('front.searchBy')" value="{{ $searchKey }}">
                            <span class="input-group-btn"><button type="submit" class="btn waves-effect waves-light btn-info"><i class="fa fa-search"></i></button></span>
                        </div>
                    </form>
                    <h2 class="m-t-40">Search Result For "{{ $searchKey }}"</h2>
                    <small>About {{ count($searchResults) }} result </small>
                    <hr>
                    <ul class="search-listing">
                        @forelse($searchResults as $result)
                            <li>
                                <h3>
                                    <a href="{{ route($result->route_name, $result->searchable_id) }}">
                                        @lang('app.'.strtolower($result->searchable_type)): {{ $result->title }}
                                    </a>
                                </h3>
                                <a href="{{ route($result->route_name, $result->searchable_id) }}" class="search-links">{{ route($result->route_name, $result->searchable_id) }}</a>
                            </li>
                        @empty
                            <li>
                                No result found
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
