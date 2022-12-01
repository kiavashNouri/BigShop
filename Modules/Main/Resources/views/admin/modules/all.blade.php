@component('admin.layouts.content' , ['title' => 'مدیریت ماژول‌ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">مدیریت ماژول‌ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ماژول‌ها</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @foreach($modules as $module)
                            @php
                                $moduleData = new \Nwidart\Modules\Json($module->getPath() . '\module.json');
                            @endphp
                            <div class="col-sm-2">
                                <div class="mt-3">
                                    <h4>{{ $moduleData->get('alias') }}</h4>
                                    <p>{{ $moduleData->get('description') }}</p>
                                </div>


                                @if(Module::canDisable($module->getName()))
                                    @if(Module::isEnable($module->getName()))
                                        <form action="{{ route('admin.modules.disable' , ['module' => $module->getName() ]) }}" method="post" id="{{ $module->getName() }}-disable">
                                            @method('PATCH')
                                            @csrf
                                        </form>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('{{ $module->getName() }}-disable').submit()" class="btn btn-sm btn-danger">غیرفعالسازی</a>
                                    @else
                                        <form action="{{ route('admin.modules.enable' , ['module' => $module->getName() ]) }}" method="post" id="{{ $module->getName() }}-enable">
                                            @method('PATCH')
                                            @csrf
                                        </form>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('{{ $module->getName() }}-enable').submit()" class="btn btn-sm btn-primary">فعالسازی</a>
                                    @endif
                                @endif

                            </div>

                            {{--                            <div class="col-sm-2">--}}
                            {{--                                <a href="{{ url($image->image) }}">--}}
                            {{--                                    <img src="{{ url($image->image) }}" class="img-fluid mb-2" alt="{{ $image->alt }}">--}}
                            {{--                                </a>--}}
                            {{--                                <form action="{{ route('admin.products.gallery.destroy' , ['product' => $product->id , 'gallery' => $image->id]) }}" id="image-{{ $image->id }}" method="post">--}}
                            {{--                                    @method('delete')--}}
                            {{--                                    @csrf--}}
                            {{--                                </form>--}}
                            {{--                                <a href="{{ route('admin.products.gallery.edit' , ['product' => $product->id , 'gallery' => $image->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>--}}
                            {{--                                <a href="#" class="btn btn-sm btn-danger" onclick="document.getElementById('image-{{ $image->id }}').submit()">حذف</a>--}}
                            {{--                            </div>--}}
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{--                    {{ $images->render() }}--}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
