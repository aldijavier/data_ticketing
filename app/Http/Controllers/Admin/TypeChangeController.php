<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequestTicket;
use App\Http\Requests\UpdateUserRequestTicket;
use App\TypeRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeChangeController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('type_of_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = TypeRequest::all();

        return view('admin.typeChange.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_of_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = TypeRequest::all();
        // $users = UserRequest::all();

        return view('admin.typeChange.create', compact('users'));
    }

    public function store(StoreUserRequestTicket $request)
    {
        $user = TypeRequest::create($request->all());
        // $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.typeofchange.index');
    }

    public function edit(TypeRequest $user)
    {
        abort_if(Gate::denies('type_of_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = TypeRequest::all()->pluck('name', 'id');

        // $user->load('roles');

        return view('admin.typechange.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.typeofchange.index');
    }

    public function show(TypeRequest $user)
    {
        abort_if(Gate::denies('type_of_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.typeofchange.show', compact('user'));
    }

    public function destroy(TypeRequest $user)
    {
        abort_if(Gate::denies('type_of_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        TypeRequest::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
