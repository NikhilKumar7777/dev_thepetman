@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userAddress.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.id') }}
                        </th>
                        <td>
                            {{ $userAddress->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.name') }}
                        </th>
                        <td>
                            {{ $userAddress->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.phone_no') }}
                        </th>
                        <td>
                            {{ $userAddress->phone_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.addressline_1') }}
                        </th>
                        <td>
                            {{ $userAddress->addressline_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.addressline_2') }}
                        </th>
                        <td>
                            {{ $userAddress->addressline_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.city') }}
                        </th>
                        <td>
                            {{ $userAddress->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.zip_code') }}
                        </th>
                        <td>
                            {{ $userAddress->zip_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.state') }}
                        </th>
                        <td>
                            {{ $userAddress->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\UserAddress::TYPE_SELECT[$userAddress->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.default') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $userAddress->default ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userAddress.fields.user') }}
                        </th>
                        <td>
                            {{ $userAddress->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection