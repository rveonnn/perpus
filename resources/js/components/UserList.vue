<template>
    <div>
        <Navbar />
    </div>

    <div class="list-wrapper">
        <div class="upper">
            <h2>Daftar User</h2>

            <!-- Search -->
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Cari User..."
            />
            <button
                class="tambahButton"
                @click="
                    showForm = true;
                    formMode = 'add';
                    resetForm();
                "
            >
                Tambah User
            </button>
        </div>

        <!-- Tabel Buku -->
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in filteredAnggota" :key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.nama }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.alamat }}</td>
                    <td>{{ item.nomor_telepon }}</td>
                    <td>{{ item.role }}</td>
                    <td>
                        <div class="button">
                            <button class="edit" @click="editAnggota(item)">
                                Edit
                            </button>
                            <button
                                class="delete"
                                @click="confirmDeleteAnggota(item.id)"
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
                <h3>{{ formMode === "add" ? "Tambah User" : "Edit User" }}</h3>
                <form
                    @submit.prevent="
                        formMode === 'add' ? tambahAnggota() : updateAnggota()
                    "
                >
                    <input
                        v-model="form.nama"
                        type="text"
                        placeholder="Nama"
                        required
                    />
                    <input
                        v-model="form.email"
                        type="text"
                        placeholder="Email"
                        required
                    />
                    <input
                        v-model="form.alamat"
                        type="text"
                        placeholder="Alamat"
                        required
                    />
                    <input
                        v-model="form.nomor_telepon"
                        type="text"
                        placeholder="Nomor Telepon"
                        pattern="[0-9]+"
                        required
                    />
                    <select v-model="form.role" required>
                        <option disabled value="">Pilih Role</option>
                        <option value="Petugas">Petugas</option>
                        <option value="Anggota">Anggota</option>
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
                <p>Apakah Anda yakin ingin menghapus Akun ini?</p>
                <div class="modal-actions">
                    <button @click="deleteAnggota">Hapus</button>
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
const anggota = ref([]);
const searchQuery = ref("");
const roleQuery = ref("");
const showForm = ref(false);
const formMode = ref("add");
const form = ref({
    id: null,
    nama: "",
    email: "",
    alamat: "",
    nomor_telepon: "",
    role: "anggota",
});

// Ambil data buku
const getAnggota = async () => {
    try {
        const token = localStorage.getItem("token");
        const response = await axios.get(
            "https://magang.partnership.co.id/api/petugas/users",
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );

        console.log(response);

        anggota.value = response.data;
    } catch (error) {
        alert("Gagal mengambil data User");
        console.error(error);
    }
};

// Filtering
const filteredAnggota = computed(() => {
    return anggota.value.filter((item) => {
        const cocokNama = item.nama
            .toLowerCase()
            .includes(searchQuery.value.toLowerCase());
        const cocokRole =
            roleQuery.value === "" ||
            item.role.toLowerCase().includes(roleQuery.value.toLowerCase());
        return cocokNama && cocokRole;
    });
});

// Reset form
const resetForm = () => {
    form.value = {
        id: null,
        nama: "",
        email: "",
        alamat: "",
        nomor_telepon: "",
        role: "anggota",
    };
    formMode.value = "add";
};

// Tambah buku
const tambahAnggota = async () => {
    try {
        const token = localStorage.getItem("token");
        await axios.post(
            "https://magang.partnership.co.id//api/petugas/users",
            form.value,
            {
                headers: { Authorization: `Bearer ${token}` },
            }
        );
        showForm.value = false;
        resetForm();
        getAnggota();
        alert("Akun berhasil ditambahkan");
    } catch (error) {
        alert("Gagal menambah Akun");
        console.error(error);
    }
};

// Edit buku
const editAnggota = (item) => {
    formMode.value = "edit";
    form.value = { ...item };
    showForm.value = true;
};

// Update buku
const updateAnggota = async () => {
    try {
        const token = localStorage.getItem("token");
        await axios.put(
            `https://magang.partnership.co.id/api/petugas/users/${form.value.id}`,
            form.value,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        showForm.value = false;
        resetForm();
        getAnggota();
        alert("Akun berhasil diupdate");
    } catch (error) {
        alert("Gagal mengupdate Akun");
        console.error(error);
    }
};

// Hapus buku
const showDeleteConfirmation = ref(false);
const bookIdToDelete = ref(null);

const confirmDeleteAnggota = (id) => {
    showDeleteConfirmation.value = true;
    bookIdToDelete.value = id;
};

const deleteAnggota = async () => {
    try {
        const token = localStorage.getItem("token");
        await axios.delete(
            `https://magang.partnership.co.id//api/petugas/users/${bookIdToDelete.value}`,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            }
        );
        showDeleteConfirmation.value = false;
        getAnggota();
        alert("Akun berhasil dihapus");
    } catch (error) {
        alert("Gagal menghapus Akun");
        console.error(error);
    }
};

onMounted(() => {
    getAnggota();
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
