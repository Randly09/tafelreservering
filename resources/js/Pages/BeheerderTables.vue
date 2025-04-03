<template>
    <div
        class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white py-8"
    >
        <!-- Header with navigation already set up -->
        <header class="bg-blue-800 shadow">
            <div
                class="container mx-auto flex items-center justify-between py-4 px-6"
            >
                <div class="flex items-center">
                    <img
                        src="/images/logo.png"
                        alt="Logo"
                        class="h-10 w-auto mr-4"
                    />
                    <span class="text-xl font-bold">Admin Dashboard</span>
                </div>
                <nav>
                    <ul class="flex space-x-4">
                        <li>
                            <Link
                                :href="route('beheerderReservations.index')"
                                class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-600"
                            >
                                Reservations
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('beheerderTables.index')"
                                class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-600"
                            >
                                Tables
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto mt-8">
            <h1 class="text-3xl font-bold mb-6">Tables</h1>

            <!-- Table List -->
            <div
                v-if="tables.length"
                class="bg-white rounded-lg shadow-md p-4 text-black"
            >
                <table class="min-w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-left">Table ID</th>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Capacity</th>
                            <th class="py-3 px-4 text-left">Location</th>
                            <th class="py-3 px-4 text-left">Cancel</th>
                            <th class="py-3 px-4 text-left">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="table in tables"
                            :key="table.id"
                            class="border-b"
                        >
                            <td class="py-3 px-4">{{ table.id }}</td>
                            <td class="py-3 px-4">{{ table.name }}</td>
                            <td class="py-3 px-4">{{ table.capacity }}</td>
                            <td class="py-3 px-4">{{ table.location }}</td>
                            <td class="py-3 px-4">
                                <button
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    @click="deleteTable(table.id)"
                                >
                                    Delete
                                </button>
                            </td>
                            <td class="py-3 px-4">
                                <button
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
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
        </main>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";

const { props } = usePage();
const tables = computed(() => props.tables || []);

const form = ref({
    name: "",
    capacity: "",
    location: "",
});



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
