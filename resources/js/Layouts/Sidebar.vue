
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
                        <Link class="sidebar-link" href="/dashboard">
                            <i class="bi bi-bar-chart-line"></i><span
                                class="align-middle">Dashboard</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link " href="/admin/users">
                            <i class="bi bi-people"></i><span class="align-middle">User
                                Management</span>
                        </Link>
                    </li>
                    <li class="sidebar-item ">
                        <Link class="sidebar-link" href="pages-profile.html">
                            <i class="bi bi-journal-check"></i> <span class="align-middle">Submission
                                List</span>
                        </Link>
                    </li>
                </div>
                <div v-if="$page.props.user.roles.includes('student')">

                    <li class="sidebar-header">
                        Student Menu
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                            <i class="bi bi-bar-chart-line"></i><span
                                class="align-middle">Student Dashboard</span>
                        </Link>
                    </li>
                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="my-submissions">
                            <i class="bi bi-list-ul"></i> <span
                                class="align-middle">Submission</span>
                        </Link>
                    </li>
                </div>

                <div v-if="$page.props.user.roles.includes('faculty')">

                    <li class="sidebar-header">
                        Faculty Menu
                    </li>

                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/dashboard">
                            <i class="bi bi-bar-chart-line"></i><span
                                class="align-middle">Faculty Dashboard</span>
                        </Link>
                    </li>

                    <li class="sidebar-item">
                        <Link class="sidebar-link" href="/students-list">
                            <i class="bi bi-bar-chart-line"></i><span class="align-middle">Students List</span>
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