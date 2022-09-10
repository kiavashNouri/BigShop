<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-roles')->only(['index']);
        $this->middleware('can:create-role')->only(['create' , 'store']);
        $this->middleware('can:edit-role')->only(['edit' , 'update']);
        $this->middleware('can:delete-role')->only(['destroy']);
    }
    public function index()
    {
        $roles = Role::query();

        if($keyword = request('search')) {
            $roles->where('name' , 'LIKE' , "%{$keyword}%")->orWhere('label' , 'LIKE' , "%{$keyword}%" );
        }

        $roles = $roles->latest()->paginate(20);
        return view('admin.roles.all' , compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'label' => ['required', 'string', 'max:255'],
            'permissions' => ['required' , 'array']
        ]);


        $role = Role::create($data);
        $role->permissions()->sync($data['permissions']);


        alert()->success('مطلب مورد نظر شما با موفقیت ایجاد شد');

        return redirect(route('admin.roles.index'));
    }

    public function show(Role $role)
    {
        //
    }


    public function edit(Role $role)
    {
        return view('admin.roles.edit' , compact('role'));

    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255' , Rule::unique('roles')->ignore($role->id)],
            'label' => ['required', 'string',  'max:255'],
            'permissions' => ['required' , 'array']
        ]);

        $role->update($data);
        $role->permissions()->sync($data['permissions']);

        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return redirect(route('admin.roles.index'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        alert()->success('مطلب مورد نظر شما با موفقیت حذف شد');
        return back();
    }
}
