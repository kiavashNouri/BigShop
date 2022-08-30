<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $users = User::query();
//        میخوایم یک query جدبد استفاده کنم که به شکل زیره

        if($keyword = request('search')) {
            $users->where('email' , 'LIKE' , "%{$keyword}%")->orWhere('name' , 'LIKE' , "%{$keyword}%" )->orWhere('id' , $keyword);
        }

        if(\request('admin')) {
            $users->where('is_superuser' , 1)->orWhere('is_staff' , 1);
        }

        $users = $users->latest()->paginate(20);
        return view('admin.users.all' , compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($data);

        if($request->has('verify')) {
            $user->markEmailAsVerified();
        }

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user=User::findOrFail($id);

        return view('admin.users.edit' , compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if(! is_null($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $data['password'] = $request->password;
        }

        $user->update($data);

        if($request->has('verify')) {
            $user->markEmailAsVerified();
        }

        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return redirect(route('admin.users.index'));
    }


    public function destroy($id)
    {
        User::destroy($id);
        alert()->success('کاربر با موفقیت حذف شد');
        return back();
    }
}
