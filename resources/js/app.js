import './bootstrap';
import "../adminKit/dist/js/app.js";
import "../adminKit/dist/css/app.css";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy";
import { Ziggy } from "./ziggy";
import VueFusionCharts from "vue-fusioncharts";
import FusionCharts from "fusioncharts";
import Column2D from "fusioncharts/fusioncharts.charts";
import FusionTheme from "fusioncharts/themes/fusioncharts.theme.fusion";

import alertify from "alertifyjs";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import Select from "datatables.net-select";
import "datatables.net-dt";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import CKEditor from '@ckeditor/ckeditor5-vue';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueFusionCharts, FusionCharts, Column2D, FusionTheme)
            .use(DataTable.use(DataTablesCore, Select))
            .use(alertify)
            .use(CKEditor)
            .use(Toast, {
                position: "top-right",
                timeout: 5000,
                closeOnClick: false,
                pauseOnFocusLoss: true,
                pauseOnHover: false,
                draggable: false,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false,
            })
            .mount(el);
    },
});
console.log("app.js loaded");
