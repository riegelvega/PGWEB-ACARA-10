<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persebaran Kantor Organisasi Perangkat Daerah Kabupaten Belitung</title>

    <!-- Leaflet CSS Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
    <!-- Leaflet Measure CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-measure@3.1.0/dist/leaflet-measure.css">
    <!-- Leaflet Fullscreen CSS -->
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css">
    <!-- Leaflet Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        /* Navbar Sederhana dan Standar */
        .navbar {
            height: 48px;
            background-color: #ffffffff;
            color: #000000ff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            border-bottom: 1px solid #ffffffff;
            position: relative;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .navbar-menu {
            display: flex;
            gap: 8px;
        }

        .btn {
            font-size: 12px;
            font-weight: 500;
            padding: 5px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .btn-default {
            background-color: #ffffff;
            color: #333333;
            border-color: #cccccc;
        }

        .btn-default:hover {
            background-color: #e6e6e6;
        }

        .btn-primary {
            background-color: #0d6efd;
            color: #ffffff;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #ffffff;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
        }

        /* Area Peta */
        #map {
            height: calc(100% - 48px);
            width: 100%;
        }

        /* Modal Overlay */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.45);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 900px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }

        .modal-card-form {
            max-width: 480px;
        }

        .modal-header {
            padding: 10px 15px;
            background-color: #f1f3f5;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #212529;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 18px;
            color: #6c757d;
            cursor: pointer;
            padding: 0 4px;
            line-height: 1;
        }

        .btn-close:hover {
            color: #212529;
        }

        .modal-body {
            padding: 15px;
            overflow-y: auto;
            flex: 1;
        }

        /* Toolbar Tabel */
        .toolbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 10px;
        }

        .input-search {
            flex: 1;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .input-search:focus {
            outline: none;
            border-color: #86b7fe;
        }

        /* Tabel Data Standar */
        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #dee2e6;
        }

        table.gis-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: left;
        }

        table.gis-table th {
            background-color: #f8f9fa;
            color: #495057;
            padding: 8px 10px;
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
            white-space: nowrap;
        }

        table.gis-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #dee2e6;
            color: #212529;
        }

        table.gis-table tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        table.gis-table tbody tr:hover {
            background-color: #f1f3f5;
        }

        /* Tombol Aksi Tabel */
        .btn-xs {
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 3px;
            border: 1px solid transparent;
            cursor: pointer;
            margin-right: 3px;
        }

        .btn-action-view {
            background-color: #e7f1ff;
            color: #0c63e4;
            border-color: #b6d4fe;
        }

        .btn-action-view:hover {
            background-color: #cfe2ff;
        }

        .btn-action-edit {
            background-color: #fff3cd;
            color: #664d03;
            border-color: #ffecb5;
        }

        .btn-action-edit:hover {
            background-color: #ffe69c;
        }

        .btn-action-delete {
            background-color: #f8d7da;
            color: #842029;
            border-color: #f5c2c7;
        }

        .btn-action-delete:hover {
            background-color: #f1aeb5;
        }

        /* Form Style */
        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .form-control:focus {
            outline: none;
            border-color: #86b7fe;
        }

        .row-two-col {
            display: flex;
            gap: 10px;
        }

        .row-two-col .form-group {
            flex: 1;
        }

        .btn-picker {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #495057;
            width: 100%;
            padding: 5px;
            font-size: 11px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .btn-picker:hover {
            background-color: #e9ecef;
        }

        .modal-footer {
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 6px;
        }

        /* Notifikasi Toast Minimalis */
        .toast-msg {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background-color: #212529;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 3000;
            transition: transform 0.25s ease, opacity 0.25s ease;
            opacity: 0;
            pointer-events: none;
        }

        .toast-msg.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body>
    <!-- Navbar Header -->
    <header class="navbar">
        <div class="navbar-brand">
            WebGIS Persebaran Kantor Organisasi Perangkat Daerah Kabupaten Belitung
        </div>
        <div class="navbar-menu">
            <button class="btn btn-default" onclick="openTableModal()">
                Tabel Data
            </button>
            <button class="btn btn-primary" onclick="openFormModal()">
                Tambah Data
            </button>
        </div>
    </header>

    <!-- Leaflet Libraries -->
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-measure@3.1.0/dist/leaflet-measure.js"></script>
    <script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Peta -->
    <div id="map"></div>

    <!-- Modal Tabel Data -->
    <div id="modalTable" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h4>Data Lokasi OPD</h4>
                <button class="btn-close" onclick="closeTableModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="toolbar">
                    <input type="text" id="tableSearch" class="input-search"
                        placeholder="Cari data nama dinas, alamat, atau keterangan..." onkeyup="filterTable()">
                    <button class="btn btn-primary" onclick="closeTableModal(); openFormModal();">
                        Tambah Data
                    </button>
                </div>
                <div class="table-wrapper">
                    <table class="gis-table" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width: 35px; text-align: center;">No</th>
                                <th>Nama Dinas</th>
                                <th>Alamat</th>
                                <th style="width: 85px;">Latitude</th>
                                <th style="width: 85px;">Longitude</th>
                                <th>Keterangan</th>
                                <th style="width: 140px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="7" style="text-align: center; color: #6c757d; padding: 15px;">Memuat
                                    data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeTableModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah / Edit -->
    <div id="modalForm" class="modal-overlay">
        <div class="modal-card modal-card-form">
            <div class="modal-header">
                <h4 id="formModalTitle">Tambah Lokasi OPD</h4>
                <button class="btn-close" onclick="closeFormModal()">&times;</button>
            </div>
            <form id="opdForm" onsubmit="submitForm(event)">
                <div class="modal-body">
                    <input type="hidden" id="formId" name="id" value="">

                    <div class="form-group">
                        <label for="nama_dinas">Nama Dinas / Kantor OPD *</label>
                        <input type="text" id="nama_dinas" name="nama_dinas" class="form-control"
                            placeholder="Masukkan nama dinas" required>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Alamat / Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" class="form-control"
                            placeholder="Masukkan alamat atau lokasi">
                    </div>

                    <div class="row-two-col">
                        <div class="form-group">
                            <label for="latitude">Latitude *</label>
                            <input type="text" id="latitude" name="latitude" class="form-control"
                                placeholder="-2.739634" required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude *</label>
                            <input type="text" id="longitude" name="longitude" class="form-control"
                                placeholder="107.633555" required>
                        </div>
                    </div>

                    <button type="button" class="btn-picker" onclick="enableMapPicker()">
                        Ambil Koordinat dari Peta
                    </button>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="2"
                            placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeFormModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitForm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notifikasi Toast -->
    <div id="toastNotification" class="toast-msg">Notifikasi</div>

    <script>
        /* Initial Map (Pusat: Bundaran Satam, Tanjungpandan, Belitung) */
        var initialLat = -2.739634;
        var initialLng = 107.633555;
        var initialZoom = 14;

        var map = L.map('map').setView([initialLat, initialLng], initialZoom);

        /* Basemaps */
        var basemap1 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        });

        var basemap_osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var basemap2 = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: 'Map data &copy; Google'
        });

        basemap_osm.addTo(map);

        /* Layer Group */
        var dbLayer = L.layerGroup().addTo(map);

        var rawDataList = [];
        var markerRefs = {};

        /* Ambil Data dari Database */
        function loadLocations() {
            fetch('get_lokasi.php')
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    rawDataList = data || [];
                    renderMarkers();
                    renderTable();
                })
                .catch(function (error) {
                    console.error("Gagal memuat data:", error);
                    showToast("Gagal memuat data dari database.");
                });
        }

        /* Render Marker */
        function renderMarkers() {
            dbLayer.clearLayers();
            markerRefs = {};

            rawDataList.forEach(function (item) {
                if (item.latitude && item.longitude) {
                    var lat = parseFloat(item.latitude);
                    var lng = parseFloat(item.longitude);
                    var id = item.no;

                    var popupContent = `
                        <div style="min-width: 160px; font-size: 12px;">
                            <strong style="font-size: 13px; color: #212529;">${item.nama_dinas || 'Tanpa Nama'}</strong>
                            <div style="margin-top: 4px;"><b>Alamat:</b> ${item.lokasi || '-'}</div>
                            <div><b>Keterangan:</b> ${item.keterangan || '-'}</div>
                            <div style="color: #6c757d; font-size: 11px; margin-top: 2px;">Koordinat: ${lat}, ${lng}</div>
                            <hr style="margin: 6px 0; border: none; border-top: 1px solid #dee2e6;">
                            <div style="text-align: right;">
                                <a href="javascript:void(0)" onclick="editLocationById(${id})" style="color: #0d6efd; text-decoration: none; font-size: 11px; font-weight: 600; margin-right: 8px;">Edit</a>
                                <a href="javascript:void(0)" onclick="deleteLocation(${id}, '${escapeStr(item.nama_dinas)}')" style="color: #dc3545; text-decoration: none; font-size: 11px; font-weight: 600;">Hapus</a>
                            </div>
                        </div>
                    `;

                    var marker = L.marker([lat, lng]).bindPopup(popupContent);
                    dbLayer.addLayer(marker);

                    if (id !== undefined && id !== null && id !== '') {
                        markerRefs[id] = marker;
                    }
                }
            });
        }

        /* Render Tabel Modal */
        function renderTable(keyword = '') {
            var tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            var filtered = rawDataList.filter(function (item) {
                if (!keyword) return true;
                var kw = keyword.toLowerCase();
                return (item.nama_dinas && item.nama_dinas.toLowerCase().includes(kw)) ||
                    (item.lokasi && item.lokasi.toLowerCase().includes(kw)) ||
                    (item.keterangan && item.keterangan.toLowerCase().includes(kw));
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: #6c757d; padding: 15px;">Data tidak ditemukan.</td></tr>`;
                return;
            }

            filtered.forEach(function (item, index) {
                var tr = document.createElement('tr');
                var lat = item.latitude || '-';
                var lng = item.longitude || '-';
                var id = item.no;

                tr.innerHTML = `
                    <td style="text-align: center;">${index + 1}</td>
                    <td><strong>${item.nama_dinas || '-'}</strong></td>
                    <td>${item.lokasi || '-'}</td>
                    <td>${lat}</td>
                    <td>${lng}</td>
                    <td>${item.keterangan || '-'}</td>
                    <td style="text-align: center;">
                        <button class="btn-xs btn-action-view" onclick="zoomToFeature(${id}, ${lat}, ${lng})">Lihat</button>
                        <button class="btn-xs btn-action-edit" onclick="editLocationById(${id})">Edit</button>
                        <button class="btn-xs btn-action-delete" onclick="deleteLocation(${id}, '${escapeStr(item.nama_dinas)}')">Hapus</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function filterTable() {
            var kw = document.getElementById('tableSearch').value;
            renderTable(kw);
        }

        function zoomToFeature(id, lat, lng) {
            closeTableModal();
            if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
                map.flyTo([lat, lng], 17, { duration: 1.2 });
                if (markerRefs[id]) {
                    setTimeout(function () {
                        markerRefs[id].openPopup();
                    }, 1250);
                }
            } else {
                showToast("Koordinat tidak valid.");
            }
        }

        function openTableModal() {
            document.getElementById('modalTable').classList.add('active');
            renderTable(document.getElementById('tableSearch').value);
        }

        function closeTableModal() {
            document.getElementById('modalTable').classList.remove('active');
        }

        function openFormModal(isEdit = false) {
            document.getElementById('modalForm').classList.add('active');
            if (!isEdit) {
                document.getElementById('formModalTitle').innerText = "Tambah Lokasi OPD";
                document.getElementById('formId').value = "";
                document.getElementById('opdForm').reset();
            }
        }

        function closeFormModal() {
            document.getElementById('modalForm').classList.remove('active');
        }

        function editLocationById(id) {
            closeTableModal();
            var item = rawDataList.find(function (x) { return x.no == id; });
            if (!item) return;

            document.getElementById('formModalTitle').innerText = "Edit Lokasi OPD";
            document.getElementById('formId').value = item.no;
            document.getElementById('nama_dinas').value = item.nama_dinas || '';
            document.getElementById('lokasi').value = item.lokasi || '';
            document.getElementById('latitude').value = item.latitude || '';
            document.getElementById('longitude').value = item.longitude || '';
            document.getElementById('keterangan').value = item.keterangan || '';

            openFormModal(true);
        }

        function submitForm(event) {
            event.preventDefault();
            var form = document.getElementById('opdForm');
            var formData = new FormData(form);

            fetch('simpan_lokasi.php', {
                method: 'POST',
                body: formData
            })
                .then(function (response) { return response.json(); })
                .then(function (res) {
                    if (res.status === 'success') {
                        showToast(res.message);
                        closeFormModal();
                        loadLocations();
                    } else {
                        alert("Peringatan: " + res.message);
                    }
                })
                .catch(function (err) {
                    console.error(err);
                    alert("Terjadi kesalahan saat menyimpan data.");
                });
        }

        function deleteLocation(id, nama) {
            if (!confirm(`Hapus data lokasi "${nama}"?`)) {
                return;
            }

            var formData = new FormData();
            formData.append('id', id);

            fetch('hapus_lokasi.php', {
                method: 'POST',
                body: formData
            })
                .then(function (response) { return response.json(); })
                .then(function (res) {
                    if (res.status === 'success') {
                        showToast(res.message);
                        loadLocations();
                    } else {
                        alert("Gagal: " + res.message);
                    }
                })
                .catch(function (err) {
                    console.error(err);
                    alert("Terjadi kesalahan saat menghapus data.");
                });
        }

        /* Ambil Koordinat dari Klik Peta */
        var isPickingCoordinate = false;
        function enableMapPicker() {
            closeFormModal();
            isPickingCoordinate = true;
            showToast("Klik pada titik peta untuk mengambil koordinat.");
            map.getContainer().style.cursor = 'crosshair';
        }

        map.on('click', function (e) {
            if (isPickingCoordinate) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                isPickingCoordinate = false;
                map.getContainer().style.cursor = '';
                showToast("Koordinat: " + lat + ", " + lng);
                openFormModal(true);
            }
        });

        function showToast(message) {
            var toast = document.getElementById('toastNotification');
            toast.innerText = message;
            toast.classList.add('show');
            setTimeout(function () {
                toast.classList.remove('show');
            }, 2500);
        }

        function escapeStr(str) {
            return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
        }

        window.onclick = function (e) {
            if (e.target === document.getElementById('modalTable')) closeTableModal();
            if (e.target === document.getElementById('modalForm')) closeFormModal();
        };

        loadLocations();

        /* Control Layer */
        var baseMaps = {
            "OpenStreetMap": basemap_osm,
            "Esri Imagery": basemap1,
            "Google Street": basemap2
        };

        var overlayMaps = {
            "Lokasi OPD (Database)": dbLayer
        };

        L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

        /* Fullscreen */
        map.addControl(new L.Control.Fullscreen({ position: 'topleft' }));

        /* Tombol Home (SVG Standar Bersih) */
        var homeControl = L.Control.extend({
            options: { position: 'topleft' },
            onAdd: function (map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                var button = L.DomUtil.create('a', '', container);
                button.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top:7px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
                button.href = '#';
                button.title = 'Kembali ke Bundaran Satam';
                button.style.textAlign = 'center';
                button.style.lineHeight = '30px';

                L.DomEvent.on(button, 'click', function (e) {
                    L.DomEvent.stopPropagation(e);
                    L.DomEvent.preventDefault(e);
                    map.setView([initialLat, initialLng], initialZoom);
                });

                return container;
            }
        });
        map.addControl(new homeControl());

        /* Pengukuran */
        var measureControl = new L.Control.Measure({
            position: 'topleft',
            primaryLengthUnit: 'meters',
            secondaryLengthUnit: 'kilometers',
            primaryAreaUnit: 'sqmeters',
            secondaryAreaUnit: 'hectares',
            activeColor: '#d63031',
            completedColor: '#00b894'
        });
        measureControl.addTo(map);

        /* Geocoder Search */
        L.Control.geocoder({
            position: 'topright',
            placeholder: 'Cari lokasi atau alamat...',
            defaultMarkGeocode: true
        }).addTo(map);

        /* Koordinat Kursor Real-time */
        var coordControl = L.control({ position: 'bottomleft' });
        coordControl.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'leaflet-control-coordinate');
            this._div.style.background = 'rgba(255, 255, 255, 0.9)';
            this._div.style.padding = '3px 8px';
            this._div.style.borderRadius = '3px';
            this._div.style.fontSize = '11px';
            this._div.style.border = '1px solid #ced4da';
            this._div.innerHTML = 'Koordinat: -';
            return this._div;
        };
        coordControl.addTo(map);

        map.on('mousemove', function (e) {
            coordControl._div.innerHTML = 'Lat: ' + e.latlng.lat.toFixed(6) + ' | Lng: ' + e.latlng.lng.toFixed(6);
        });

        /* Scale Bar */
        L.control.scale({
            maxWidth: 150,
            position: 'bottomright',
            metric: true,
            imperial: false
        }).addTo(map);
    </script>
</body>

</html>