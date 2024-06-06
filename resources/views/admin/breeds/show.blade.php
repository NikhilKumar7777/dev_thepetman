@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.breed.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.breeds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.breed.fields.id') }}
                        </th>
                        <td>
                            {{ $breed->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.breed.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Breed::TYPE_SELECT[$breed->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.breed.fields.breed') }}
                        </th>
                        <td>
                            {{ $breed->breed }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.breeds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection