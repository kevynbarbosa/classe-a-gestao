<template>
    <Head title="Artistas" />

    <div class="surface-card">
        <DataTable :value="artistas" tableStyle="min-width: 50rem">
            <Column field="nome" header="Nome"></Column>
        </DataTable>
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";

defineProps({ artistas: Array });
</script>
