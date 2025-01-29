<template>
    <Modal class="h-screen" ref="modalRef">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <Tabs value="0">
            <TabList>
                <Tab value="0">Dados gerais</Tab>
                <Tab value="1">Contratante</Tab>
                <Tab value="2">Proposta</Tab>
                <Tab value="3">Observações</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <div>
                        {{ evento }}
                    </div>
                </TabPanel>
                <TabPanel value="1">
                    <p class="m-0">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto
                        beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut
                        odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                        Consectetur, adipisci velit, sed quia non numquam eius modi.
                    </p>
                </TabPanel>
            </TabPanels>
        </Tabs>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    evento: Object,
});

const titulo = "Detalhes do evento";

const variable = ref(null);
</script>
