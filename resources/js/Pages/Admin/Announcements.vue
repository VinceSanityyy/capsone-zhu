<template>
    <MainLayout>
        <h1 class="h3 mb-3">Announcements Panel</h1>
        <div class="row">
            <div class="col-12 text-end"> <!-- Use "text-end" class to align to the right -->
                <Link href="/admin/announcements/create" class="btn um-button mb-3">Add Announcement</Link>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <DataTable class="display" ref="table" :data="announcements" :columns="columns">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Created By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <!-- <tbody>
                                    <tr v-for="announcement in announcements" :key="announcement.id">
                                        <td>{{ announcement.title}}</td>
                                        <td>{{ announcement.content }}</td>
                                        <td>{{ announcement.user.name }}</td>
                                        <td>
                                            <button @click="deleteAnnoucement(announcement.id)" class="btn um-button">Delete</button>
                                        </td>
                                    </tr>
                                </tbody> -->
                            </DataTable>
                    </div>
                </div>
            </div>
        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import alertify from 'alertifyjs';
import DataTable from 'datatables.net-vue3';
import { useToast } from "vue-toastification";
import { onUnmounted, ref, onMounted} from 'vue'
const toast = useToast();

const props = defineProps({
    announcements: Array
})


const columns = [
    { data: 'title' },
    { data: 'content' },
    { data: 'user.name' },
    {
        data: null,
        render: function (data, type, row) {
            return `<button id="del" data-attribute="${data.id}" class="btn announcement-del um-button">Delete</button>`;
        },
    },
];




onMounted(() => {
const buttons = document.getElementsByClassName('announcement-del');
  for (const button of buttons) {
    button.addEventListener('click', () => {
      alertify.confirm('Notice', 'Delete announcement?', () => {
        router.delete(`/admin/announcements/${button.dataset.attribute}/delete`,{
            onSuccess: () => {
                toast.success('Announcement deleted successfully');
                 window.location.reload()
            },
            onError: () => {
                alertify.error('Announcement not deleted');
            }
        })
    },() => console.log('cancelled'));
    });
  }  
})

onUnmounted(() =>{
    console.log('unmounted')
    alertify.confirm().destroy()
})
</script>