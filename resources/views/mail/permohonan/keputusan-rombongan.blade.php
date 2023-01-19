@component('mail::message')
Tuan/Puan, <br>

#<u>PEMAKLUMAN KELULUSAN PERMOHONAN ROMBONGAN KELUAR NEGARA</u> 

Berikut adalah status kelulusan permohonan rombongan keluar negara (ELN).
<br>
<br>
Negara: <strong>{{ $negaraRom }} </strong> <br>
Tarikh Perjalan: <strong>{{ $tarikhMulaRom }}</strong>  <br>
Tarikh Kembali: <strong>{{ $tarikhAkhirRom }}</strong> <br>
Status Kelulusan: <strong>{{ $keputusan }}</strong>
<br><br>
Surat/memo keputusan boleh dimuat turun di pautan : 
@component('mail::button', ['url' => url('/keputusan-rombongan')])
Surat/Memo
@endcomponent

Sekian, terima kasih. 
<br>
<br>


Yang menjalankan amanah,<br>
Sistem e-Luar Negara 
(SUK Negeri Kelantan)
@endcomponent
