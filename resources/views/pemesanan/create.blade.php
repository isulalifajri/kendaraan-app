@extends('layouts.main')

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Pemesanan /</span> Tambah
</h4>

<div class="card">
    <div class="card-body">

        <form action="{{ route('pemesanan.store') }}" method="POST">
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
                                {{ old('kendaraan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kendaraan }} - {{ $k->nomor_polisi }}
                            </option>
                        @endforeach
                    </select>
                    @error('kendaraan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Driver -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Driver</label>
                    <select name="driver_id"
                        class="form-select @error('driver_id') is-invalid @enderror">
                        <option value="">-- Pilih Driver --</option>
                        @foreach($driver as $d)
                            <option value="{{ $d->id }}"
                                {{ old('driver_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        value="{{ old('tanggal_mulai') }}">
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        value="{{ old('tanggal_selesai') }}">
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tujuan -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text" name="tujuan"
                        class="form-control @error('tujuan') is-invalid @enderror"
                        value="{{ old('tujuan') }}">
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Penyetuju Level 1 -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penyetuju Level 1</label>
                    <select name="penyetuju_level_1"
                        class="form-select @error('penyetuju_level_1') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($penyetuju as $p)
                            <option value="{{ $p->id }}"
                                {{ old('penyetuju_level_1') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('penyetuju_level_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Penyetuju Level 2 -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penyetuju Level 2</label>
                    <select name="penyetuju_level_2"
                        class="form-select @error('penyetuju_level_2') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($penyetuju as $p)
                            <option value="{{ $p->id }}"
                                {{ old('penyetuju_level_2') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('penyetuju_level_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>
</div>

@endsection