<template>
    <div class="flex gap-2 rounded p-2 hover:bg-primary/10">
        <div class="flex flex-col items-center gap-1 rounded bg-primary/20 p-1 text-2xl font-bold">
            <div>{{ new Date(evento.data_hora).getDate() }}</div>
            <div>
                {{
                    new Intl.DateTimeFormat("default", { month: "short" })
                        .format(new Date(evento.data_hora))
                        .toUpperCase()
                }}
            </div>
        </div>

        <div class="flex flex-col">
            <div class="text-lg font-bold">{{ evento.artista.nome }}</div>
            <div>
                <i class="mdi mdi-map-marker"></i>
                Em {{ evento.cidade.nome }} ({{ evento.recinto }})
            </div>
            <div class="font-light">{{ evento.contratante.nome_completo }}</div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    evento: Object,
});

const variable = ref(null);
</script>
