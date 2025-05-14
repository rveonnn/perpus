<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            width: 250px;
            background-color: #343a40;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-approved {
            background-color: #28a745;
        }

        .badge-overdue {
            background-color: #dc3545;
        }

        .badge-returned {
            background-color: #17a2b8;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
</head>

<body>
    <div class="loading-spinner text-primary">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 bg-dark sidebar">
                <div class="sidebar-sticky pt-3">
                    <div class="text-center text-white mb-4">
                        <h4>Perpustakaan</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#dashboard">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#members">
                                <i class="fas fa-users mr-2"></i>Anggota
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#books">
                                <i class="fas fa-book mr-2"></i>Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#loans">
                                <i class="fas fa-exchange-alt mr-2"></i>Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#returns">
                                <i class="fas fa-undo mr-2"></i>Pengembalian
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <button class="btn btn-danger btn-sm btn-block btn-logout">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <span class="text-muted mr-2">Welcome, <span class="user-name font-weight-bold"></span></span>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Overview -->
                <div id="dashboard" class="mb-5">
                    <h4>Overview</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title" id="total-books">0</h5>
                                    <p class="card-text">Total Buku</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title" id="total-members">0</h5>
                                    <p class="card-text">Total Anggota</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title" id="active-loans">0</h5>
                                    <p class="card-text">Peminjaman Aktif</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title" id="overdue-loans">0</h5>
                                    <p class="card-text">Keterlambatan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Members Section -->
                <div id="members" class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>Manajemen Anggota</h4>
                        <button class="btn btn-primary btn-sm" id="addMemberBtn">
                            <i class="fas fa-plus mr-1"></i>Tambah Anggota
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="membersTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data anggota akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Books Section -->
                <div id="books" class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>Manajemen Buku</h4>
                        <div>
                            <input type="text" class="form-control form-control-sm d-inline-block search-box"
                                   id="searchBook" placeholder="Cari buku..." style="width: 200px;">
                            <button class="btn btn-primary btn-sm ml-2" id="addBookBtn">
                                <i class="fas fa-plus mr-1"></i>Tambah Buku
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="booksTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data buku akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Loans Section -->
                <div id="loans" class="mb-5">
                    <h4 class="mb-3">Manajemen Peminjaman</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="loansTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data peminjaman akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Returns Section -->
                <div id="returns" class="mb-5">
                    <h4 class="mb-3">Manajemen Pengembalian</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="returnsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data pengembalian akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Tambah Buku Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bookForm">
                        <input type="hidden" id="bookId">
                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" required>
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control" id="penulis" required>
                        </div>
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" required>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun" required>
                        </div>
                        <div class="form-group">
                            <label for="sinopsis">Sinopsis</label>
                            <textarea class="form-control" id="sinopsis" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveBookBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Approval Modal -->
    <div class="modal fade" id="approveLoanModal" tabindex="-1" role="dialog" aria-labelledby="approveLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveLoanModalLabel">Persetujuan Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menyetujui peminjaman ini?</p>
                    <div id="loanDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirmApproveBtn">Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Book Modal -->
    <div class="modal fade" id="returnBookModal" tabindex="-1" role="dialog" aria-labelledby="returnBookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnBookModalLabel">Proses Pengembalian Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="returnForm">
                        <input type="hidden" id="returnLoanId">
                        <div class="form-group">
                            <label for="returnDate">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="returnDate" required>
                        </div>
                        <div class="form-group">
                            <label for="fineAmount">Denda (jika ada)</label>
                            <input type="number" class="form-control" id="fineAmount" value="0" min="0">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmReturnBtn">Proses</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Global variables
        let currentUser = {};
        let authToken = '';
        let currentLoanId = null;

        $(document).ready(function() {
            // Check authentication
            checkAuth();

            // Initialize page
            initDashboard();
            loadMembers();
            loadBooks();
            loadLoans();
            loadReturns();

            // Event listeners
            $('#addBookBtn').click(showAddBookModal);
            $('#saveBookBtn').click(saveBook);
            $('#searchBook').keyup(searchBooks);
            $('.btn-logout').click(logout);

            // Loan approval
            $(document).on('click', '.approve-loan-btn', function() {
                currentLoanId = $(this).data('id');
                showApproveLoanModal(currentLoanId);
            });

            $('#confirmApproveBtn').click(approveLoan);

            // Book return
            $(document).on('click', '.return-book-btn', function() {
                currentLoanId = $(this).data('id');
                $('#returnDate').val(new Date().toISOString().split('T')[0]);
                $('#returnBookModal').modal('show');
            });

            $('#confirmReturnBtn').click(processReturn);
        });

        function checkAuth() {
            authToken = localStorage.getItem('auth_token');
            const userData = localStorage.getItem('user');

            if (!authToken || !userData) {
                window.location.href = 'login.html';
                return;
            }

            currentUser = JSON.parse(userData);
            $('.user-name').text(currentUser.nama);

            // Set default axios headers
            axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
            axios.defaults.headers.common['Accept'] = 'application/json';
        }

        function showLoading(show) {
            $('.loading-spinner').css('display', show ? 'block' : 'none');
        }

        function initDashboard() {
            showLoading(true);

            axios.get('/api/dashboard')
                .then(response => {
                    $('#total-books').text(response.data.total_books);
                    $('#total-members').text(response.data.total_members);
                    $('#active-loans').text(response.data.active_loans);
                    $('#overdue-loans').text(response.data.overdue_loans);
                    showLoading(false);
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal memuat data dashboard');
                });
        }

        function loadBooks() {
            showLoading(true);

            axios.get('/api/buku')
                .then(response => {
                    const booksTable = $('#booksTable tbody');
                    booksTable.empty();

                    response.data.data.forEach((book, index) => {
                        booksTable.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${book.judul}</td>
                                <td>${book.penulis}</td>
                                <td>${book.penerbit}</td>
                                <td>${book.tahun}</td>
                                <td>
                                    <span class="badge ${book.status === 'tersedia' ? 'badge-success' : 'badge-danger'}">
                                        ${book.status}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-book-btn" data-id="${book.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-book-btn" data-id="${book.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                    showLoading(false);
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal memuat data buku');
                });
        }

        function loadLoans() {
            showLoading(true);

            axios.get('/api/peminjaman')
                .then(response => {
                    const loansTable = $('#loansTable tbody');
                    loansTable.empty();

                    response.data.data.forEach((loan, index) => {
                        loansTable.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${loan.user.nama}</td>
                                <td>${loan.buku.judul}</td>
                                <td>${loan.tanggal_peminjaman}</td>
                                <td>${loan.tanggal_pengembalian}</td>
                                <td>
                                    <span class="badge badge-${loan.status}">
                                        ${loan.status}
                                    </span>
                                </td>
                                <td>
                                    ${loan.status === 'pending' ?
                                        `<button class="btn btn-sm btn-success approve-loan-btn" data-id="${loan.id}">
                                            <i class="fas fa-check"></i> Approve
                                        </button>` : ''}
                                    ${loan.status === 'approved' ?
                                        `<button class="btn btn-sm btn-info return-book-btn" data-id="${loan.id}">
                                            <i class="fas fa-undo"></i> Kembalikan
                                        </button>` : ''}
                                </td>
                            </tr>
                        `);
                    });
                    showLoading(false);
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal memuat data peminjaman');
                });
        }

        function showAddBookModal() {
            $('#bookModalLabel').text('Tambah Buku Baru');
            $('#bookForm')[0].reset();
            $('#bookId').val('');
            $('#bookModal').modal('show');
        }

        function saveBook() {
            const bookData = {
                judul: $('#judul').val(),
                penulis: $('#penulis').val(),
                penerbit: $('#penerbit').val(),
                tahun: $('#tahun').val(),
                sinopsis: $('#sinopsis').val()
            };

            const bookId = $('#bookId').val();
            const url = bookId ? `/api/buku/${bookId}` : '/api/buku';
            const method = bookId ? 'put' : 'post';

            showLoading(true);

            axios[method](url, bookData)
                .then(response => {
                    $('#bookModal').modal('hide');
                    loadBooks();
                    showSuccess(bookId ? 'Buku berhasil diperbarui' : 'Buku berhasil ditambahkan');
                    showLoading(false);
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal menyimpan buku');
                });
        }

        function approveLoan() {
            showLoading(true);

            axios.post(`/api/peminjaman/${currentLoanId}/approve`)
                .then(response => {
                    $('#approveLoanModal').modal('hide');
                    loadLoans();
                    showSuccess('Peminjaman berhasil disetujui');
                    showLoading(false);
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal menyetujui peminjaman');
                });
        }

        function processReturn() {
            const returnData = {
                tanggal_dikembalikan: $('#returnDate').val(),
                denda: $('#fineAmount').val()
            };

            showLoading(true);

            axios.post(`/api/peminjaman/${currentLoanId}/return`, returnData)
                .then(response => {
                    $('#returnBookModal').modal('hide');
                    loadLoans();
                    loadReturns();
                    showSuccess('Pengembalian berhasil diproses');
                    showLoading(false);
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal memproses pengembalian');
                });
        }

        function logout() {
            showLoading(true);

            axios.post('/api/logout')
                .then(response => {
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    window.location.href = 'login.html';
                })
                .catch(error => {
                    showLoading(false);
                    showError('Gagal logout');
                });
        }

        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: message,
                timer: 2000
            });
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });
        }
    </script>
</body>

</html>
