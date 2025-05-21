<template>
    <div>
        <Navbar />
    </div>

    <div class="list-wrapper">
        <div class="upper">
            <h2>Daftar Peminjaman</h2>

            <input
                type="text"
                v-model="searchQuery"
                placeholder="Cari berdasarkan email user atau judul buku..."
            />
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Tanggal Dikembalikan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in filteredPeminjaman" :key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.user.email }}</td>
                    <td>{{ item.buku.judul }}</td>
                    <td>{{ item.tanggal_peminjaman }}</td>
                    <td>{{ item.tanggal_pengembalian }}</td>
                    <td>{{ item.tanggal_dikembalikan || "-" }}</td>
                    <td>{{ item.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import Navbar from "../components/Navbar.vue";

// State
const allPeminjaman = ref([]);
const searchQuery = ref("");

// Ambil data peminjaman
const getPeminjaman = async () => {
    try {
        const token = localStorage.getItem("token");
        const response = await axios.get(
            "https://magang.partnership.co.id//api/petugas/peminjaman",
            {
                headers: { Authorization: `Bearer ${token}` },
            }
        );
        allPeminjaman.value = response.data;
    } catch (error) {
        alert("Gagal mengambil data peminjaman");
        console.error(error);
    }
};

// Filter
const filteredPeminjaman = computed(() => {
    return allPeminjaman.value.filter((item) => {
        const emailUser = item.user?.email?.toLowerCase() || "";
        const judulBuku = item.buku?.judul?.toLowerCase() || "";
        const query = searchQuery.value.toLowerCase();
        return emailUser.includes(query) || judulBuku.includes(query);
    });
});

onMounted(() => {
    getPeminjaman();
});
</script>

<style scoped>
.list-wrapper {
    background-color: #f9f4ef;
    border-radius: 30px;
    font-family: Arial, Helvetica, sans-serif;
    padding: 20px;
    margin-top: 20px;
}

.upper {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #4e6688;
    color: #fffffe;
    padding: 10px;
    border-radius: 20px;
}

input {
    padding: 0.5rem;
    margin-top: 1rem;
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
</style>
