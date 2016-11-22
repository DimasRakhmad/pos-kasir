
<html style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: sans-serif;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;font-size: 10px;-webkit-tap-highlight-color: rgba(0,0,0,0);">
<head style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
	<meta charset="UTF-8" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
	<title style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
		 
	</title>
	
</head>
<body style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;background-color: #fff;min-height: 100%;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;font-weight: 400;overflow-x: hidden;overflow-y: auto;">
	<div class="container" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
		@foreach($items as $item)
		<div class="row" style=" -webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-right: -15px;margin-left: -15px;">
			<div class="col-md-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;width: 100%;">
				<table width="100%" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;border-spacing: 0;border-collapse: collapse;background-color: transparent;">
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td colspan="6" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;"><center style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><h1 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: .67em 0;font-size: 36px;font-family: 'Source Sans Pro',sans-serif;font-weight: 500;line-height: 1.1;color: inherit;margin-top: 20px;margin-bottom: 10px;">CV. Jaya Maju</h1> <h3 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;page-break-after: avoid;font-family: 'Source Sans Pro',sans-serif;font-weight: 500;line-height: 1.1;color: inherit;margin-top: 20px;margin-bottom: 10px;font-size: 24px;">SLIP GAJI</h3></center></td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td width="20%" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">
							<label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;">Tanggal</label>
						</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td colspan="4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">{{$item->tanggal}}</td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">
							<label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;">Nama</label>
						</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td colspan="4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">{{$item->karyawan->nama}}</td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td colspan="3" align="center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">
							<label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;">Penerima</label>
						</td>
						<td colspan="3" align="center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">
							<label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;">Potongan</label>
						</td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Gaji Pokok</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Rp {{ number_format($item->gaji_pokok, 2, ",", ".")}}</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Potongan Absen</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Rp {{ number_format($item->potongan_absen, 2, ",", ".")}}</td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Upah Lembur</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Rp {{ number_format($item->upah_lembur, 2, ",", ".")}}</td>
						<td width="20%" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Potongan Kasbon</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Rp {{ number_format($item->potongan_kasbon, 2, ",", ".")}}</td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Uang Makan</td>
						<td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">:</td>
						<td colspan="4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">Rp {{ number_format($item->uang_makan, 2, ",", ".")}}</td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
						<td colspan="4" align="right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;"></td>
						<td colspan="2" align="left" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;"><label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: 700;">Total Gaji : Rp {{ number_format($item->total_gaji, 2, ",", ".")}}</label></td>
					</tr>
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
					<td colspan="4 " align="right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;"></td>
					<td colspan="2" align="center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;"><br>Disetujui oleh, _________<br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"></td>
					</tr>
					
					<tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
					<td colspan="4" align="right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;"></td>
					<td colspan="2" align="center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;">(_____________)</td>
					</tr>
					
				</table>
			</div>
		</div>
		@endforeach
	</div>
	
</body>
</html>