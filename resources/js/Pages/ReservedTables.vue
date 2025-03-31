<template>
    <!-- Full-page gradient background and white text -->
    <div
        class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white py-8"
    >
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-6">Your Reservations</h1>

            <!-- Return to Home button -->
            <div class="mb-4">
                <Link
                    :href="route('reservations.index')"
                    class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600"
                >
                    Return to Home
                </Link>
            </div>

            <!-- If there are reservations, display the table -->
            <div
                v-if="reservations.length"
                class="bg-white rounded-lg shadow-md overflow-hidden"
            >
                <table class="min-w-full text-black">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-center">Table</th>
                            <th class="py-3 px-4 text-center">Seating</th>
                            <th class="py-3 px-4 text-center">Max people</th>
                            <th class="py-3 px-4 text-center">Date</th>
                            <th class="py-3 px-4 text-center">Time</th>
                            <th class="py-3 px-4 text-center">Phone Number</th>
                            <th class="py-3 px-4 text-center">Occasion</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="reservation in reservations"
                            :key="reservation.id"
                            class="border-b last:border-b-0"
                        >
                            <td class="py-3 px-4 text-center">
                                {{
                                    reservation.table
                                        ? reservation.table.name
                                        : "N/A"
                                }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{
                                    reservation.table
                                        ? reservation.table.location
                                        : "N/A"
                                }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{
                                    reservation.table
                                        ? reservation.table.capacity
                                        : "N/A"
                                }}
                            </td>
                            <td class="py-3 px-4 text-center">{{ reservation.date }}</td>
                            <td class="py-3 px-4 text-center">{{ reservation.time }}</td>
                            <td class="py-3 px-4 text-center">
                                {{ reservation.phone_number }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ reservation.Occasion }}
                            </td>
                            <td class="py-3 px-4 text-center">{{ reservation.status }}</td>
                            <td class="py-3 px-4 text-center">
                                <button
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    @click="cancelReservation(reservation.id)"
                                >
                                    Cancel
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- If there are no reservations, show a message -->
            <div v-else class="text-center mt-6">
                <p>You have no reservations yet.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { Inertia } from "@inertiajs/inertia";

// Get page props from Inertia
const { props } = usePage();
const reservations = computed(() => props.reservations || []);

// Function to cancel (delete) a reservation
function cancelReservation(id) {
    if (confirm("Are you sure you want to cancel this reservation?")) {
        Inertia.delete(route("reservations.destroy", id), {
            onSuccess: () => {
                console.log("Reservation canceled successfully.");
            },
            onError: () => {
                alert("There was an error canceling your reservation.");
            },
        });
    }
}
</script>
