@component('admin.layouts.content' , ['title' => 'لیست دسته بندی ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست دسته بندی ها</li>
    @endslot

    @slot('head')
        <style>
            li.list-group-item > ul.list-group {
                margin-top: 10px;
            }
        </style>
    @endslot
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">دسته بندی ها</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-1">
                            @can('create-category')
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-info">ایجاد دسته جدید</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    @include('admin.layouts.categories-group' , ['categories' => $categories])
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $categories->appends([ 'search' => request('search') ])->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent
