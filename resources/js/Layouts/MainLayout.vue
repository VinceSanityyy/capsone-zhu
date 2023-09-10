<template>
    <div class="wrapper">
        <Sidebar/>
        <div class="main">
            <Navbar/>
            <main class="content">
                <div class="container-fluid p-0">
                    <slot/>
                </div>
            </main>
            <Footer/>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';
import Footer from './Footer.vue'


export default {
    setup() {
        
    },
    components:{
        Navbar, Sidebar, Footer
    }
}
</script>