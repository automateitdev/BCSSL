require("./bootstrap");

window.Vue = require("vue").default;

import Vuelidate from "vuelidate";

//mixins
import CommonMixin from "./mixins/commonMixin.js";

//Multiselect install
import Multiselect from "vue-multiselect";
// register globally
Vue.component("multiselect", Multiselect);

Vue.use(Vuelidate);
Vue.mixin(CommonMixin);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("member-register", () =>
    import("./components/pages/auth/MemberRegister.vue")
);

Vue.component("member-edit", () =>
    import("./components/pages/auth/MemberEdit.vue")
);
// *** member panel
Vue.component("member-infos", () =>
    import("./components/pages/member/MemberInfos.vue")
);

// *** admin panel
Vue.component("user-create", () =>
    import("./components/pages/admin/core-setting/user/UserCreate.vue")
);

const app = new Vue({
    el: "#app",
});
