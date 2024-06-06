<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserAddressRequest;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Models\User;
use App\Models\UserAddress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAddressController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAddresses = UserAddress::with(['user'])->get();

        return view('admin.userAddresses.index', compact('userAddresses'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_address_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userAddresses.create', compact('users'));
    }

    public function store(StoreUserAddressRequest $request)
    {
        $userAddress = UserAddress::create($request->all());

        return redirect()->route('admin.user-addresses.index');
    }

    public function edit(UserAddress $userAddress)
    {
        abort_if(Gate::denies('user_address_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userAddress->load('user');

        return view('admin.userAddresses.edit', compact('userAddress', 'users'));
    }

    public function update(UpdateUserAddressRequest $request, UserAddress $userAddress)
    {
        $userAddress->update($request->all());

        return redirect()->route('admin.user-addresses.index');
    }

    public function show(UserAddress $userAddress)
    {
        abort_if(Gate::denies('user_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAddress->load('user');

        return view('admin.userAddresses.show', compact('userAddress'));
    }

    public function destroy(UserAddress $userAddress)
    {
        abort_if(Gate::denies('user_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAddress->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserAddressRequest $request)
    {
        UserAddress::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
