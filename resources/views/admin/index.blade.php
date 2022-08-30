@component('admin.layouts.content',['title'=>'Admin Panel'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active"></li>
    @endslot
    <h2>Admin Panel</h2>
@endcomponent
