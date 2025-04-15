<template>
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Job Posts</h1>

        <EasyDataTable
            :headers="headers"
            :items="jobPosts"
            :loading="loading"
            :rows-per-page="5"
        />

        <div v-if="error" class="text-red-500 text-center mt-2">
            {{ error }}
        </div>
    </div>
</template>

<script>
import EasyDataTable from 'vue3-easy-data-table'
import axios from 'axios'

export default {
    name: 'JobList',
    components: {
        EasyDataTable
    },
    data() {
        return {
            loading: true,
            error: null,
            jobPosts: [],
            headers: [
                { text: 'Company name', value: 'company_name' },
                { text: 'ID', value: 'uid' },
                { text: 'Title', value: 'title' },
                { text: 'Description', value: 'description' },
                { text: 'View Count', value: 'view_count' },
            ],
        };
    },
    mounted() {
        this.fetchJobPosts();
    },
    methods: {
        async fetchJobPosts() {
            try {
                const res = await axios.get('/api/job-posts');
                console.log(res.data.data.jobs)
                this.jobPosts = res.data.data.jobs;
            } catch (err) {
                this.error = 'Failed to load job posts';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
