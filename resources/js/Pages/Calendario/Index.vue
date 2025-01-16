<template>
    <div>
        <Head title="Calendário" />

        <div class="card" ref="calendarDiv">
            <!-- <TituloCard titulo="Calendário de eventos">
                <Button label="Novo evento" icon="mdi mdi-plus"></Button>
            </TituloCard> -->

            <FullCalendarComponent ref="fullCalendar" :options="calendarOptions">
                <template v-slot:eventContent="arg">
                    <div class="fc-daygrid-event-dot"></div>
                    <div
                        v-if="loadingModalId != arg.event.id"
                        :class="`fc-event-title cursor-pointer font-normal ${arg.event.backgroundColor}`"
                    >
                        <span class="font-normal">
                            {{ arg.timeText }}h: {{ arg.event.extendedProps.cidade.nome }} ({{
                                arg.event.extendedProps.cidade.uf_codigo
                            }})
                        </span>
                        <br />
                        {{ arg.event.title }}
                        <br />
                        <div class="text-wrap text-sm font-light">
                            {{ findEnumValue(evento_status_enum, arg.event.extendedProps.status) }}
                        </div>
                    </div>
                    <div v-else>
                        <div>Carregando informações</div>
                        <div>Aguarde.</div>
                    </div>
                </template>
            </FullCalendarComponent>
        </div>
    </div>
</template>

<script setup>
import { parseDateTime } from "@/Utils/dateUtils";
import { findEnumValue } from "@/Utils/enumUtils";
import brLocale from "@fullcalendar/core/locales/pt-br";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import FullCalendarComponent from "@fullcalendar/vue3";
import { Head } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

const props = defineProps({ eventos: Array, evento_status_enum: Array });

const fullCalendar = ref(null);

const handleDateClick = (arg) => {
    // alert("date click! " + arg.dateStr);
};

const loadingModalId = ref(null);
const handleEventClick = async (eventClickInfo) => {
    console.log(eventClickInfo.event);
    loadingModalId.value = eventClickInfo.event.id;
    await visitModal(`/calendario/evento-detalhes/${eventClickInfo.event.id}`, {
        config: {
            // slideover: true,
            // position: "right",
        },
    });
    loadingModalId.value = null;
};

const calendarOptions = ref({
    locale: brLocale,
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    dayMaxEventRows: true,
    headerToolbar: {
        left: "title",
        center: "dayGridMonth,dayGridWeek",
        right: "prevYear,prev,next,nextYear today",
    },
    eventColor: "#d11777",
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
        const backgroundColor = findEnumValue(props.evento_status_enum, x.status, "severitycolor");
        console.log(backgroundColor);
        x.title = x.artista.nome;
        x.date = parseDateTime(x.data_hora);
        x.backgroundColor = `bg-${backgroundColor} rounded p-1`;
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

<style>
.fc .fc-popover {
    z-index: 20 !important;
}
</style>
