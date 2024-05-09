Nova.booting((Vue, router) => {
    Vue.component(
        "nova-date-range-intersection-filter",
        require("./components/NovaDateRangeIntersectionFilter.vue").default
    );
});