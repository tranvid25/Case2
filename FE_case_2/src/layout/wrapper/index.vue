<template>
    <!-- topvue -->
     <TopVue></TopVue>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <!-- menuvue -->
                 <MenuVue></MenuVue>
                <div class="span9">
                    <!-- @RenderBody() -->
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
    <!-- botvue -->
     <BotVue></BotVue>

</template>
<script>
import TopVue from "../components/TopVue.vue";
import MenuVue from "../components/MenuVue.vue";
import BotVue from "../components/BotVue.vue";

import "../../assets/Scripts/jquery-1.9.1.min.js";
import "../../assets/Scripts/jquery-ui-1.10.1.custom.min.js";
import "../../assets/bootstrap/js/bootstrap.min.js";
import "../../assets/Scripts/flot/jquery.flot.js";
import "../../assets/Scripts/flot/jquery.flot.resize.js";
import "../../assets/Scripts/datatables/jquery.dataTables.js";
import "../../assets/Scripts/common.js";
export default {
    name: "wrapper",
    components: {
        TopVue,
        MenuVue,
        BotVue,
    },
}
</script>
<style>
@import "../../assets/bootstrap/css/bootstrap.min.css";
@import "../../assets/bootstrap/css/bootstrap-responsive.min.css";
@import "../../assets/css/theme.css";
@import "../../assets/images/icons/css/font-awesome.css";
@import url("http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600");
</style>