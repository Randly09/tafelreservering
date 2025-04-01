<template>
    <div
        class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white py-8"
    >
        <div class="ml-8 mb-4">
            <Link
                :href="route('beheerder.home')"
                class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-600"
            >
                Terug
            </Link>
        </div>

        <!-- Container for both table and form -->
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-6">Tables</h1>

            <!-- Table List -->
            <div
                v-if="tables.length"
                class="bg-white rounded-lg shadow-md p-4 text-black"
            >
                <table class="min-w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-center">Table ID</th>
                            <th class="py-3 px-4 text-center">Name</th>
                            <th class="py-3 px-4 text-center">Capacity</th>
                            <th class="py-3 px-4 text-center">Location</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="table in tables"
                            :key="table.id"
                            class="border-b"
                        >
                            <td class="py-3 px-4 text-center">
                                {{ table.id }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ table.name }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ table.capacity }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ table.location }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                <Link
                                    :href="
                                        route('tables.edit', { id: table.id })
                                    "
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 mr-2"
                                >
                                    Update
                                </Link>
                                <button
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    @click="deleteTable(table.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="text-center">
                <p>No tables available.</p>
            </div>

            <!-- Form to Add a New Table -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-4 text-black">
                <h2 class="text-2xl font-bold mb-4">Add New Table</h2>
                <form @submit.prevent="createTable">
                    <div class="mb-4">
                        <label class="block mb-1">Name</label>
                        <input
                            type="text"
                            v-model="form.name"
                            class="w-full p-2 border rounded"
                        />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Capacity</label>
                        <input
                            type="number"
                            v-model="form.capacity"
                            class="w-full p-2 border rounded"
                        />
                    </div>
                    <div class="mb-4">
                        <select
                            v-model="form.location"
                            class="p-2 border border-gray-300 rounded w-full sm:w-auto text-gray-800"
                        >
                            <option value="" disabled>Location</option>
                            <option
                                v-for="option in TableLocation"
                                :key="option"
                                :value="option"
                            >
                                {{ option }}
                            </option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mt-4"
                    >
                        Add Table
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

const TableLocation = ref(["Inside", "Outside"]);
const tables = ref([]);

const form = ref({
    name: "",
    capacity: "",
    location: "",
});

function createTable() {
    axios
        .post("/api/tables", form.value)
        .then((response) => {
            tables.value.push(response.data);
            form.value.name = "";
            form.value.capacity = "";
            form.value.location = "";
        })
        .catch((error) => {
            console.error("Error creating table:", error);
        });
}

function fetchTables() {
    axios
        .get("/api/tables-data")
        .then((response) => {
            tables.value = response.data;
        })
        .catch((error) => {
            console.error("Error fetching tables:", error);
        });
}

function deleteTable(id) {
    if (confirm("Are you sure you want to delete this table?")) {
        axios
            .delete(`/api/tables/${id}`)
            .then(() => {
                tables.value = tables.value.filter((table) => table.id !== id);
            })
            .catch((error) => {
                console.error("Error deleting table:", error);
            });
    }
}

onMounted(() => {
    fetchTables();
});
</script>
