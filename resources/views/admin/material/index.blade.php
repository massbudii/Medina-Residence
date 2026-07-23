@extends('app')
@section('title', 'Material')

@section('content')
    <div class="col">

        <div class="card mt-3">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Data Material</h2>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah Material
                </button>
            </div>

            <div class="card-body">

                <!-- FILTER -->
                <form method="GET" action="{{ route('material.index') }}" id="filter-form">
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <select name="kawasan_id" class="form-control" id="kawasan-filter"
                                data-type-map='{{ $kawasanTypeMap->toJson() }}'>
                                <option value="">-- Filter Kawasan --</option>
                                @foreach ($kawasans as $kawasan)
                                    <option value="{{ $kawasan->id }}"
                                        {{ request('kawasan_id') == $kawasan->id ? 'selected' : '' }}>
                                        {{ $kawasan->nama_kawasan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select name="type_unit_id" class="form-control" id="type-filter">
                                <option value="">-- Filter Type Unit --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" data-type-id="{{ $type->id }}"
                                        {{ request('type_unit_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->nama_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('material.index') }}" class="btn btn-warning">Reset</a>
                        </div>

                    </div>
                </form>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-start" id="table">
                        <thead>
                            <tr>
                                <th style="width: 1%">No</th>
                                <th>Nama Material</th>
                                <th style="width: 5%">Satuan</th>
                                <th style="width: 4%">Status</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($materials as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_material }}</td>
                                    <td>{{ $item->satuan }}</td>

                                    <td>
                                        @if ($item->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-warning">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td class="text-nowrap">

                                        <!-- EDIT -->
                                        <a href="#" class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}"
                                            title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>

                                        <!-- DELETE -->

                                        @if ($item->status == 'aktif')
                                            <form action="{{ route('material.nonaktif', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    Nonaktif
                                                </button>
                                            </form>
                                        @elseif ($item->status == 'nonaktif')
                                            <form action="{{ route('material.aktif', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= TAMBAH MODAL ================= -->
    <div class="modal fade" id="standard-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('material.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="tambah">

                    <div class="modal-header">
                        <h5>Tambah Material</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label>Nama Material</label>
                            <input type="text" name="nama_material" class="form-control"
                                value="{{ old('nama_material') }}">
                        </div>

                        <div class="mb-2">
                            <label>Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}">
                        </div>

                        <div class="mb-2">
                            <label>Kawasan</label>
                            <select name="kawasan_id" class="form-control" id="kawasan-select-add"
                                data-type-map='{{ $kawasanTypeMap->toJson() }}'>
                                <option value="">-- pilih --</option>
                                @foreach ($kawasanAktif as $kawasan)
                                    <option value="{{ $kawasan->id }}">{{ $kawasan->nama_kawasan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Type Unit</label>
                            <div id="type-unit-container-add">
                                @foreach ($types as $type)
                                    <div class="form-check type-unit-item" data-type-id="{{ $type->id }}">
                                        <input type="checkbox" name="type_unit_id[]" value="{{ $type->id }}">
                                        {{ $type->nama_type }}
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted" id="type-unit-hint-add" style="display:none">Pilih kawasan terlebih dahulu</small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= EDIT MODAL ================= -->
    @foreach ($materials as $item)
        @php
            $selectedKawasan = $item->materialKawasan->pluck('kawasan_id')->first();
            $selectedTypes = $item->materialKawasan->pluck('type_unit_id')->toArray();
        @endphp
        <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('material.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Material</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="nama_material" class="form-control"
                                    value="{{ $item->nama_material }}">
                            </div>

                            <div class="mb-2">
                                <label>Satuan</label>
                                <input type="text" name="satuan" class="form-control" value="{{ $item->satuan }}">
                            </div>

                            <div class="mb-2">
                                <label>Kawasan</label>
                                <select name="kawasan_id" class="form-control kawasan-select-edit"
                                    data-type-map='{{ $kawasanTypeMap->toJson() }}'>
                                    @foreach ($kawasanAktif as $kawasan)
                                        <option value="{{ $kawasan->id }}"
                                            {{ $selectedKawasan == $kawasan->id ? 'selected' : '' }}>
                                            {{ $kawasan->nama_kawasan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label>Type Unit</label>
                                <div class="type-unit-container-edit">
                                    @foreach ($types as $type)
                                        <div class="form-check type-unit-item" data-type-id="{{ $type->id }}">
                                            <input type="checkbox" name="type_unit_id[]" value="{{ $type->id }}"
                                                {{ in_array($type->id, $selectedTypes) ? 'checked' : '' }}>
                                            {{ $type->nama_type }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Update</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endforeach

@endsection
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let modal = "{{ old('modal') }}";

            if (modal === "tambah") {
                let m = new bootstrap.Modal(document.getElementById('standard-modal'));
                m.show();

                setTimeout(function() {
                    $('#table').DataTable().columns.adjust();
                }, 100);
            }

            if (modal && modal.startsWith("edit-")) {
                let id = modal.replace("edit-", "");
                let m = new bootstrap.Modal(document.getElementById('edit-modal' + id));
                m.show();

                setTimeout(function() {
                    $('#table').DataTable().columns.adjust();
                }, 100);
            }

        });
    </script>
@endif

<script>
document.addEventListener("DOMContentLoaded", function() {
    const typeMapRaw = document.getElementById('kawasan-select-add')?.getAttribute('data-type-map')
        || document.getElementById('kawasan-filter')?.getAttribute('data-type-map')
        || '{}';
    const typeMap = JSON.parse(typeMapRaw);

    function filterTypeUnits(selectEl, containerEl) {
        const kawasanId = selectEl.value;
        const allowedTypes = typeMap[kawasanId] || [];
        const items = containerEl.querySelectorAll('.type-unit-item');

        items.forEach(function(item) {
            const typeId = parseInt(item.getAttribute('data-type-id'));
            if (allowedTypes.length === 0 || allowedTypes.includes(typeId)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
                item.querySelector('input[type="checkbox"]').checked = false;
            }
        });
    }

    // === FILTER TYPE UNIT DROPDOWN ===
    const kawasanFilter = document.getElementById('kawasan-filter');
    const typeFilter = document.getElementById('type-filter');

    if (kawasanFilter && typeFilter) {
        function filterTypeDropdown() {
            const kawasanId = kawasanFilter.value;
            const allowedTypes = typeMap[kawasanId] || [];
            const options = typeFilter.querySelectorAll('option[value]');

            options.forEach(function(opt) {
                const typeId = opt.getAttribute('data-type-id');
                if (!typeId) return; // skip "-- Filter Type Unit --"
                if (allowedTypes.length === 0 || allowedTypes.includes(parseInt(typeId))) {
                    opt.hidden = false;
                    opt.disabled = false;
                } else {
                    opt.hidden = true;
                    opt.disabled = true;
                    if (opt.selected) opt.selected = false;
                }
            });
        }

        kawasanFilter.addEventListener('change', filterTypeDropdown);
        if (kawasanFilter.value) filterTypeDropdown();
    }

    // === TAMBAH MODAL ===
    const kawasanSelectAdd = document.getElementById('kawasan-select-add');
    const containerAdd = document.getElementById('type-unit-container-add');

    if (kawasanSelectAdd && containerAdd) {
        kawasanSelectAdd.addEventListener('change', function() {
            filterTypeUnits(this, containerAdd);
        });
        if (kawasanSelectAdd.value) {
            filterTypeUnits(kawasanSelectAdd, containerAdd);
        }
    }

    // === EDIT MODAL ===
    document.querySelectorAll('.kawasan-select-edit').forEach(function(selectEl) {
        const containerEl = selectEl.closest('.modal-body').querySelector('.type-unit-container-edit');

        selectEl.addEventListener('change', function() {
            filterTypeUnits(this, containerEl);
        });
        if (selectEl.value) {
            filterTypeUnits(selectEl, containerEl);
        }
    });
});
</script>
