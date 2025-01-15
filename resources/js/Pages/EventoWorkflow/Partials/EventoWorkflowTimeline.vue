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

const props = defineProps({ evento: Object, evento_status_enum: Array });
</script>
