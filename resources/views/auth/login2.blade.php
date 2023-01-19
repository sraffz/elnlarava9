@extends('layouts.layoutHalamanUtama')

@section('title', 'SISTEM E-LUAR NEGARA Log Masuk')

@section('link')
@endsection

@section('content')
    @include('flash::message')
    <main class="py-4">
        <section class="content-header">
            <h1 align="center">
                <img src="{{ asset('img/logoKelantan.png') }}" alt="" height="13%" width="13%">
                <br>
                <p style="font-family: adigiana toybox">SISTEM PERMOHONAN <br> KE LUAR NEGARA</p>
                <br>
            </h1>

        </section>
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color:#476b6b">{{-- {{ __('Login') }} --}}{{-- Log Masuk --}}&nbsp
                </div>
                <div class="card-body" style="background-color:#b3cccc">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <br>
                        <div class="form-group row" align="right">
                            <label for="nokp"
                                class="col-sm-4 col-form-label text-md-right">{{ __('No. Kad Pengenalan') }}</label>

                            <div class="col-md-6">
                                <input id="nokp" type="text"
                                    class="form-control{{ $errors->has('nokp') ? ' is-invalid' : '' }}" name="nokp"
                                    value="{{ old('nokp') }}" required autofocus>

                                @if ($errors->has('nokp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nokp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" align="right">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('KataLaluan') ? ' is-invalid' : '' }}"
                                    name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Log Masuk') }}
                                </button>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    @endsection


    @section('script')
    @endsection
