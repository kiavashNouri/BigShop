@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item"><a href="{{url('/profile')}}" class="nav-link {{request()->is('profile')?'active':''}}">Index</a></li>
                            <li class="nav-item"><a href="{{route('profile.2fa-manage')}}" class="nav-link {{request()->is('profile/two-factor')?'active':''}}">TwoFactorAuth</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h3>profile</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
