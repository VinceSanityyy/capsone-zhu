
<template>
    <br><br>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html" >
                <img src="/Images/banner.png" alt="Logo" style = "height:250px;padding: 0px;">
                <!-- <span class="align-middle">AdminPanel</span> -->
            </a><br>

            <ul class="sidebar-nav">
                <div v-if="$page.props.user.roles.includes('admin')">
                    
                    <li class="sidebar-item">
                        <a data-bs-target="#dashboard-menu" data-bs-toggle="collapse" class="sidebar-link collapsed"
                            aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bar-chart-2 align-middle">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg> <span class="align-middle">Dashboard Menu <i class="bi bi-caret-down-fill"
                                    style="float: right;"></i></span>
                        </a>
                        <ul id="dashboard-menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar"
                            style="">
                            <li class="sidebar-item">
                                <Link class="sidebar-link" href="/dashboard">
                                <i class="bi bi-bar-chart-steps" style = "padding-left: 50px;"></i><span class="align-middle">Overview</span>
                                </Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link " href="/admin/schedules">
                                <i class="bi bi-calendar-check" style = "padding-left: 50px;"></i><span class="align-middle">Scheduler</span>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#charts" data-bs-toggle="collapse" class="sidebar-link collapsed"
                            aria-expanded="false">
                            <i class="bi bi-people"></i> <span class="align-middle">&nbsp;User Management <i
                                    class="bi bi-caret-down-fill" style="float: right;"></i></span>
                        </a>
                        <ul id="charts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
                            <li class="sidebar-item">
                                <Link class="sidebar-link" href="/admin/users-pending">
                                <i class="bi bi-person-dash-fill" style = "padding-left: 50px;"></i><span class="align-middle">Pending Users</span>
                                </Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link " href="/admin/users">
                                <i class="bi bi-person-check-fill" style = "padding-left: 50px;"></i><span class="align-middle">Approved Users</span>
                                </Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link " href="/admin/users/create">
                                <i class="bi bi-person-plus-fill" style = "padding-left: 50px;"></i><span class="align-middle">Add New User</span>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="sidebar-item ">
                        <Link class="sidebar-link" href="pages-profile.html">
                        <i class="bi bi-journal-check"></i> <span class="align-middle">Submission
                            List</span>
                        </Link>
                    </li> -->
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="/admin/announcements">
                        <i class="bi bi-exclamation-triangle"></i> <span class="align-middle">&nbsp;Announcements</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="/admin/reports">
                        <i class="bi bi-graph-up"></i><span class="align-middle">&nbsp; Reports</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#reports-menu" data-bs-toggle="collapse" class="sidebar-link collapsed"
                            aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bar-chart-2 align-middle">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg> <span class="align-middle"> Generate Receipt <i class="bi bi-caret-down-fill"
                                    style="float: right;"></i></span>
                        </a>
                        <ul id="reports-menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar"
                            style="">
                            <li class="sidebar-item ">
                                <a class="sidebar-link" target="_blank" href="/admin/receipts/final-adviser-fee/generate">
                                    <i class="bi bi-file-earmark-medical-fill" style = "padding-left: 50px;"></i>
                                    <span class="align-middle">Final Adviser's Fee</span>
                                </a>
                            </li>
                            <li class="sidebar-item ">
                                <a class="sidebar-link" href="#" @click="generateDefenseReciepts">
                                    <i class="bi bi-file-earmark-medical-fill" style = "padding-left: 50px;"></i>
                                    <span class="align-middle">Defense Receipts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="/admin/logs">
                            <i class="bi bi-box-arrow-in-right"></i><span class="align-middle">&nbsp; Logs</span>
                        </Link>
                    </li>
                    

                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="/admin/papers/archived">
                            <i class="bi bi-exclamation-triangle"></i><span class="align-middle">&nbsp; Archived Papers</span>
                        </Link>
                    </li>
                </div>
                <div v-if="$page.props.user.roles.includes('student')">

                    <li class="sidebar-header">
                        Student Menu
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Student Dashboard</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/student/schedules">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Schedules</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/student/my-submissions">
                        <i class="bi bi-list-ul"></i> <span class="align-middle">My Submissions</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/student/forms">
                        <i class="bi bi-list-ul"></i> <span class="align-middle">Downloadable Forms</span>
                        </Link>
                    </li>
                </div>

                <div v-if="$page.props.user.roles.includes('faculty')">

                    <li class="sidebar-header">
                        Faculty Menu
                    </li>

                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Dashboard</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/account-details">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Account Details</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/students-list">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Submissions</span>
                        </Link>
                    </li>
                </div>

                <div v-if="$page.props.user.roles.includes('panel')">

                    <li class="sidebar-header" style = "color:#090c29;">
                        Panel Menu
                    </li>

                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Dashboard</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/panel/panelled-papers">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Under Evaluation</span>
                        </Link>
                    </li>
                </div>

                <div v-if="$page.props.user.roles.includes('adviser')">

                    <li class="sidebar-header" style = "color:#090c29;">
                        Adviser Menu
                    </li>
                    <!-- <li class="sidebar-item">
                        <Link class="sidebar-link" href="/account-details">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Account Details</span>
                        </Link>
                    </li> -->
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/adviser/advised-papers">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Advisees</span>
                        </Link>
                    </li>
                </div>

            </ul>
            <div class="navbot">
                <a class="sidebar-brand" href="index.html" >
                <img id = "pic" src="Images/bot.png" alt="" style = "height:190px;padding: 0px;">
                <!-- <span class="align-middle">AdminPanel</span> --></a></div>
        </div>
        
    </nav>
