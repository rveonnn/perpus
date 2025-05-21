<template>
    <div>
        <Navbar />
    </div>

    <div>
        <h1>Overview</h1>
        <div class="dashboard-boxes">
            <div class="box first">
                <i class="icon">👥</i>
                <h3>Members</h3>
                <p>Total: {{ stats.total_users }}</p>
                <small>Active Members</small>
            </div>

            <div class="box second">
                <i class="icon">📚</i>
                <h3>Books</h3>
                <p>Total: {{ stats.total_books }}</p>
                <small>Available Books</small>
            </div>

            <div class="box third">
                <i class="icon">📄</i>
                <h3>Loans</h3>
                <p>Active: {{ stats.active_loans }}</p>
                <small>Books on Loan</small>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import Navbar from "../components/Navbar.vue";

const stats = reactive({
    total_users: 0,
    total_books: 0,
    active_loans: 0,
});

const token = localStorage.getItem("token");

fetch("/api/petugas/dashboard/stats", {
    headers: {
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
    },
})
    .then((res) => res.json())
    .then((data) => {
        stats.total_users = data.total_users;
        stats.total_books = data.total_books;
        stats.active_loans = data.active_loans;
    });
</script>

<style scoped>
.dashboard-boxes {
    display: flex;
    gap: 1rem;
}

.box {
    flex: 1;
    border-radius: 8px;
    padding: 1rem;
    font-family: Arial, Helvetica, sans-serif;
    color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.box.first {
    background: #71c0bb;
    color: #332d56;
}
.box.second {
    background: #4e6688;
}
.box.third {
    background: #332d56;
    color: #71c0bb;
}

.icon {
    font-size: 1.5rem;
}
</style>
