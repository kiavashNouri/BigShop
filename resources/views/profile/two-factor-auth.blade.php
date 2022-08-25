@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item"><a href="{{url('/profile')}}"
                                                    class="nav-link {{request()->is('profile')?'active':''}}">Index</a>
                            </li>
                            <li class="nav-item"><a href="{{route('profile.2fa-manage')}}"
                                                    class="nav-link {{request()->is('profile/two-factor')?'active':''}}">TwoFactorAuth</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('post.twoFactor-option')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="off">off</option>
                                    <option value="sms">sms</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <button class="btn btn-primary">update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
