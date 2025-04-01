<template>
    <div class="rounded bg-slate-200 p-2 hover:bg-slate-300">
        <div class="flex gap-2">
            <i class="mdi mdi-file" style="font-size: 3rem"></i>
            <div>
                <div>{{ label }}</div>
                <div class="text-sm font-light">Selecione o formato desejado</div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 pt-4">
            <Button
                v-if="docxLink"
                label="Word"
                icon="mdi mdi-microsoft-word"
                size="small"
                @click="download(docxLink)"
            />
            <Button v-if="pdfLink" label="PDF" icon="mdi mdi-file-pdf-box" size="small" @click="download(pdfLink)" />
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    docxLink: {
        type: String,
        required: false,
    },
    pdfLink: {
        type: String,
        required: false,
    },
});

function download(link) {
    const url = link;
    if (url) {
        window.open(url, "_blank");
    }
}
</script>
