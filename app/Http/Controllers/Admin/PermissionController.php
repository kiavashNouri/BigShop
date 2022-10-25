<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:show-permissions')->only(['index']);
        $this->middleware('can:create-permission')->only(['create' , 'store']);
        $this->middleware('can:edit-permission')->only(['edit' , 'update']);
        $this->middleware('can:delete-permission')->only(['destroy']);
    }
    public function index()
    {
        $permissions = Permission::query();

        if($keyword = request('search')) {
            $permissions->where('name' , 'LIKE' , "%{$keyword}%")->orWhere('label' , 'LIKE' , "%{$keyword}%" );
        }

        $permissions = $permissions->latest()->paginate(20);
        return view('admin.permissions.all' , compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'label' => ['required', 'string', 'max:255'],
        ]);

        Permission::create($data);

        alert()->success('مطلب مورد نظر شما با موفقیت ایجاد شد');

        return redirect(route('admin.permissions.index'));
    }



    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit' , compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255' , Rule::unique('permissions')->ignore($permission->id)],
            'label' => ['required', 'string',  'max:255'],
        ]);

        $permission->update($data);

        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return redirect(route('admin.permissions.index'));
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        alert()->success('مطلب مورد نظر شما با موفقیت حذف شد');
        return back();    }
}

