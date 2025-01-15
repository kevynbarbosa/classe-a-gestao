<template>
    <div class="card">
        <Timeline :value="evento?.historico">
            <template #opposite="slotProps">
                <small class="text-surface-500 dark:text-surface-400">
                    {{ dateTimeLocale(slotProps.item.created_at) }}
                </small>
            </template>
            <template #content="slotProps">
                <div class="font-bold">
                    {{ findEnumValue(evento_status_enum, slotProps.item?.status_atual) }}
                </div>
            </template>
        </Timeline>
    </div>
</template>

<script setup>
import { dateTimeLocale } from "@/Utils/dateUtils";
import { findEnumValue } from "@/Utils/enumUtils";
import { ref } from "vue";

const props = defineProps({ evento: Object, evento_status_enum: Array });

const events = ref([
    { status: "Ordered", date: "15/10/2020 10:30", icon: "pi pi-shopping-cart", color: "#9C27B0" },
    { status: "Processing", date: "15/10/2020 14:00", icon: "pi pi-cog", color: "#673AB7" },
    { status: "Shipped", date: "15/10/2020 16:15", icon: "pi pi-shopping-cart", color: "#FF9800" },
    { status: "Delivered", date: "16/10/2020 10:00", icon: "pi pi-check", color: "#607D8B" },
]);
</script>
