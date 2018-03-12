@extends('admin.layouts.admin')

@section('title', __('views.admin.notifications.title') )

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {!! Form::open(['url' => 'admin/notifications/store', 'method' => 'post' , 'class' => 'form-horizontal form-label-left']) !!}

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="device-types-select">
                    {{ __('views.admin.notifications.send_notification.device_types') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="device-types-select" name="deviceTypes[]" class="select2" style="width: 100%"
                            autocomplete="off">
                        @foreach($deviceTypes as $key => $deviceType))
                        <option selected="selected" value="{{ $key }}">{{ $deviceType }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="users-select">
                    {{ __('views.admin.notifications.send_notification.users') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="users-select" name="users[]" class="select2" multiple="multiple" style="width: 100%"
                            autocomplete="off">
                        @foreach($users as $user)
                            <option selected="selected" value="{{json_encode($user)}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="message">
                    {{ __('views.admin.notifications.send_notification.message') }}
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="message" class="form-control col-md-7 col-xs-12" name="message" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a class="btn btn-primary"
                       href="{{ URL::previous() }}"> {{ __('views.admin.notifications.send_notification.cancel') }}</a>
                    <button type="submit"
                            class="btn btn-success"> {{ __('views.admin.notifications.send_notification.send') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/users/edit.css')) }}
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/users/edit.js')) }}

    <script type="text/javascript">
        $('#device-types-select').on('select2:select', function (e) {
            $.get("{{ url('admin/users/users-type')}}/" + $(this).val(),
                function (data) {
                    var select = $('#users-select');
                    select.html('');
                    $.each(data, function (index, element) {
                        var option = $('<option></option>').text(element.name).val(JSON.stringify(element));
                        option.appendTo(select);
                    });
                    select.trigger('change');
                });
        });
    </script>
@endsection