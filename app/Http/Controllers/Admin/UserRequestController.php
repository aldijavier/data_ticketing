<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStatusRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\UserRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRequestController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = UserRequest::all();

        return view('admin.userrequest.index', compact('users'));
    }

    public function create()
    {
        // abort_if(Gate::denies('status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userrequest.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $status = UserRequest::create($request->all());

        return redirect()->route('admin.userrequest.index');
    }

    public function edit(UserRequest $user)
    {
        // abort_if(Gate::denies('status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userrequest.edit', compact('user'));
    }

    public function update(UpdateStatusRequest $request, UserRequest $user)
    {
        $user->update($request->all());

        return redirect()->route('admin.userrequest.index');
    }

    public function show(UserRequest $status)
    {
        abort_if(Gate::denies('status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.statuses.show', compact('status'));
    }

    public function destroy(UserRequest $users)
    {
        // abort_if(Gate::denies('status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users->delete();

        return back();
    }

    public function massDestroy(MassDestroyStatusRequest $request)
    {
        UserRequest::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
