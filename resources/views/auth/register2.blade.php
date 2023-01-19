@extends('layouts.layoutHalamanUtama')

@section('title', 'SISTEM E-LUAR NEGARA Daftar Pengguna')

@section('link')
<link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}">

@endsection

@section('content')
@include('flash::message')

<main class="py-4">
    <section class="content-header">
        <h1 align="center">
          <img src="{{ asset('img/logoKelantan.png')}}" alt="" height="13%" width="13%">
          <br><p style="font-family: adigiana toybox">SISTEM PERMOHONAN <br> KE LUAR NEGARA</p>
          <br>
        </h1>
        
      </section>
      <div class="col-md-2">
      </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color:#476b6b">{{-- {{ __('Login') }} --}}{{-- Log Masuk --}}&nbsp</div>

                <div class="card-body" style="background-color:#b3cccc">
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <br>
                        <div class="form-group row" align="right">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama Pegawai') }}</label>

                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" required autofocus>

                                @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" align="right">
                            <label for="nokp" class="col-md-4 col-form-label text-md-right">{{ __('No. Kad Pengenalan') }}</label>

                            <div class="col-md-6">
                                <input id="nokp" type="text" class="form-control{{ $errors->has('nokp') ? ' is-invalid' : '' }}" name="nokp" value="{{ old('nokp') }}" required autofocus>

                                @if ($errors->has('nokp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nokp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" align="right">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mel') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row" align="right">
                            <label for="jantina" class="col-md-4 col-form-label text-md-right">{{ __('Jantina') }}</label>

                            <div class="col-md-6">
                                <select name="jantina" id="jantina" class="form-control" required>
                                    <option>Pilih</option>
                                    <option value="Lelaki">Lelaki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" align="right">
                            <label for="jawatan" class="col-md-4 col-form-label text-md-right">Jawatan<span style="color:red;">**</span></label>

                            <div class="col-md-6">
                                <select style="width: 100%;" id="jawatan" class="form-control select2" name="jawatan" required="required">
                                    <option value="" selected="selected"></option>
                                  @foreach($jawatan as $jaw)
                                      <option value="{{ $jaw->idJawatan }}">{{ $jaw->namaJawatan }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        

                         <div class="form-group row" align="right">
                            <label for="gred" class="col-md-4 col-form-label text-md-right">{{ __('Gred') }}</label>
                            
                            <div class="col-md-3">
                                <select style="width: 100%;" id="gredKod" class="form-control select2" name="gredKod" required="required">
                                    <option value="" selected="selected"></option>
                                  @foreach($gredKod as $gredKods)
                                      <option value="{{ $gredKods->gred_kod_ID }}">{{ $gredKods->gred_kod_abjad }}</option>
                                  @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select style="width: 100%;" id="gredAngka" class="form-control select2" name="gredAngka" required="required">
                                    <option value="" selected="selected"></option>
                                  @foreach($gredAngka as $gredAngkas)
                                      <option value="{{ $gredAngkas->gred_angka_ID }}">{{ $gredAngkas->gred_angka_nombor }}</option>
                                  @endforeach
                                </select>
                            </div>

                            
                        </div>

                        <div class="form-group row" align="right">
                            <label for="jabatan" class="col-md-4 col-form-label text-md-right">{{ __('Jabatan') }}</label>

                            <div class="col-md-6">
                                <select style="width: 100%;" id="jabatan" class="form-control select2" name="jabatan" required="required">
                                    <option value="" selected="selected"></option>
                                  @foreach($jabatan as $jab)
                                      <option value="{{ $jab->jabatan_id }}">{{ $jab->nama_jabatan }}({{ $jab->kod_jabatan }})</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" align="right">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Katalaluan') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" align="right">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Pengesahan Katalaluan') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0" align="right">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar') }}
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
                <div class="card-footer" style="background-color:#476b6b">{{-- {{ __('Login') }} --}}{{-- Log Masuk --}}&nbsp</div>
            </div>
        </div>
        <div class="col-md-2">
      </div>
@endsection


@section('script')
<script>
   $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()}
   );
</script>
@endsection


