@csrf

<div class="row">

    <!-- Kendaraan -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Kendaraan</label>
        <select name="kendaraan_id"
            class="form-select @error('kendaraan_id') is-invalid @enderror">

            <option value="">-- Pilih Kendaraan --</option>

            @foreach($kendaraan as $k)
                <option value="{{ $k->id }}"
                    {{ old('kendaraan_id', $service->kendaraan_id ?? '') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kendaraan }} - {{ $k->nomor_polisi }}
                </option>
            @endforeach

        </select>

        @error('kendaraan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tanggal -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Service</label>
        <input type="date" name="tanggal_service"
            class="form-control @error('tanggal_service') is-invalid @enderror"
            value="{{ old('tanggal_service', $service->tanggal_service ?? '') }}">

        @error('tanggal_service')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Keterangan -->
    <div class="col-md-12 mb-3">
        <label class="form-label">Keterangan</label>
        <input type="text" name="keterangan"
            class="form-control @error('keterangan') is-invalid @enderror"
            value="{{ old('keterangan', $service->keterangan ?? '') }}">

        @error('keterangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status"
            class="form-select @error('status') is-invalid @enderror">

            @foreach($status as $s)
                <option value="{{ $s }}"
                    {{ old('status', $service->status ?? '') == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach

        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>