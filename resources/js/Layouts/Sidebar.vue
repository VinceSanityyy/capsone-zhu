
<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <img src="Images/Logo.png" alt="" width="215" height="200" align = "center">
                <!-- <span class="align-middle">AdminPanel</span> -->
            </a>

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
                                <i class="bi bi-bar-chart-steps"></i><span class="align-middle">Overview</span>
                                </Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link " href="/admin/schedules">
                                <i class="bi bi-calendar-check"></i><span class="align-middle">Scheduling</span>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#charts" data-bs-toggle="collapse" class="sidebar-link collapsed"
                            aria-expanded="false">
                            <i class="bi bi-people"></i> <span class="align-middle">User Management <i
                                    class="bi bi-caret-down-fill" style="float: right;"></i></span>
                        </a>
                        <ul id="charts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
                            <li class="sidebar-item">
                                <Link class="sidebar-link" href="/admin/users-pending">
                                <i class="bi bi-person-dash-fill"></i><span class="align-middle">Pending Users</span>
                                </Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link " href="/admin/users">
                                <i class="bi bi-person-check-fill"></i><span class="align-middle">Approved Users</span>
                                </Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link " href="/admin/users/create">
                                <i class="bi bi-person-plus-fill"></i><span class="align-middle">Add New User</span>
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
                        <i class="bi bi-exclamation-triangle"></i> <span class="align-middle">Announcements</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="/admin/reports">
                        <i class="bi bi-graph-up"></i><span class="align-middle">Reports</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="/admin/logs">
                            <i class="bi bi-box-arrow-in-right"></i><span class="align-middle">Logs</span>
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
                            </svg> <span class="align-middle">Receipts <i class="bi bi-caret-down-fill"
                                    style="float: right;"></i></span>
                        </a>
                        <ul id="reports-menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar"
                            style="">
                            <li class="sidebar-item ">
                                <a class="sidebar-link" target="_blank" href="/admin/receipts/final-adviser-fee/generate">
                                    <i class="bi bi-file-earmark-medical-fill"></i>
                                    <span class="align-middle">Final Adviser's Fee</span>
                                </a>
                            </li>
                            <li class="sidebar-item ">
                                <a class="sidebar-link" href="#" @click="generateDefenseReciepts">
                                    <i class="bi bi-file-earmark-medical-fill"></i>
                                    <span class="align-middle">Defense Receipts</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item ">
                        <a class="sidebar-link" href="/admin/papers/archived">
                            <i class="bi bi-exclamation-triangle"></i><span class="align-middle">Archived Papers</span>
                        </a>
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

                    <li class="sidebar-header">
                        Panel Menu
                    </li>

                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Dashboard</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/panel/panelled-papers">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Students Under Evaluation</span>
                        </Link>
                    </li>
                </div>

                <div v-if="$page.props.user.roles.includes('adviser')">

                    <li class="sidebar-header">
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
        console.log('Selected Stage:', stage);
        window.open(`/admin/receipts/generate/${stage}`, '_blank');
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
    background: #af2532;
}

/* Sidebar Brand */
.sidebar-brand {
    color: black;
}

.sidebar-brand:hover {
    color: black;
    /* Change the color to white on hover */
}

/* Sidebar Links and Anchor Links */
.sidebar-link,
a.sidebar-link {
    background: #af2532;
    color: white;
    font-weight: bold;
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
    background: #af2532;
}

/* Sidebar Icons and SVGs */
.sidebar-link i,
.sidebar-link svg,
a.sidebar-link i,
a.sidebar-link svg {
    color: white;
    margin-right: 0.75rem;
    transition: color 0.3s;
    /* Add a smooth color transition */
}

/* Hover styles for icons */
.sidebar-link:hover i,
.sidebar-link:hover svg,
a.sidebar-link:hover i,
a.sidebar-link:hover svg {
    color: #fff;
    /* Change the color on hover */
}

/* Background color and border styles on hover */
.sidebar-link:hover {
    background: #e0ba1f;
    color: #fff;
    border-left-color: black;
}

.sidebar-item.active .sidebar-link:hover,
.sidebar-item.active>.sidebar-link {
    border-left-color: black;
    color: #af2532;
}
.span{

    text-align:right;
}
</style>
