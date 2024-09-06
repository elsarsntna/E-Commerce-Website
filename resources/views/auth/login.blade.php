@extends('layouts.main')
@section('title')
    <title>Login</title>
@endsection

@section('content')
    <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-2">

                    <span class="app-brand-logo demo me-2">
                        <i class='bx bxs-shopping-bags' style='font-size: 30px;'></i>
                    </span>

                    <span class="app-brand-text demo text-body fw-bolder"> Login</span>

                </div>
                <!-- /Logo -->
                <h4 class="mb-2"> Welcome!</h4>
                <p class="mb-4">Please login to your account</p>
                <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    @if (session('error'))
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input autocomplete="off" type="text"
                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                            name="email" placeholder="Enter your email.." value="{{ old('email') }}" autofocus required>

                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password</label>

                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" autocomplete="off" id="password"
                                class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Log in</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Register -->
    </div>
@endsection
