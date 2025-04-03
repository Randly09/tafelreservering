<template>
    <GuestLayout>
        <Head title="Book Table" />
        <div class="mb-4 justify-center">
            <Link
                :href="route('reservations.index')"
                class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600"
            >
                Return to Home
            </Link>
        </div>
        <div
            class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white flex items-center justify-center"
        >
            <div
                class="bg-blue-900/80 rounded-xl shadow-xl px-8 py-10 max-w-lg w-full"
            >
                <h1 class="text-3xl font-bold mb-4 text-center">
                    Book Table: {{ table.name }}
                </h1>
                <!-- Conditional Image Based on Table Location -->
                <div class="mb-6 flex justify-center">
                    <img
                        v-if="table.location === 'Inside'"
                        src="/images/InsideTable.jpg"
                        alt="Binnen Setting"
                        class="w-90 h-auto rounded"
                    />
                    <img
                        v-else-if="table.location === 'Outside'"
                        src="/images/outsideTable.jpg"
                        alt="Buiten Setting"
                        class="w-90 h-auto rounded"
                    />
                </div>

                <div class="mb-4">
                    <p class="text-lg">Capacity: {{ table.capacity }}</p>
                    <p class="text-lg">Location: {{ table.location }}</p>
                </div>
                <p class="mb-4">
                    This is the booking page for the selected table. Reminder
                    you have to present yourself at the restaurant 10 minutes
                    before reservation.
                </p>

                <!-- Booking Form -->
                <form @submit.prevent="bookTable">
                    <!-- Hidden Reservation Date Field -->
                    <input type="hidden" id="date" v-model="form.date" />

                    <!-- Hidden Reservation Time Field -->
                    <input type="hidden" id="time" v-model="form.time" />

                    <!-- Phone Number Field -->
                    <div class="mb-4">
                        <label
                            for="phone_number"
                            class="block text-gray-300 mb-1"
                            >Phone Number</label
                        >
                        <input
                            type="text"
                            id="phone_number"
                            v-model="form.phone_number"
                            placeholder="Enter your phone number"
                            class="w-full p-2 border border-gray-300 rounded text-gray-800"
                        />
                        <span
                            v-if="form.errors.phone_number"
                            class="text-red-300"
                            >{{ form.errors.phone_number }}</span
                        >
                    </div>

                    <!-- Occasion Field -->
                    <div class="mb-6">
                        <label for="occasion" class="block text-gray-300 mb-1"
                            >Occasion</label
                        >
                        <input
                            type="text"
                            id="Occasion"
                            v-model="form.Occasion"
                            placeholder="Birthday, Anniversary, etc."
                            class="w-full p-2 border border-gray-300 rounded text-gray-800"
                        />
                        <span
                            v-if="form.errors.occasion"
                            class="text-red-300"
                            >{{ form.errors.occasion }}</span
                        >
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                            :disabled="form.processing"
                        >
                            Proceed with Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    table: {
        type: Object,
        required: true,
    },
    reservationDate: {
        type: String,
        default: "",
    },
    reservationTime: {
        type: String,
        default: "",
    },
});

const minDate = new Date().toISOString().split("T")[0];

const timeOptions = [];
const startHour = 17;
const endHour = 20;
for (let hour = startHour; hour <= endHour; hour++) {
    for (let minutes = 0; minutes < 60; minutes += 15) {
        const h = hour.toString().padStart(2, "0");
        const m = minutes.toString().padStart(2, "0");
        timeOptions.push(`${h}:${m}`);
    }
}

const form = useForm({
    table_id: props.table.id,
    date: props.reservationDate || minDate,
    time: props.reservationTime || "",
    phone_number: "",
    Occasion: "",
    status: "geboekt",
});

function bookTable() {
    form.post(route("reservations.store"));
}
</script>
