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
                    {{ old('kendaraan_id', $bbm->kendaraan_id ?? '') == $k->id ? 'selected' : '' }}>
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
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal"
            class="form-control @error('tanggal') is-invalid @enderror"
            value="{{ old('tanggal', $bbm->tanggal ?? '') }}">

        @error('tanggal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Liter -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Berapa Liter?</label>
        <input type="number" name="liter"
            class="form-control @error('liter') is-invalid @enderror"
            value="{{ old('liter', $bbm->liter ?? '') }}">

        @error('liter')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Biaya -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Biaya</label>
        <input type="number" name="biaya"
            class="form-control @error('biaya') is-invalid @enderror"
            value="{{ old('biaya', $bbm->biaya ?? '') }}">

        @error('biaya')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Keterangan -->
    <div class="col-md-12 mb-3">
        <label class="form-label">Keterangan</label>
        <input type="text" name="keterangan"
            class="form-control @error('keterangan') is-invalid @enderror"
            value="{{ old('keterangan', $bbm->keterangan ?? '') }}">

        @error('keterangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>