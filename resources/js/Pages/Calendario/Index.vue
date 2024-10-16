<template>
    <div>
        <Head title="Calendário" />

        <div class="card" ref="calendarDiv">
            <!-- <TituloCard titulo="Calendário de eventos">
                <Button label="Novo evento" icon="mdi mdi-plus" @click="novoArtista" :loading="loadingModal"></Button>
            </TituloCard> -->

            <FullCalendarComponent ref="fullCalendar" :options="calendarOptions">
                <template v-slot:eventContent="arg">
                    <div class="fc-daygrid-event-dot"></div>
                    <!-- <div class="fc-event-time">{{ arg.timeText }}h:</div> -->
                    <div v-if="loadingModalId != arg.event.id" class="fc-event-title font-normal">
                        <span class="font-normal">{{ arg.timeText }}h: {{ arg.event.extendedProps.cidade }} (DF)</span>
                        <br />
                        {{ arg.event.title }}
                    </div>
                    <div v-else>
                        <div>Carregando...</div>
                        <div>Aguarde</div>
                    </div>
                </template>
            </FullCalendarComponent>
        </div>
    </div>
</template>

<script setup>
import { parseDateTime } from "@/Utils/dateUtils";
import brLocale from "@fullcalendar/core/locales/pt-br";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import FullCalendarComponent from "@fullcalendar/vue3";
import { Head } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

const props = defineProps({ eventos: Array });

const fullCalendar = ref(null);

const handleDateClick = (arg) => {
    // alert("date click! " + arg.dateStr);
};

const loadingModalId = ref(null);
const handleEventClick = async (eventClickInfo) => {
    loadingModalId.value = eventClickInfo.event.id;
    await visitModal(`/calendario/evento-detalhes/${eventClickInfo.event.id}`, {
        config: {
            slideover: true,
            position: "right",
        },
    });
    loadingModalId.value = null;
};

const calendarOptions = ref({
    locale: brLocale,
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "title",
        center: "dayGridMonth,dayGridWeek",
        right: "prevYear,prev,next,nextYear today",
    },
    dateClick: handleDateClick,
    eventClick: handleEventClick,
});

const calendarDiv = ref(null);
let resizeObserver = null;
function calendarUpdateSize() {
    var api = fullCalendar.value.getApi();
    api.updateSize();
}

function mapEvents() {
    const eventos = props.eventos.map((x) => {
        x.title = x.artista.nome + " LONG TEXT TO BREAK 123 123 123";
        x.date = parseDateTime(x.data_hora);
        return x;
    });

    calendarOptions.value.events = eventos;
}

onMounted(() => {
    resizeObserver = new ResizeObserver((entries) => {
        for (let entry of entries) {
            calendarUpdateSize();
        }
    });

    resizeObserver.observe(calendarDiv.value);

    mapEvents();
});

onBeforeUnmount(() => {
    resizeObserver.disconnect();
});
</script>
