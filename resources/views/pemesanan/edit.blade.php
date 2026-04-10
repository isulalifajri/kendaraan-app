@extends('layouts.main')

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Pemesanan /</span> Edit
</h4>

<div class="card">
    <div class="card-body">

        <form action="{{ route('pemesanan.update', $pemesanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Kendaraan -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kendaraan</label>
                    <select name="kendaraan_id"
                        class="form-select @error('kendaraan_id') is-invalid @enderror">
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($kendaraan as $k)
                            <option value="{{ $k->id }}"
                                {{ old('kendaraan_id', $pemesanan->kendaraan_id) == $k->id ? 'selected' : '' }}>
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
                                {{ old('driver_id', $pemesanan->driver_id) == $d->id ? 'selected' : '' }}>
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
                        value="{{ old('tanggal_mulai', $pemesanan->tanggal_mulai) }}"
                        class="form-control @error('tanggal_mulai') is-invalid @enderror">
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        value="{{ old('tanggal_selesai', $pemesanan->tanggal_selesai) }}"
                        class="form-control @error('tanggal_selesai') is-invalid @enderror">
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tujuan -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text" name="tujuan"
                        value="{{ old('tujuan', $pemesanan->tujuan) }}"
                        class="form-control @error('tujuan') is-invalid @enderror">
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Penyetuju Level 1 -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penyetuju Level 1</label>
                    <select class="form-select" disabled>
                        @foreach($penyetuju as $p)
                            <option value="{{ $p->id }}"
                                {{ old('penyetuju_level_1', $pemesanan->persetujuan->where('level',1)->first()->penyetuju_id ?? '') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- hidden biar tetap ke kirim -->
                    <input type="hidden" name="penyetuju_level_1"
                        value="{{ old('penyetuju_level_1', $pemesanan->persetujuan->where('level',1)->first()->penyetuju_id ?? '') }}">
                </div>

                <!-- Penyetuju Level 2 -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penyetuju Level 2</label>
                    <select class="form-select" disabled>
                        @foreach($penyetuju as $p)
                            <option value="{{ $p->id }}"
                                {{ old('penyetuju_level_2', $pemesanan->persetujuan->where('level',2)->first()->penyetuju_id ?? '') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden" name="penyetuju_level_2"
                        value="{{ old('penyetuju_level_2', $pemesanan->persetujuan->where('level',2)->first()->penyetuju_id ?? '') }}">
                </div>

            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>
</div>

@endsection