@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.animal.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.animals.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $animal->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $animal->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.icon') }}
                                    </th>
                                    <td>
                                        @if($animal->icon)
                                            <a href="{{ $animal->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $animal->icon->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.gender') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Animal::GENDER_SELECT[$animal->gender] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.breed') }}
                                    </th>
                                    <td>
                                        {{ $animal->breed->type ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.pet_type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Animal::PET_TYPE_SELECT[$animal->pet_type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.animal.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $animal->user->name ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.animals.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection