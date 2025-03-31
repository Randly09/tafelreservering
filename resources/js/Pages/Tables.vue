<template>
    <div
        class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white py-8"
    >
        <div>
            <Link
                :href="route('beheerder.home')"
                class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-600"
            >
                Terug
            </Link>
        </div>
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
                            <th class="py-3 px-4 text-center">Cancel</th>
                            <th class="py-3 px-4 text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="table in tables"
                            :key="table.id"
                            class="border-b"
                        >
                            <td class="py-3 px-4 text-center">{{ table.id }}</td>
                            <td class="py-3 px-4 text-center">{{ table.name }}</td>
                            <td class="py-3 px-4 text-center">{{ table.capacity }}</td>
                            <td class="py-3 px-4 text-center">{{ table.location }}</td>
                            <td class="py-3 px-4 text-center">
                                <!-- Buttons for edit and delete; edit functionality to be implemented as needed -->
                                <button
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    @click="deleteTable(table.id)"
                                >
                                    Delete
                                </button>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <!-- Buttons for edit and delete; edit functionality to be implemented as needed -->
                                <button
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                                    @click="updateTable(table.id)"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="text-center">
                <p>No tables available.</p>
            </div>
            <div v-else class="text-center mt-6">
                <p>No tables found.</p>
            </div>
        </div>

                    <!-- Simple Form to Add a New Table -->
                    <div class="mt-8 bg-white rounded-lg shadow-md p-8 m-8 text-black ">
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
                        <label class="block mb-1">Location</label>
                        <input
                            type="text"
                            v-model="form.location"
                            class="w-full p-2 border rounded"
                        />
                    </div>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                    >
                        Add Table
                    </button>
                </form>
            </div>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";

const { props } = usePage();
const tables = computed(() => props.tables || []);

// Form for creating a new table.
const form = ref({
    name: "",
    capacity: "",
    location: "",
});

function createTable() {
    Inertia.post(route("beheerderTables.store"), form.value, {
        onSuccess: () => {
            form.value = { name: "", capacity: "", location: "" };
        },
    });
}

function deleteTable(id) {
    if (confirm("Are you sure you want to delete this table?")) {
        Inertia.delete(route("beheerderTables.destroy", id));
    }
}

function updateTable(id) {
  if (confirm("Are you sure you want to update this table?")) {
    // Create an object with the updated table data.
    // In a real app, these values could come from a form.
    const updatedData = {
      name: 'Updated Table Name',
      capacity: 6,
      location: 'Binnen'
    };

    // Use Inertia.put (or Inertia.patch) to send a PUT/PATCH request.
    Inertia.put(route("beheerderTables.update", id), updatedData, {
      onSuccess: () => {
        console.log("Table updated successfully.");
      },
      onError: () => {
        alert("There was an error updating the table.");
      }
    });
  }
}
</script>
