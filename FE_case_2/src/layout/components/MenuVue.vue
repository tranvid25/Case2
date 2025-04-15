<template>
    <div class="span3">
        <div class="sidebar">
            <ul class="widget widget-menu unstyled">
                <li class="active">
                    <a href="/dashboard">
                        <i class="menu-icon icon-dashboard"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="/personals"><i class="menu-icon icon-bullhorn"></i>Personal List </a>
                </li>
                <li>
                    <a href="/benefit-plans">
                        <i class="menu-icon icon-tasks"></i>Benefit Plans
                    </a>
                </li>
                <li>
                    <a href="/job-history">
                        <i class="menu-icon icon-inbox"></i>Job History
                    </a>
                </li>
            </ul>
            <ul class="widget widget-menu unstyled">
                <li>
                    <a class="collapsed" data-toggle="collapse" href="#togglePages">
                        <i class="menu-icon icon-cog">
                        </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                        </i>More Pages
                    </a>
                    <ul id="togglePages" class="collapse unstyled">
                        <li><a href="#"><i class="icon-inbox"></i>Login </a></li>
                        <li><a href="#"><i class="icon-inbox"></i>Profile </a></li>
                        <li><a href="#"><i class="icon-inbox"></i>All Users </a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="menu-icon icon-signout"></i>Logout </a></li>
            </ul>
        </div>
        <!--/.sidebar-->
    </div>
</template>
<script>
export default {
    // data() {
    //     return {
    //         personalData: null,
    //         employeeData: null
    //     };
    // },
    // mounted() {
    //     // Lấy dữ liệu từ API "personals"
    //     axios.get('http://localhost:19335/api/personals')
    //         .then(response => {
    //             this.personalData = response.data;
    //         })
    //         .catch(error => {
    //             console.error("Có lỗi khi lấy dữ liệu từ API 'personals'", error);
    //         });

    //     // Lấy dữ liệu từ API "employees"
    //     axios.get('http://127.0.0.1:8000/api/employees')
    //         .then(response => {
    //             this.employeeData = response.data;
    //         })
    //         .catch(error => {
    //             console.error("Có lỗi khi lấy dữ liệu từ API 'employees'", error);
    //         });
    // }
}
</script>
<style></style>