<template>
    <div>
        <Head title="Calendário" />

        <div class="card" ref="calendarDiv">
            <!-- <TituloCard titulo="Calendário de eventos">
                <Button label="Novo evento" icon="mdi mdi-plus" @click="novoArtista" :loading="loadingModal"></Button>
            </TituloCard> -->

            <FullCalendarComponent ref="fullCalendar" :options="calendarOptions" />
        </div>
    </div>
</template>

<script setup>
import brLocale from "@fullcalendar/core/locales/pt-br";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import FullCalendarComponent from "@fullcalendar/vue3";
import { Head } from "@inertiajs/vue3";

const fullCalendar = ref(null);

const handleDateClick = (arg) => {
    alert("date click! " + arg.dateStr);
};

const handleEventClick = (eventClickInfo) => {
    console.log(eventClickInfo.event.title);
    alert("event click! " + eventClickInfo.event.title);
};

const calendarOptions = {
    locale: brLocale,
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    dateClick: handleDateClick,
    eventClick: handleEventClick,
    events: [
        { title: "event 1", date: "2024-10-01" },
        { title: "event 2", date: "2024-10-02" },
    ],
};

function calendarUpdateSize() {
    var api = fullCalendar.value.getApi();
    api.updateSize();
}

const calendarDiv = ref(null);
let resizeObserver = null;
onMounted(() => {
    resizeObserver = new ResizeObserver((entries) => {
        for (let entry of entries) {
            calendarUpdateSize();
        }
    });

    resizeObserver.observe(calendarDiv.value);
});

onBeforeUnmount(() => {
    resizeObserver.disconnect();
});
</script>
