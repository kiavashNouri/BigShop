@component('admin.layouts.content' , ['title' => 'ویرایش کد تخفیف'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">لیست تخفیف‌ها</a></li>
        <li class="breadcrumb-item active">ویرایش کد تخفیف</li>
    @endslot

    @slot('script')

        <script>
            $('#products').select2({
                'placeholder' : 'محصول مورد نظر را انتخاب کنید'
            })

            $('#categories').select2({
                'placeholder' : 'دسته مورد نظر را انتخاب کنید'
            })
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش کد تخفیف</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.discount.update' , $discount->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">کد تخفیف</label>
                            <input type="code" name="code" class="form-control" id="inputEmail3" placeholder="کد تخفیف را وارد کنید" value="{{ old('code', $discount->code) }}">
                        </div>
                        <div class="form-group">
                            <label for="precent" class="col-sm-2 control-label">میزان تخفیف (درصد)</label>
                            <input type="number" name="precent" class="form-control" placeholder="درصد تخفیف را وارد کنید" value="{{ old('precent',$discount->precent) }}">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ایمیل کاربر استفاده کننده (اختیاری)</label>
                            <input type="email" name="user" class="form-control" placeholder="ایمیل کاربر را وارد کنید" value="{{ old('user',$discount->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">محصول مربوطه (اختیاری)</label>
                            <select class="form-control" name="products[]" id="products" multiple>
                                <option value="null">همه دسته‌ها</option>
                                @foreach(\Modules\Product\Entities\Product::all() as $product)
                                    <option value="{{ $product->id }}" {{ $discount->products && in_array($product->id , $discount->products->pluck('id')->toArray()) ? 'selected' : '' }}>{{ \Modules\Product\Entities\Product::find($product->id)->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">دسته‌بندی مربوطه (اختیاری)</label>
                            <select class="form-control" name="categories[]" id="categories" multiple>
                                <option value="null">همه دسته‌ها</option>
                                @foreach(\App\Category::all() as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id , $discount->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش کد تخفیف</button>
                        <a href="{{ route('admin.discount.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>



@endcomponent
