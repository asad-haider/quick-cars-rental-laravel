@extends('admin.layouts.admin')

@section('title', __('views.admin.users.index.title'))

@section('content')
    <div class="row">

        <table width="100%" class="table table-striped table-bordered dt-responsive nowrap data-table"
               cellspacing="0"
               id="data-table">
            <thead>
            <tr>
                <th>{{ __('views.admin.users.index.table_header_0') }}
                </th>
                <th>{{ __('views.admin.users.index.table_header_1') }}
                </th>
                <th>{{ __('views.admin.users.index.table_header_2') }}</th>
                <th>{{ __('views.admin.users.index.table_header_3') }}
                </th>
                <th>{{ __('views.admin.users.index.table_header_4') }}
                </th>
                <th>{{ __('views.admin.users.index.table_header_5') }}
                </th>
                <th>{{ __('views.admin.users.index.table_header_6') }}
                </th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    {{--@foreach($users as $user)
        <tr>
            <td>{{ $user->email }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->roles->pluck('name')->implode(',') }}</td>
            <td>
                @if($user->active)
                    <span class="label label-primary">{{ __('views.admin.users.index.active') }}</span>
                @else
                    <span class="label label-danger">{{ __('views.admin.users.index.inactive') }}</span>
                @endif
            </td>
            <td>
                @if($user->confirmed)
                    <span class="label label-success">{{ __('views.admin.users.index.confirmed') }}</span>
                @else
                    <span class="label label-warning">{{ __('views.admin.users.index.not_confirmed') }}</span>
                @endif</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
            <td>
                <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', [$user->id]) }}"
                   data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.users.index.show') }}">
                    <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', [$user->id]) }}" data-toggle="tooltip"
                   data-placement="top" data-title="{{ __('views.admin.users.index.edit') }}">
                    <i class="fa fa-pencil"></i>
                </a>
                @if(!$user->hasRole('administrator'))
                    <button class="btn btn-xs btn-danger user_destroy"
                            data-url="{{ route('admin.users.destroy', [$user->id]) }}" data-toggle="tooltip"
                            data-placement="top" data-title="{{ __('views.admin.users.index.delete') }}">
                        <i class="fa fa-trash"></i>
                    </button>
                @endif
            </td>
        </tr>
    @endforeach--}}
@endsection

@section('scripts')
    <script type="text/javascript">
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        $(function () {
            columns = [
                {data: 'email', name: 'email'},
                {data: 'name', name: 'name'},
                {data: 'roles', name: 'roles', orderable: false, searchable: false},
                {data: 'active', name: 'active'},
                {data: 'confirmed', name: 'confirmed'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}];
            initDataTable('{{ url('/admin/users-data') }}', columns);
        });
    </script>
@endsection