</template>



<script setup>
import { Link } from '@inertiajs/vue3'
import { onUnmounted } from 'vue'
const toast = useToast();
import { useToast } from "vue-toastification";

const generateDefenseReciepts = () => {
    console.log('clicked')
    alertify.confirm('Select Stage', '',
        () => {
            const stage = document.getElementById('stage').value;
            const from = document.getElementById('start_date').value;
            const to = document.getElementById('end_date').value;

            if(stage == '' || from == '' || to == ''){
                toast.error('Please fill up all fields')
                return;
            }
            window.open(`/admin/receipts/generate/${stage}/${from}/${to}`, '_blank');
        },
        () => {
            console.log('cancel')
            toast.error('Action Cancelled')
        }).setContent(
            `
        <select id="stage" class="form-select mb-3">
          <option selected="" disabled>Open this select menu</option>
          <option value="title_defense">Title Defense</option>
          <option value="outline_defense">Outline Defense</option>
          <option value="final_defense">Final Defense</option>
        </select>

        <div class="row">
            <div class="col">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" class="form-control">
            </div>
            <div class="col">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" class="form-control">
            </div>
        `
        )
}
onUnmounted(() => {
    alertify.confirm().destroy()
})
</script>
<style scoped>
/* Sidebar and Sidebar Content */
.sidebar,
.sidebar-content {
    background: white;

}

.sidebar-brand{
color: #f8f9fa;
    display: block;
    font-size: 1.15rem;
    font-weight: 600;
    padding: 0rem 0rem;
}
.simplebar-tracksimplebar-vertical{
 background-color: #af2532;

}
/* Sidebar Links and Anchor Links */
.sidebar-link,
a.sidebar-link {
    background: white;
    color: #090c29;
    font-weight: bold;
    font-family:sans-serif;
}

/* Sidebar Header */
.sidebar-header {
    color: white;
}

/* Active Sidebar Item */
.sidebar-item.active>.sidebar-link,
.sidebar-item.active .sidebar-link:hover,
.sidebar-item.active>.sidebar-link {
    border-left-color: black;
    color: #fff;
    background: white;
}

/* Sidebar Icons and SVGs */
.sidebar-link i,
.sidebar-link svg,
a.sidebar-link i,
a.sidebar-link svg {
    color: #090c29;
    margin-right: 0.90rem;
    
    transition: color 0.1s;
    /* Add a smooth color transition */
}

/* Hover styles for icons */
.sidebar-link:hover i,
.sidebar-link:hover svg,
a.sidebar-link:hover i,
a.sidebar-link:hover svg {
    color: white;
    /* Change the color on hover */
}

/* Background color and border styles on hover */
.sidebar-link:hover {
    background: #00558D;
    color: white;
    border-left-color: black;
}

.sidebar-item.active .sidebar-link:hover,
.sidebar-item.active>.sidebar-link {
    border-left-color: black;
    color: #090c29;
}
.span{

    text-align:right;
}
</style>
