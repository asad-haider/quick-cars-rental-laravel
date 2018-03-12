@extends('admin.layouts.admin')

@section('title', __('views.admin.roles.show.title', ['name' => $role->name]))

@section('content')
    <div class="row">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th>{{ __('views.admin.roles.show.table_header_0') }}</th>
                <td>{{ $role->name }}</td>
            </tr>
            <tr>
                <th>{{ __('views.admin.roles.show.table_header_1') }}</th>
                <td>
                    <ul style="padding-left: 0; height: 200px; overflow-y: auto !important">
                        @foreach($role->permissions()->pluck('permission_title') as $permissionTitle)
                            <li>
                                {{$permissionTitle}}
                            </li>
                        @endforeach
                    </ul>

                </td>
            </tr>
            <tr>
                <th>{{ __('views.admin.roles.show.table_header_2') }}</th>
                <td>{{ $role->created_at }} ({{ $role->created_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>{{ __('views.admin.roles.show.table_header_3') }}</th>
                <td>{{ $role->updated_at }} ({{ $role->updated_at->diffForHumans() }})</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection