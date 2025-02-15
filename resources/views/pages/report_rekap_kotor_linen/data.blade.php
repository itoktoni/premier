<table border="0" class="header">
	<tr>
		<td></td>
		<td colspan="6">
			<h3>
				<b>REKAP KOTOR BERDASARKAN JENIS LINEN</b>
			</h3>
		</td>
		<td rowspan="3">
			<x-logo/>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="10">
			<h3>
				RUMAH SAKIT : {{ $rs->field_name ?? 'Semua Rumah Sakit' }}
			</h3>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="10">
			<h3>
				RUANGAN : {{ $ruangan->field_name ?? 'Semua Ruangan' }}
			</h3>
		</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="10">
            <h3>
				Tanggal Kotor : {{ formatDate(request()->get('start_rekap')) }} - {{ formatDate(request()->get('end_rekap')) }}
			</h3>
		</td>
	</tr>
</table>
<div class="table-responsive" id="table_data">
	<table id="export" border="1" style="border-collapse: collapse !important; border-spacing: 0 !important;"
		class="table table-bordered table-striped table-responsive-stack">
		<thead>
            <tr>
                <th style="width: 200px" width="20">Nama Ruangan</th>
                <th style="width: 200px" width="20">Nama Linen</th>
				@foreach($tanggal as $tgl)
                <th>{{ formatDate($tgl, 'd') }}</th>
                @endforeach
            </tr>
        </thead>
		<tbody>
            @php
                $sum_kurang = $sum_lebih = $sum_per_linen = $sum_kotor = $sum_beda_rs = $sum_kg = $sum_lawan = 0;
                $total_number = $selisih = 0;
                $total_lawan = 0;
            @endphp

			@forelse ($location as $loc_id => $loc_name)
			<tr>
				<td rowspan="{{ count($linen) + 1 }}">{{ $loc_name }}</td>
			</tr>

				@forelse ($linen as $jenis_id => $jenis_name)
					<tr>
						<td>{{ $jenis_name }}</td>
							@foreach($tanggal as $tgl)
							<td>
								@php
								$total_tanggal = $kotor
									->where('view_tanggal', $tgl->format('Y-m-d'))
									->where('view_ruangan_id', $loc_id)
									->where('view_linen_id', $jenis_id)
									;
								@endphp

								{{ $total_tanggal->sum('view_qty') }}
							</td>
							@endforeach
					</tr>
				@empty
				@endforelse

			@empty

			@endforelse


		</tbody>
	</table>
</div>