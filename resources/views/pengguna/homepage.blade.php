@extends('layouts.eln')

@section('title', 'Halaman Utama')

@section('link')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Halaman Utama</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Halaman Utama</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('flash::message')
            <div class="row">
                <div class="col-lg-3">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $TotalPerm+$TotalPermRomb }}</h3>
                            <p>Jumlah Permohonan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selanjut <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $TotalBerjaya+$TotalBerjayaRomb }}</h3>
                            <p>Permohonan Berjaya</p>
                        </div>
                        <div class="icon">
                            <i class="fa  fa-check-square"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selanjut <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $TotalGagal + $TotalGagalRomb}}</h3>
                            <p>Permohonan Gagal</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-minus-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selanjut <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $TotalProces + $TotalProcesRomb }}</h3>
                            <p>Permohonan dalam proses</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-spinner"></i>
                        </div>
                        <a href="#" class="small-box-footer">Selanjut <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="timeline timeline-inverse">
                        <!-- timeline time label -->
                        @foreach ($senarai as $sena)
                            <div class="time-label">
                                @if ($sena->statusPermohonan == 'Permohonan Berjaya')
                                    <span class="bg-success">
                                    @elseif($sena->statusPermohonan =="Permohonan Gagal")
                                        <span class="bg-danger">
                                @endif
                                {{ date('d-m-Y', strtotime($sena->tarikhLulusan)) }}
                                </span>
                            </div>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <div>
                                <i class="fas fa-envelope bg-primary"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header"><a href="#">{{ $sena->negara }}</a>
                                        ({{ $sena->JenisPermohonan }})</h3>
                                    <div class="timeline-body">
                                        Status Permohonan : {{ $sena->statusPermohonan }}
                                        <br>
                                        Tarikh Mula Urusan : {{ date('d-m-Y', strtotime($sena->tarikhMulaPerjalanan)) }}
                                        <br>
                                        Tujuan : {{ $sena->lainTujuan }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- END timeline item -->
                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection
