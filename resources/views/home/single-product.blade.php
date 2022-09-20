@extends('layouts.app')

@section('script')
    <script>
        $('#sendComment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var subject_id = button.data('id'); // Extract info from data-* attributes
            var subject_type = button.data('type'); // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body #subject_id').val(subject_id)
            modal.find('.modal-body #subject_type').val(subject_type)
        })
    </script>
@endsection

@section('content')

    <div class="modal fade" id="sendComment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>
                    <button type="button" class="close mr-auto ml-0" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="subject_id" id="subject_id">
                        <input type="hidden" name="subject_type" id="subject_type">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-primary">ارسال نظر</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>

                    <div class="card-body">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                <div class="d-flex align-items-center justify-content-between">--}}
{{--                    <h4 class="mt-4">بخش نظرات</h4>--}}
{{--                    <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="1" data-type="product">ثبت نظر جدید</span>--}}

{{--                </div>--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header d-flex justify-content-between">--}}
{{--                        <div class="commenter">--}}
{{--                            <span>نام نظردهنده</span>--}}
{{--                            <span class="text-muted">- دو دقیقه قبل</span>--}}
{{--                        </div>--}}
{{--                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="2" data-type="product">پاسخ به نظر</span>--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}
{{--                        محصول زیبایه--}}

{{--                        <div class="card mt-3">--}}
{{--                            <div class="card-header d-flex justify-content-between">--}}
{{--                                <div class="commenter">--}}
{{--                                    <span>نام نظردهنده</span>--}}
{{--                                    <span class="text-muted">- دو دقیقه قبل</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="card-body">--}}
{{--                                محصول زیبایه--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
