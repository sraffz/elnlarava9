@extends('layouts.layoutHalamanUtama')

@section('title', 'Sistem Ke Luar Negara | E-LN')

@section('link')
@endsection

@section('content')
@include('flash::message')

<div class="col-md-12">
          <div class="box">  
            {{-- <div style="background: #ff8080;">
              <div>
                <table class="table">
                  <tr>
                    <td align="right" width="22%"><img src="{{ asset('public/adminlte/dist/img/kelantan.png')}}" width="140" height="100" alt="User Image"></td>
                    <td><h1 style ='font:42px Algerian,sans-serif;color:#080808'>SISTEM E-LUAR NEGARA</h1></td>
                    </tr>
                </table>
              </div>
               
            </div> --}}
            <!-- /.box-header -->
            <div class="box">
               <img class="img-fluid" src="{{ asset('img/banner.png')}}" alt="" width="100%"><br><br>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        @endsection


@section('script')
@endsection

