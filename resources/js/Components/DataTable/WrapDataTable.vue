<template>
    <DataTable
        v-model:filters="filters"
        :filterDisplay="filterDisplay"
        :rowsPerPageOptions="rowsPerPageOptions"
        :value="resourceObject?.data"
        :totalRecords="resourceObject?.meta?.total"
        :first="resourceObject?.meta?.from"
        :rows="resourceObject?.meta?.per_page"
        :sort-field="sortField"
        :sort-order="sortOrder"
        :loading="loading"
        paginator
        lazy
        @page="pageUpdate"
        @sort="pageUpdate"
        @filter="pageUpdate"
        v-bind="{ ...$attrs, ...$slots }"
    >
        <slot />

        <template #paginatorstart>
            <!-- Nada aqui, apenas para centralizar a paginação -->
        </template>

        <template #paginatorend>Total: {{ resourceObject?.meta?.total }}</template>
    </DataTable>
</template>

<script setup>
defineProps({
    resourceObject: {
        type: Object,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    rowsPerPageOptions: {
        type: Array,
        default: [5, 10, 20, 50],
    },
    filterDisplay: {
        type: String,
        default: "row",
    },
});

const emits = defineEmits(["pageUpdate"]);

const filters = defineModel("filters");

const sortField = route().queryParams.sort?.replace("-", "");
const sortOrder = route().queryParams.sort?.substring(0, 1) == "-" ? -1 : 1;

function serialize(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

function filterQueryString(obj) {
    const queryString = Object.entries(obj)
        .map(([key, val]) => {
            return `filter[${key}]=${val.value ?? ""}`; // Se o valor for `null`, substituímos por uma string vazia.
        })
        .join("&");

    return queryString;
}

function pageUpdate(params) {
    var queryObject = {};
    var filter = "";

    if (params.page) {
        queryObject.page = params.page + 1 || 0;
    }

    if (params.rows) {
        queryObject.perPage = params.rows;
    }

    if (params.sortField) {
        const sortOrderPrefix = params.sortOrder == -1 ? "-" : "";
        queryObject.sort = sortOrderPrefix + params.sortField;
    }

    const queryString = serialize(queryObject);
    if (params.filters) {
        filter = filterQueryString(params.filters);
    }

    emits("pageUpdate", queryString + "&" + filter);
}
</script>
