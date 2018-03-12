@extends('admin.layouts.admin')

@section('title', __('views.admin.roles.index.title'))

@section('content')
    <div class="row">

        <table width="100%" class="table table-striped table-bordered dt-responsive nowrap data-table"
               cellspacing="0"
               id="data-table">
            <thead>
            <tr>
                <th>{{ __('views.admin.roles.index.table_header_0') }}</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        $(function () {
            columns = [
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ];
            initDataTable('{{ url('/admin/roles-data') }}', columns);
        });
    </script>
@endsection