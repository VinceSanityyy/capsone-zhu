
<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <img src="https://crms.umin.edu.ph/images/logo.jpg" alt="" width="200" height="50" class="border">
                <!-- <span class="align-middle">AdminPanel</span> -->
            </a>

            <ul class="sidebar-nav">
                <div v-if="$page.props.user.roles.includes('admin')">
                    <li class="sidebar-header">
                        Admin Menu
                    </li>
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
                                <Link class="sidebar-link " href="/calendar">
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
                        </ul>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="pages-profile.html">
                        <i class="bi bi-journal-check"></i> <span class="align-middle">Submission
                            List</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="pages-profile.html">
                        <i class="bi bi-exclamation-triangle"></i> <span class="align-middle">Announcements</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="pages-profile.html">
                        <i class="bi bi-exclamation-triangle"></i><span class="align-middle">Reports</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="pages-profile.html">
                        <i class="bi bi-exclamation-triangle"></i><span class="align-middle">Forms</span>
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
                        <Link class="sidebar-link" href="/account">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Account Details</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="my-submissions">
                        <i class="bi bi-list-ul"></i> <span class="align-middle">Submission</span>
                        </Link>
                    </li>
                </div>

                <div v-if="$page.props.user.roles.includes('faculty')">

                    <li class="sidebar-header">
                        Faculty Menu
                    </li>

                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                        <i class="bi bi-bar-chart-line"></i><span class="align-middle">Faculty Dashboard</span>
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

            </ul>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

</script>
<style scoped>
/* Sidebar and Sidebar Content */
.sidebar,
.sidebar-content {
    background: #fff;
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
    background: #fff;
    color: black;
    font-weight: bold;
}

/* Sidebar Header */
.sidebar-header {
    color: black;
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
    color: #af2532;
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
    background: #af2532;
    color: #fff;
    border-left-color: black;
}

.sidebar-item.active .sidebar-link:hover,
.sidebar-item.active>.sidebar-link {
    border-left-color: black;
    color: #e9ecef;
}
</style>