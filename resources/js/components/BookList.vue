<template>
    <div>
        <Navbar />
    </div>

    <div class="list-wrapper">
        <div class="upper">
            <h2>Daftar Buku</h2>

            <!-- Search -->
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Cari buku..."
            />
            <button
                class="tambahButton"
                @click="
                    showForm = true;
                    formMode = 'add';
                    resetForm();
                "
            >
                Tambah Buku
            </button>
        </div>

        <!-- Tabel Buku -->
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Sinopsis</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in filteredBooks" :key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.judul }}</td>
                    <td>{{ item.sinopsis }}</td>
                    <td>{{ item.penulis }}</td>
                    <td>{{ item.penerbit }}</td>
                    <td>{{ item.tahun }}</td>
                    <td>{{ item.status }}</td>
                    <td>
                        <div class="button">
                            <button class="edit" @click="editBook(item)">
                                Edit
                            </button>
                            <button
                                class="delete"
                                @click="confirmDeleteBook(item.id)"
                            >
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Tambah/Edit Buku -->
        <div v-if="showForm" class="modalDelete">
            <div class="modal-content">
                <h3>{{ formMode === "add" ? "Tambah Buku" : "Edit Buku" }}</h3>
                <form
                    @submit.prevent="
                        formMode === 'add' ? tambahBuku() : updateBuku()
                    "
                >
                    <input
                        v-model="form.judul"
                        type="text"
                        placeholder="Judul"
                        required
                    />
                    <input
                        v-model="form.sinopsis"
                        type="text"
                        placeholder="Sinopsis"
                    />
                    <input
                        v-model="form.penulis"
                        type="text"
                        placeholder="Penulis"
                        required
                    />
                    <input
                        v-model="form.penerbit"
                        type="text"
                        placeholder="Penerbit"
                        required
                    />
                    <input
                        v-model="form.tahun"
                        type="number"
                        placeholder="Tahun"
                        required
                    />
                    <select v-model="form.status" required>
                        <option disabled value="">Pilih Status</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                    <div class="modal-actions">
                        <button type="submit">
                            {{ formMode === "add" ? "Simpan" : "Update" }}
                        </button>
                        <button type="button" @click="showForm = false">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div v-if="showDeleteConfirmation" class="modalDelete">
            <div class="modal-content">
                <p>Apakah Anda yakin ingin menghapus buku ini?</p>
                <div class="modal-actions">
                    <button @click="deleteBook">Hapus</button>
                    <button @click="showDeleteConfirmation = false">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import Navbar from "../components/Navbar.vue";

// State
const buku = ref([]);
const searchQuery = ref("");
const showForm = ref(false);
const formMode = ref("add");
const form = ref({
    id: null,
    judul: "",
    sinopsis: "",
    penulis: "",
    penerbit: "",
    tahun: "",
    status: "available",
});

// Ambil data buku
const getBuku = async () => {
    try {
        const token = localStorage.getItem("token");
        const response = await axios.get(
            "https://magang.partnership.co.id//api/buku",
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        buku.value = response.data;
    } catch (error) {
        alert("Gagal mengambil data buku");
        console.error(error);
    }
};

// Filtering
const filteredBooks = computed(() => {
    return buku.value.filter((item) =>
        item.judul.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Reset form
const resetForm = () => {
    form.value = {
        id: null,
        judul: "",
        sinopsis: "",
        penulis: "",
        penerbit: "",
        tahun: "",
        status: "available",
    };
    formMode.value = "add";
};

// Tambah buku
const tambahBuku = async () => {
    try {
        const token = localStorage.getItem("token");
        await axios.post(
            "https://magang.partnership.co.id/api/petugas/buku",
            form.value,
            {
                headers: { Authorization: `Bearer ${token}` },
            }
        );
        showForm.value = false;
        resetForm();
        getBuku();
        alert("Buku berhasil ditambahkan");
    } catch (error) {
        alert("Gagal menambah buku");
        console.error(error);
    }
};

// Edit buku
const editBook = (book) => {
    formMode.value = "edit";
    form.value = { ...book };
    showForm.value = true;
};

// Update buku
const updateBuku = async () => {
    try {
        const token = localStorage.getItem("token");
        await axios.put(
            `https://magang.partnership.co.id//api/petugas/buku/${form.value.id}`,
            form.value,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        showForm.value = false;
        resetForm();
        getBuku();
        alert("Buku berhasil diupdate");
    } catch (error) {
        alert("Gagal mengupdate buku");
        console.error(error);
    }
};

// Hapus buku
const showDeleteConfirmation = ref(false);
const bookIdToDelete = ref(null);

const confirmDeleteBook = (id) => {
    showDeleteConfirmation.value = true;
    bookIdToDelete.value = id;
};

const deleteBook = async () => {
    try {
        const token = localStorage.getItem("token");
        await axios.delete(
            `https://magang.partnership.co.id//api/petugas/buku/${bookIdToDelete.value}`,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            }
        );
        showDeleteConfirmation.value = false;
        getBuku();
        alert("Buku berhasil dihapus");
    } catch (error) {
        alert("Gagal menghapus buku");
        console.error(error);
    }
};

onMounted(() => {
    getBuku();
});
</script>

<style scoped>
.list-wrapper {
    background-color: #f9f4ef;
    border-radius: 30px;
    font-family: Arial, Helvetica, sans-serif;
}

.upper {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #4e6688;
    color: #fffffe;
    margin-top: 10px;
    padding: 10px;
    border-radius: 20px;
}

input {
    padding: 0.5rem;
    margin-bottom: 1rem;
    width: 100%;
    max-width: 300px;
    border-radius: 20px;
    outline: none;
    border: 1px solid #ffffff;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

th,
td {
    padding: 0.75rem;
    border: 1px solid black;
    background-color: #eaddcf;
}

th {
    background-color: #4e6688;
    color: white;
}
.tambahButton {
    padding: 5px 10px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    border: none;
}
.button {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.edit,
.delete {
    padding: 5px 10px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    font-size: 0.9rem;
    border: none;
}

.edit {
    background-color: #f5d061;
}

.edit:hover {
    background-color: #b9930e;
    color: white;
}

.delete {
    background-color: #f2838f;
}

.delete:hover {
    background-color: #c0392b;
    color: white;
}

.modalDelete {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 60%;
    text-align: center;
}

.modal-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.modal-content input,
.modal-content select {
    width: 100%;
    margin: 0.5rem 0;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.modal-content button {
    padding: 10px 15px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    background-color: #4e6688;
    color: white;
}

.modal-content button:hover {
    background-color: #3a4b67;
}
</style>
