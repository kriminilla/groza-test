@extends('partials.master')

@section('title', 'GROZA | Lokasi Distributor')

@section('content')

{{-- HEADER --}}
<div class="container-fluid page-header p-0" style="background-image: url('{{ asset('img/Hanasita - 1.png') }}');">
  <div class="container-fluid page-header-inner py-5">
    <div class="container text-center">
      <p class="page-header animated slideInDown">LOKASI DISTRIBUTOR</p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center text-uppercase page-directory">
          <li class="breadcrumb-item"><a href="{{ url('/') }}" class="header-links">GROZA</a></li>
          <li class="breadcrumb-item text-white active" aria-current="page">LOKASI DISTRIBUTOR</li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="container my-5">
  <div class="row g-4">

    {{-- SIDEBAR FILTER --}}
    <div class="col-lg-4 col-md-5">
      <div class="p-4 rounded-4 shadow-lg" style="background-color: #181717;">
        <input type="text" id="searchDistributor" class="form-control mb-3"
               placeholder="Cari nama distributor..."
               style="background-color:#222;border:none;color:#fff;">
        <select id="filterProvince" class="form-select mb-3"
                style="background-color:#222;border:none;color:#fff;">
          <option value="">Semua Provinsi</option>
          @foreach($provinces as $prov)
            <option value="{{ $prov->id }}">{{ $prov->province_name }}</option>
          @endforeach
        </select>
        <select id="filterCity" class="form-select mb-3"
                style="background-color:#222;border:none;color:#fff;">
          <option value="">Semua Kota</option>
          @foreach($cities as $c)
            <option value="{{ $c->id }}">{{ $c->city_name }}</option>
          @endforeach
        </select>

        <div class="d-flex gap-2">
          <button id="btnSearch" class="btn flex-fill fw-bold text-white" style="background-color:#FF6600;">CARI</button>
          <button id="btnReset" class="btn flex-fill fw-bold text-white" style="background-color:#444;">RESET</button>
        </div>
      </div>
    </div>

    {{-- HASIL PETA --}}
    <div class="col-lg-8 col-md-7 position-relative">
      <div class="p-3 rounded-4 shadow-lg position-relative" style="background-color:#181717;">
        <div id="containerResult" class="row g-3">
          {{-- Server-side rendering for initial load --}}
          @foreach($distributorList as $dist)
            <div class="col-lg-6 col-md-12 location-card">
              <div class="card border-0 shadow-sm bg-dark text-light h-100">
                <div class="ratio ratio-4x3">
                  <iframe src="{{ $dist->map_link }}" width="100%" height="100%"
                          style="border:0;border-radius:12px 12px 0 0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="card-body">
                  <h5 class="text-uppercase text-white mb-1">{{ $dist->distributor_name }}</h5>
                  <small class="text-secondary text-white">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $dist->city->city_name ?? '-' }}, {{ $dist->province->province_name ?? '-' }}
                  </small><br/>
                  <small class="text-secondary text-white d-block">{{ $dist->address }}</small>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <p class="text-center text-muted mt-3 d-none" id="no-results-message">
          Tidak ada lokasi distributor ditemukan.
        </p>

        {{-- PAGINATION --}}
        <nav>
          <ul id="pagination" class="pagination justify-content-center mt-4 mb-0"></ul>
        </nav>
      </div>
    </div>
  </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById('searchDistributor');
  const filterProvince = document.getElementById('filterProvince');
  const filterCity = document.getElementById('filterCity');
  const btnSearch = document.getElementById('btnSearch');
  const btnReset = document.getElementById('btnReset');
  const containerResult = document.getElementById('containerResult');
  const noResults = document.getElementById('no-results-message');
  const pagination = document.getElementById('pagination');

  const itemsPerPage = 6;
  let currentPage = 1;
  
  // initial data from server-side blade
  let locationData = @json($distributorList);
  let filteredData = locationData;

  function renderCards(data) {
    containerResult.innerHTML = '';
    if (!data || data.length === 0) {
      noResults.classList.remove('d-none');
      pagination.innerHTML = '';
      return;
    }
    noResults.classList.add('d-none');

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paged = data.slice(start, end);

    paged.forEach(location => {
      // safe defaults for nested props
      const name = location.distributor_name ?? '-';
      const address = location.address ?? '-';
      const link = location.map_link ?? '';
      const city = (location.city && location.city.city_name) ? location.city.city_name : '-';
      const prov = (location.province && location.province.province_name) ? location.province.province_name : '-';

      containerResult.insertAdjacentHTML('beforeend', `
        <div class="col-lg-6 col-md-12 location-card">
          <div class="card border-0 shadow-sm bg-dark text-light h-100">
            <div class="ratio ratio-4x3">
              <iframe src="${link}" width="100%" height="100%"
                      style="border:0;border-radius:12px 12px 0 0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="card-body">
              <h5 class="text-uppercase text-white mb-1">${escapeHtml(name)}</h5>
              <small class="text-secondary text-white">
                <i class="fas fa-map-marker-alt"></i>
                ${escapeHtml(city)}, ${escapeHtml(prov)}
              </small><br/>
              <small class="text-secondary text-white d-block">${escapeHtml(address)}</small>
            </div>
          </div>
        </div>
      `);
    });

    renderPagination(data.length);
  }

  function renderPagination(totalItems) {
    pagination.innerHTML = '';
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    if (totalPages <= 1) return;

    pagination.insertAdjacentHTML('beforeend', `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link bg-dark text-white border-secondary" href="#" data-page="${currentPage - 1}">« Prev</a>
      </li>`);

    for (let i = 1; i <= totalPages; i++) {
      pagination.insertAdjacentHTML('beforeend', `
        <li class="page-item ${currentPage === i ? 'active' : ''}">
          <a class="page-link bg-dark text-white border-secondary" href="#" data-page="${i}">${i}</a>
        </li>`);
    }

    pagination.insertAdjacentHTML('beforeend', `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link bg-dark text-white border-secondary" href="#" data-page="${currentPage + 1}">Next »</a>
      </li>`);
  }

  // delegation for pagination links (uses closest to be resilient)
  pagination.addEventListener('click', e => {
    const a = e.target.closest('a');
    if (!a) return;
    e.preventDefault();
    const page = parseInt(a.dataset.page, 10);
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    if (Number.isInteger(page) && page >= 1 && page <= totalPages) {
      currentPage = page;
      renderCards(filteredData);
      // scroll to top of hasil container on page change (nice UX)
      containerResult.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });

  // AJAX request to server filter endpoint
  function fetchFilteredData() {
    const params = new URLSearchParams({
      search: searchInput.value.trim(),
      province_id: filterProvince.value,
      city_id: filterCity.value
    });
    
    // **PASTIKAN ROUTE-nya sudah didefinisikan untuk location.filter**
    fetch(`{{ route('distributor.filter') }}?${params.toString()}`)
      .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
      })
      .then(data => {
        // pastikan array
        filteredData = Array.isArray(data) ? data : [];
        currentPage = 1;
        renderCards(filteredData);
      })
      .catch(err => {
        console.error('Error filter location:', err);
        // fallback: show no-results (but don't block UI)
        filteredData = [];
        currentPage = 1;
        renderCards(filteredData);
      });
  }

  btnSearch.addEventListener('click', function(e) {
    e.preventDefault();
    fetchFilteredData();
  });

  // support Enter key in search input
  searchInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      fetchFilteredData();
    }
  });

  btnReset.addEventListener('click', function(e) {
    e.preventDefault();
    searchInput.value = '';
    filterProvince.value = '';
    filterCity.value = '';
    filteredData = locationData;
    currentPage = 1;
    renderCards(filteredData);
  });

  // ketika provinsi berubah → update dropdown kota
  filterProvince.addEventListener('change', function() {
    const provinceId = this.value;

    // reset dropdown kota
    filterCity.innerHTML = '<option value="">Semua Kota</option>';

    if (!provinceId) {
      // kalau provinsi dikosongkan, tampilkan semua kota lagi
      @foreach($cities as $c)
        filterCity.insertAdjacentHTML('beforeend', `<option value="{{ $c->id }}">{{ $c->city_name }}</option>`);
      @endforeach
      return;
    }

    // ambil kota berdasarkan provinsi (AJAX)
    fetch(`/cities/by-province/${provinceId}`)
      .then(res => res.json())
      .then(cities => {
        cities.forEach(city => {
          filterCity.insertAdjacentHTML('beforeend', `
            <option value="${city.id}">${city.city_name}</option>
          `);
        });
      })
      .catch(err => console.error('Gagal memuat kota:', err));
  });

  // simple HTML-escape to avoid XSS when inserting text from JSON
  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  // initial render: show all locations (no loader)
  renderCards(locationData);
});
</script>

{{-- STYLING --}}
<style>
.card {
  border-radius: 12px !important;
  overflow: hidden;
  transition: transform 0.2s ease-in-out;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}
.page-item.active .page-link {
  background-color: #b30000 !important;
  border-color: #b30000 !important;
}
@media (max-width: 768px) {
  .col-lg-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>

@endsection