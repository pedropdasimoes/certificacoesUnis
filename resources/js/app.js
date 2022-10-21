require('./bootstrap');

// Import modules...
import Vue from 'vue';
import {App as InertiaApp, plugin as InertiaPlugin} from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import vMask from 'v-mask';
import { slider, slideritem, vueConciseSlider } from 'vue-concise-slider';
import {VueFlowy} from 'vue-flowy';
import BusinessHours from 'vue-business-hours';


// Fontawesome
import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {faCss3, faJs, faVuejs} from "@fortawesome/free-brands-svg-icons";
import {
    faRocket,
    faDotCircle,
    faWindowRestore,
    faEdit,
    faCalendarAlt,
    faEnvelope,
    faTasks,
    faWindowMaximize,
    faChartBar,
    faChevronDown,
    faCode,
    faAngleDown,
    faAngleUp,
    faLayerGroup,
    faGripHorizontal,
    faAngleLeft,
    faClock,
    faRetweet,
    faTags,
    faTv,
    faPlug,
    faTable,
    faShoppingBag,
    faLiraSign,
    faCheckCircle,
    faTrash,
    faBan,
    faKey,
    faUserEdit,
    faPlusCircle,
    faAngleDoubleRight,
    faPaperPlane,
    faBell,
    faIdCard,
    faFolder,
    faListUl,
    faDownload,
    faCheck, faMinusCircle, faInfo, faSave, faCog, faIdBadge, faEye, faPen,faClipboardCheck, faClipboardList, faUser, faUsers
} from '@fortawesome/free-solid-svg-icons'

library.add(faPen, faBell, faEye, faKey, faListUl, faDownload,faUserEdit, faIdCard, faFolder, faPaperPlane, faRocket, faDotCircle, faCheckCircle, faBan, faWindowRestore, faSave, faEdit, faJs, faCss3, faInfo, faCalendarAlt, faVuejs, faEnvelope, faTasks, faWindowMaximize, faChartBar, faChevronDown, faCode, faAngleDown, faAngleUp, faChartBar, faLayerGroup, faGripHorizontal, faAngleLeft, faClock, faRetweet, faTags, faTv, faPlug, faTable, faShoppingBag, faLiraSign, faTrash, faPlusCircle, faAngleDoubleRight, faCheck, faMinusCircle, faCog, faIdBadge, faClipboardCheck, faClipboardList, faUser, faUsers)
Vue.component('font-awesome-icon', FontAwesomeIcon)


Vue.mixin({methods: {route}});
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(vMask);
Vue.use(slider);
Vue.use(slideritem);
Vue.component(VueFlowy);
Vue.use(BusinessHours);

Vue.config.productionTip = false


const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        })
}).$mount(app);
