<?php

use App\Models\Auth\Role\Role;
use DaveJamesMiller\Breadcrumbs\Generator;

Breadcrumbs::register('admin.users', function (Generator $breadcrumbs) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.users.index.title'));
});

Breadcrumbs::register('admin.users.show', function (Generator $breadcrumbs, \App\Models\Auth\User\User $user) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.users.index.title'), route('admin.users'));
    $breadcrumbs->push(__('views.admin.users.show.title', ['name' => $user->name]));
});


Breadcrumbs::register('admin.users.edit', function (Generator $breadcrumbs, \App\Models\Auth\User\User $user) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.users.index.title'), route('admin.users'));
    $breadcrumbs->push(__('views.admin.users.edit.title', ['name' => $user->name]));
});

Breadcrumbs::register('admin.notifications.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.notifications.title'));
});


Breadcrumbs::register('admin.roles', function (Generator $breadcrumbs) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.roles.index.title'));
});

Breadcrumbs::register('admin.roles.show', function (Generator $breadcrumbs, Role $role) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.roles.index.title'), route('admin.roles'));
    $breadcrumbs->push(__('views.admin.roles.show.title', ['name' => $role->name]));
});


Breadcrumbs::register('admin.roles.edit', function (Generator $breadcrumbs, Role $role) {
    $breadcrumbs->push(__('views.admin.dashboard.title'), route('admin.dashboard'));
    $breadcrumbs->push(__('views.admin.roles.index.title'), route('admin.roles'));
    $breadcrumbs->push(__('views.admin.roles.edit.title', ['name' => $role->name]));
});


