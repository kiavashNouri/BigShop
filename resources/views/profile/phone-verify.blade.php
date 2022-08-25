@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Active Phone Number
                    </div>
                    <div class="card-body">
                        <form action="{{route('profile.2fa.phone')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="token">Token</label>
                                <input type="text" class="form-control @error('token') is-invalid @enderror" name="token" placeholder="please enter token">
                                @error('token')
                                <span>{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-primary">Validate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
