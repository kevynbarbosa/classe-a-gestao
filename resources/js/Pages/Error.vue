<template>
    <div></div>
</template>

<script setup>
import { useToast } from "primevue/usetoast";
import { computed } from "vue";

const props = defineProps({ status: Number });

const toast = useToast();

const title = computed(() => {
    return {
        503: "503: Service Unavailable",
        500: "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
    }[props.status];
});

const description = computed(() => {
    return {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500: "Whoops, something went wrong on our servers.",
        404: "Sorry, the page you are looking for could not be found.",
        403: "Sorry, you are forbidden from accessing this page.",
    }[props.status];
});

const showError = () => {
    toast.add({ severity: "error", summary: title.value, detail: description.value });
};

showError();
</script>
